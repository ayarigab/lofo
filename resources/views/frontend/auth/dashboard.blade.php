@include('partials.frontend.header', ['title' => __('lang_v1.dashboard')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen font-sans">

    @auth('claimer')
    @include('partials.frontend.auth.navbar')

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    {{ App\Http\Controllers\Claimer\DashboardController::generateGreeting(auth('claimer')->user()->full_name) }}
                </h1>
                <p class="text-gray-600">Here's what's happening with your lost items</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="/x"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-full font-medium hover-scale">
                    Report Lost Item
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <livewire:claimer.stats-card title="Total Reports"
                :value="$lostReport"
                border-color="border-blue-500"
                color="text-blue-500"
                icon="chart-no-axes-combined" />

            <livewire:claimer.stats-card title="Items Claimed"
                :value="$claimedItems"
                border-color="border-green-500"
                color="text-green-500"
                icon="heart-handshake" />

            <livewire:claimer.stats-card title="Pending Claims"
                :value="$pendingClaims"
                border-color="border-yellow-500"
                color="text-yellow-500"
                icon="calendar-heart" />

            <livewire:claimer.stats-card title="Messages"
                :value="$messages"
                border-color="border-purple-500"
                color="text-purple-500"
                icon="message-circle-heart" />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Your Recent Lost Reports</h2>
                    <a href="/x" class="text-sm text-purple-500 hover:underline">View
                        All</a>
                </div>

                <livewire:claimer.recent-lost-reports :limit="5" />
            </div>

            <div class="bg-white rounded-3xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Quick Messages</h2>

                <div class="space-y-4">
                    @foreach($allMessages as $message)
                    <div class="bg-gray-50 p-4 rounded-xl shadow-sm">
                        <p class="text-gray-700">{{ $message->message }}</p>
                        <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Potential Matches for Your Reports</h2>
                <a href="/s" class="text-sm text-[#4F46E5] hover:underline">Browse All</a>
            </div>

            <livewire:claimer.potential-matches />
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Your Claimed Items</h2>
                <a href="#" class="text-sm text-[#4F46E5] hover:underline">View
                    All</a>
            </div>

            <livewire:claimer.claimed-items :limit="10" />
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Your Claimed Items</h2>
                <a href="#" class="text-sm text-[#4F46E5] hover:underline">View
                    All</a>
            </div>

            <div x-data="{
                                    claimItem() {
                                        @auth('claimer')
                                            window.dispatchEvent(new CustomEvent('toast-show', {
                                                detail: {
                                                    type: 'success',
                                                    message: '{{ __('lang_v1.item_added_to_claim_list') }}',
                                                    description: '{{ __('lang_v1.item_added_for_further_processing', ['item' => 'Hello']) }}'
                                                }
                                            }));
                                        @else
                                            window.dispatchEvent(new CustomEvent('toast-show', {
                                                detail: {
                                                    type: 'danger',
                                                    message: '{{ __('lang_v1.login_to_claim_item') }}',
                                                    description: '{{ __('lang_v1.to_claim_item_login_now', ['item' => 'Hello']) }}'
                                                }
                                            }));
                                        @endauth
                                    }
                                }" class="mt-10 border-t border-gray-200 pt-8 text-center">
                <button @click="claimItem"
                    class="inline-flex items-center px-8 py-3 bg-green-600 text-white rounded-full shadow-lg text-base font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-all transform hover-scale">
                    <flux:icon name="gift" />
                    {{ __('lang_v1.claim_this_item') }}
                </button>
            </div>
        </div>
    </div>
    @else
    <section class="relative bg-gray-50 p-20 text-center">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-800 mb-6">Lost & Found Portal</h1>
            <p class="text-xl text-gray-600 mb-8">Please login to access your dashboard and manage your lost items</p>
            <a href="{{ route('claimer-login') }}"
                class="bg-[#4F46E5] hover:bg-[#4338CA] text-white px-8 py-3 rounded-lg font-medium text-lg transition duration-200 inline-block">
                Login to Your Account
            </a>
        </div>
    </section>
    @endauth

    @include('partials.frontend.auth.footer')
</body>

</html>
