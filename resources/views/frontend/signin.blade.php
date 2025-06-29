@include('partials.frontend.header', ['title' => __('lang_v1.sign_in')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    @include('partials.frontend.navbar')
    <section class="relative w-full px-6 pb-0 antialiased bg-white">
        <img src="{{ asset('data-globe-hero@3x.png') }}" alt="Overlay Image"
            class="absolute inset-0 object-cover w-full h-full z-10">
        <div class="relative mx-auto max-w-7xl z-20">
            <div class="px-6 py-24 mx-auto max-w-7xl sm:px-10">
                <div class="w-full mx-auto text-left md:text-center">
                    <div class="flex inset-0 z-[99]">
                        @livewire('claim-login')
                        <div x-data="kenBurnsSlider()"
                            class="relative top-0 bottom-0 right-0 flex-shrink-0 hidden w-1/3 overflow-hidden bg-cover rounded-3xl lg:block">
                            {!! $data !!}
                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="currentSlide === index" x-transition.opacity.duration.1000ms
                                    class="kenburns-slide absolute inset-0 bg-center bg-cover" :style="`background-image: url('${slide}')`">
                                </div>
                            </template>
                            <div class="absolute inset-0 z-20 w-full h-full opacity-70 bg-gradient-to-t from-black rounded-b-3xl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.frontend.footer')
</body>

</html>
