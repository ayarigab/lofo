@include('partials.frontend.header', ['title' => __('lang_v1.post_item')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    @include('partials.frontend.navbar')
    <section class="relative bg-gray-50 p-20">
        <img src="{{ asset('data-globe-hero@3x.png') }}" alt="Overlay Image"
            class="absolute inset-0 object-cover w-full h-full z-10">
        <div class="max-w-3xl px-20 mx-auto relative z-20">
            <div>
                <h2 class="mb-6 text-3xl font-bold text-sky-900 sm:text-4xl">{{ __('lang_v1.post_an_item') }}</h2>
                <p class="mb-8 text-lg text-gray-600">{{ __('lang_v1.lets_join_hands') }}</p>

                <div class="space-y-6">
                </div>
            </div>
            @livewire('post-lost-form')
        </div>
    </section>

    @include('partials.frontend.footer')
</body>

</html>
