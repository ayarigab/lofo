@include('partials.frontend.header', ['title' => __('Sign In')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    <div class="mx-auto max-w-7xl antialiased">
        @include('partials.frontend.navbar')
    </div>
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

                        <script>
                            document.addEventListener('alpine:init', () => {
                                Alpine.data('kenBurnsSlider', () => ({
                                    currentSlide: 0,
                                    slides: [
                                        'https://wallpapers.com/images/high/vibrant-pine-branches-jpg-4ixpboo24b48qlra.webp',
                                        'https://wallpapers.com/images/high/adidas-brand-logo-on-smoke-bic7qfie10mhjg4h.webp',
                                        'https://wallpapers.com/images/hd/technology-drone-on-armchair-ra6wt9otz2n56g1g.jpg'
                                    ],
                                    interval: null,

                                    init() {
                                        this.startSlider();

                                        this.$el.addEventListener('mouseenter', () => {
                                            clearInterval(this.interval);
                                        });

                                        this.$el.addEventListener('mouseleave', () => {
                                            this.startSlider();
                                        });
                                    },

                                    startSlider() {
                                        this.interval = setInterval(() => {
                                            this.nextSlide();
                                        }, 8000);
                                    },

                                    nextSlide() {
                                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                                    }
                                }));
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.frontend.footer')
</body>

</html>
