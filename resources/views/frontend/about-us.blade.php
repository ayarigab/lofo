@include('partials.frontend.header', ['title' => __('lang_v1.about_us')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    @include('partials.frontend.navbar')
    <section class="relative bg-gray-50 p-20">
        <img src="{{ assetV('data-globe-hero@3x.png') }}" alt="Overlay Image"
            class="absolute inset-0 object-cover w-full h-full z-10">
        <div class="max-w-6xl px-6 mx-auto relative z-20">
            <div class="grid gap-12 md:grid-cols-2">
                <div>
                    <h2 class="mb-6 text-3xl font-bold text-sky-900 sm:text-4xl">{{ __('lang_v1.fill_the_form_below') }}</h2>
                    <p class="mb-8 text-lg text-gray-600">{{ __('lang_v1.we_love_to_here_from_you') }}</p>

                    <div class="space-y-6">
                        <div class="flex">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 text-white bg-sky-900 rounded-full">
                                <flux:icon name="mail" class="w-6 h-6" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-600">{{ __('lang_v1.email_address') }}</h3>
                                <p class="mt-1 text-gray-400">support@lostandfound.com</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 text-white bg-sky-900 rounded-full">
                                <flux:icon name="phone" class="w-6 h-6" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-600">{{ __('lang_v1.phone') }}</h3>
                                <p class="mt-1 text-gray-400">(024) 109-2020</p>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 text-white bg-sky-900 rounded-full">
                                <flux:icon name="map-pin" class="w-6 h-6" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-600">{{ __('lang_v1.headquarters') }}</h3>
                                <p class="mt-1 text-gray-400">123 Finder Street, Suite 100<br>San Francisco, CA 94107
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @livewire('lost-report-form')
            </div>
        </div>
    </section>

    @include('partials.frontend.footer')
</body>

</html>
