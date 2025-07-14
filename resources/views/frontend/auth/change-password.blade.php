@include('partials.frontend.header', ['title' => __('lang_v1.change_password')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen font-sans">

    @auth('claimer')
    @include('partials.frontend.auth.navbar')

    <div class="container mx-auto px-4 py-8 min-h-dvh">
        <div class="relative w-full max-w-xl mx-auto lg:mb-0">
            <div class="relative px-8 py-6 bg-white rounded-3xl shadow-xl">
                <div class="mb-12">
                    <p class="text-2xl font-semibold text-gray-800">{{ __('lang_v1.update_password') }}</p>
                    <p class="text-sm font-medium text-gray-500">{{ __('lang_v1.use_strong_password') }}</p>
                </div>
                @livewire('claimer.change-password')
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
