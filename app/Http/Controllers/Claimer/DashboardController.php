<?php

namespace App\Http\Controllers\Claimer;

use App\Http\Controllers\ClaimerAuthController;
use App\Http\Controllers\Controller;
use App\Models\LostReport;
use App\Models\ClaimedItem;
use App\Models\Message;
use App\Models\Claimer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class DashboardController extends Controller
{
    /**
     * Display the claimer dashboard with counts of lost reports, claimed items, pending claims, and messages.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        $lostReport = LostReport::where('posted_by', auth('claimer')->id())
            ->where('poster_type', 'claimer')
            ->count();

        $claimedItems = ClaimedItem::where('claimer_id', auth('claimer')->id())
            ->where('is_claimed', true)
            ->count();
        $pendingClaims = ClaimedItem::where('claimer_id', auth('claimer')->id())
            ->where('is_claimed', false)
            ->count();
        $messages = Message::where('posted_by', auth('claimer')->id())
            ->where('poster_type', 'claimer')
            ->count();
        $allMessages = Message::where('poster_type', 'claimer')
            ->where('posted_by', auth('claimer')->id())
            ->latest()
            ->take(5)
            ->get();
        return view('frontend.auth.dashboard', ['lostReport' => $lostReport, 'claimedItems' => $claimedItems, 'pendingClaims' => $pendingClaims, 'messages' => $messages, 'allMessages' => $allMessages]);
    }

    /**
     * Get the name of the authenticated claimer.
     *
     * @return \Illuminate\View\View
     */
    public static function profile()
    {
        return view('frontend.auth.profile', [
            'name' => auth('claimer')->user()->full_name,
            'email' => auth('claimer')->user()->email,
            'phone' => auth('claimer')->user()->phone,
            'address' => auth('claimer')->user()->address,
        ]);
    }

    /**
     * Get the change password page for the claimer.
     *
     * @return \Illuminate\View\View
     */
    public function changePassword()
    {
        return view('frontend.auth.change-password');
    }

    /**
     * Get the settings page for the claimer.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        return view('frontend.auth.settings');
    }

    /**
     * Verify the password for the claimer before allowing account deletion.
     *
     * Implements rate limiting and timing attack protection.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordVerify(Request $request)
    {
        $executed = RateLimiter::attempt(
            'password-verify:' . request()->ip(),
            $perMinute = 3,
            function () {}
        );

        if (!$executed) {
            return response()->json([
                'status' => 'error',
                'message' => __('lang_v1.too_many_attempts'),
                'description' => __('lang_v1.process_failed')
            ], 429);
        }

        if (!auth('claimer')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => __('lang_v1.unauthorized_access'),
                'description' => __('lang_v1.you_must_be_logged_in_to_perform_this_action')
            ], 401);
        }

        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $claimer = Claimer::findOrFail(auth('claimer')->id());

        $isValid = Hash::check($request->input('password'), $claimer->password);

        usleep(500000 + random_int(0, 200000));

        if ($isValid) {
            $request->session()->put('password_verified_at', now()->addMinutes(5)->timestamp);

            return response()->json([
                'status' => 'success',
                'verified' => true
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => __('lang_v1.incorrect_password'),
            'verified' => false,
            'attempts_remaining' => RateLimiter::remaining('password-verify:' . request()->ip(), $perMinute)
        ], 422);
    }

    /**
     * Get the delete account page for the claimer.
     *
     * @return \Illuminate\View\View
     */
    public function deleteAccount(Request $request)
    {
        if (!auth('claimer')->check()) {
            return redirect()->route('claimer-login')->with('toast', [
                'type' => 'danger',
                'message' => __('lang_v1.unauthorized_access'),
                'description' => __('lang_v1.you_must_be_logged_in_to_perform_this_action')
            ]);
        }
        if (
            !$request->session()->get('password_verified_at') ||
            $request->session()->get('password_verified_at') < now()->timestamp
        ) {
            return back()->with('toast', [
                'type' => 'danger',
                'message' => __('lang_v1.verification_required'),
                'description' => __('lang_v1.verify_your_identity')
            ]);
        }
        $deleteAccount = Claimer::findOrFail(auth('claimer')->id())->delete();
        if ($deleteAccount) {
            session()->now('toast', [
                'type' => 'info',
                'message' => __('lang_v1.account_deleted'),
                'description' => __('lang_v1.your_account_has_been_deleted_successfully')
            ]);
            $request->session()->forget('password_verified_at');
            ClaimerAuthController::logout(request());
        }
    }

    /**
     * Generate a personalized greeting based on the current time, day of the week, and holidays.
     *
     * @param string $name The name of the user to greet.
     * @return string A personalized greeting message.
     */
    public static function generateGreeting($name)
    {
        $hour = date('G');
        $dayOfWeek = date('N');
        $isWeekend = ($dayOfWeek >= 6);
        $currentDate = date('m-d');

        $timeGreetings = [
            'morning' => [
                __('lang_v1.good_morning', ['name' => $name]),
                __('lang_v1.rise_and_shine', ['name' => $name]),
                __('lang_v1.morning', ['name' => $name]),
                __('lang_v1.hello', ['name' => $name]),
                __('lang_v1.top_of_the_morning', ['name' => $name])
            ],
            'afternoon' => [
                __('lang_v1.good_afternoon', ['name' => $name]),
                __('lang_v1.afternoon', ['name' => $name]),
                __('lang_v1.hello_there', ['name' => $name]),
                __('lang_v1.hi', ['name' => $name]),
                __('lang_v1.afternoon_vibe', ['name' => $name])
            ],
            'evening' => [
                __('lang_v1.good_evening', ['name' => $name]),
                __('lang_v1.evening', ['name' => $name]),
                __('lang_v1.how_was_your_day', ['name' => $name]),
                __('lang_v1.time_to_unwind', ['name' => $name]),
                __('lang_v1.beautiful_evening', ['name' => $name]),
                __('lang_v1.evening_greetings', ['name' => $name])
            ],
            'night' => [
                __('lang_v1.good_night', ['name' => $name]),
                __('lang_v1.night_owl', ['name' => $name]),
                __('lang_v1.working_late_tonight', ['name' => $name]),
                __('lang_v1.still_awake', ['name' => $name]),
                __('lang_v1.sweet_dreams', ['name' => $name])
            ]
        ];

        $holidayGreetings = [
            '12-24' => [
                __('lang_v1.christmas_eve', ['name' => $name]),
                __('lang_v1.ho_ho_ho', ['name' => $name])
            ],
            '12-25' => [
                __('lang_v1.merry_christmas', ['name' => $name]),
                __('lang_v1.christmas_blessings', ['name' => $name])
            ],
            '01-01' => [
                __('lang_v1.happy_new_year', ['name' => $name]),
                __('lang_v1.cheers_to_a_new_year', ['name' => $name])
            ],
            '02-14' => [
                __('lang_v1.happy_valentine', ['name' => $name]),
                __('lang_v1.sending_you_love', ['name' => $name])
            ],
            '10-31' => [
                __('lang_v1.happy_halloween', ['name' => $name]),
                __('lang_v1.trick_or_treat', ['name' => $name])
            ],
            '11-28' => [
                __('lang_v1.happy_thanksgiving', ['name' => $name]),
                __('lang_v1.gobble_up', ['name' => $name])
            ],
            '12-31' => [
                __('lang_v1.new_year_eve', ['name' => $name]),
                __('lang_v1.see_you_next_year', ['name' => $name])
            ]
        ];

        $weekendGreetings = [
            __('lang_v1.happy_weekend', ['name' => $name]),
            __('lang_v1.weekend_vibes', ['name' => $name]),
            __('lang_v1.enjoying_your_weekend', ['name' => $name]),
            __('lang_v1.weekend_plans', ['name' => $name]),
            __('lang_v1.relax_and_enjoy', ['name' => $name])
        ];

        if (array_key_exists($currentDate, $holidayGreetings)) {
            $greetings = $holidayGreetings[$currentDate];
            return $greetings[array_rand($greetings)];
        }

        if ($isWeekend) {
            return $weekendGreetings[array_rand($weekendGreetings)];
        }

        if ($hour >= 5 && $hour < 12) {
            $greetings = $timeGreetings['morning'];
        } elseif ($hour >= 12 && $hour < 17) {
            $greetings = $timeGreetings['afternoon'];
        } elseif ($hour >= 17 && $hour < 22) {
            $greetings = $timeGreetings['evening'];
        } else {
            $greetings = $timeGreetings['night'];
        }

        return $greetings[array_rand($greetings)];
    }

}
