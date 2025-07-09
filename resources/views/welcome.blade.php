
@include('partials.frontend.header', ['title' => __('lang_v1.home')])
<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    <section class="w-full px-6 pb-0 antialiased bg-white particles-js" id="particles-js">
        @include('partials.frontend.navbar')
        <div class="mx-auto max-w-7xl pjs-ontop">

            <div class="px-6 py-24 mx-auto max-w-7xl sm:px-10">
                <div class="w-full mx-auto text-left md:text-center">
                    <div x-data="{
                            text: '{{ __('lang_v1.reuniting') }}',
                            textArray: ['{{ __('lang_v1.reuniting') }}', '{{ __('lang_v1.helping') }}', '{{ __('lang_v1.connecting') }}'],
                            textIndex: 0,
                            charIndex: 0,
                            typeSpeed: 100,
                            deleteSpeed: 80,
                            cursorSpeed: 550,
                            pauseBetween: 1000,
                            pauseAfter: 1500,
                            direction: 'forward',
                            isTyping: true,
                            currentGradient: 0,
                            gradients: [
                                'bg-gradient-to-r from-purple-600 to-pink-500',
                                'bg-gradient-to-r from-teal-500 to-blue-600',
                                'bg-gradient-to-r from-orange-500 to-yellow-400'
                            ],
                            animateGradient() {
                                this.currentGradient = (this.currentGradient + 1) % this.gradients.length;
                                setTimeout(() => this.animateGradient(), 3000);
                            }
                        }" x-init="() => {
                            animateGradient();

                            let typingInterval;

                            function startTyping() {
                                let current = $data.textArray[$data.textIndex];

                                if ($data.direction === 'forward') {
                                    if ($data.charIndex <= current.length) {
                                        $data.text = current.substring(0, $data.charIndex);
                                        $data.charIndex += 1;
                                    } else {
                                        $data.direction = 'backward';
                                        clearInterval(typingInterval);
                                        setTimeout(() => {
                                            typingInterval = setInterval(startTyping, $data.deleteSpeed);
                                        }, $data.pauseAfter);
                                    }
                                } else {
                                    if ($data.charIndex > 0) {
                                        $data.text = current.substring(0, $data.charIndex);
                                        $data.charIndex -= 1;
                                    } else {
                                        $data.direction = 'forward';
                                        $data.textIndex = ($data.textIndex + 1) % $data.textArray.length;
                                        clearInterval(typingInterval);
                                        setTimeout(() => {
                                            typingInterval = setInterval(startTyping, $data.typeSpeed);
                                        }, $data.pauseBetween);
                                    }
                                }
                            }

                            typingInterval = setInterval(startTyping, $data.typeSpeed);
                        }" class="flex items-center justify-center mx-auto text-center max-w-7xl">
                        <div class="relative flex items-center justify-center h-24">
                            <h1 class="mb-6 text-4xl font-extrabold tracking-normal text-gray-900 sm:text-5xl md:text-6xl lg:text-6xl md:tracking-tight leading-tight gradient-text"
                                :class="gradients[currentGradient]" x-text="text" style="min-width: 1rem;">
                            </h1>
                        </div>
                    </div>
                    <p class="px-0 mb-8 text-lg text-gray-600 md:text-xl lg:px-24">
                        {{ __('lang_v1.our_community') }}
                    </p>
                    <div class="h-[10rem]"></div>
                    <div class="flex flex-col justify-center gap-4 mb-8 sm:flex-row sm:gap-6">
                        <a wire:navigate href="/post-item"
                            class="px-8 py-4 text-base font-medium text-white bg-black rounded-full hover:bg-gray-900 focus:outline-none focus:ring-2  focus:ring-offset-2 transition-all hover-scale">
                            {{ __('lang_v1.report_found_item') }}
                        </a>
                        <a wire:navigate href="{{ route('lost-items') }}"
                            class="px-8 py-4 text-base font-medium text-black bg-gray-200 rounded-full hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all hover-scale">
                            {{ __('lang_v1.report_lost_item') }}
                        </a>
                    </div>
                    <div class="flex items-center justify-center">
                        <div class="flex -space-x-2">
                            <img class="w-10 h-10 rounded-full border-2 border-white"
                                src="https://randomuser.me/api/portraits/women/79.jpg" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-white"
                                src="https://randomuser.me/api/portraits/men/64.jpg" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-white"
                                src="https://randomuser.me/api/portraits/women/94.jpg" alt="User">
                        </div>
                        <p class="ml-3 text-sm text-gray-600">
                            {!! __('lang_v1.trusted_by') !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 bg-gray-100">
        <div class="max-w-6xl px-6 mx-auto">
            <div class="grid grid-cols-2 gap-8 text-center md:grid-cols-4">
                <div class="flex space-x-2 items-center p-6 border-r border-gray-200">
                    <div class="border rounded-full p-3">
                        <flux:icon name="gift" class="w-10 h-10 mx-auto text-gray-400" />
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="text-4xl font-bold text-sky-900">1,200+</div>
                        <div class="mt-2 text-sm font-medium text-slate-500">Items Found</div>
                    </div>
                </div>
                <div class="flex space-x-2 items-center p-6 border-r border-gray-200">
                    <div class="border rounded-full p-3">
                        <flux:icon name="user-round-plus" class="w-10 h-10 mx-auto text-gray-400" />
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="text-4xl font-bold text-sky-900">500+</div>
                        <div class="mt-2 text-sm font-medium text-slate-500">Active Reports</div>
                    </div>
                </div>
                <div class="flex space-x-2 items-center p-6 border-r border-gray-200">
                    <div class="border rounded-full p-3">
                        <flux:icon name="binoculars" class="w-10 h-10 mx-auto text-gray-400" />
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="text-4xl font-bold text-sky-900">200+</div>
                        <div class="mt-2 text-sm font-medium text-slate-500">Active searches</div>
                    </div>
                </div>
                <div class="flex space-x-2 items-center p-6">
                    <div class="border rounded-full p-3">
                        <flux:icon name="badge-percent" class="w-10 h-10 mx-auto text-gray-400" />
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="text-4xl font-bold text-sky-900">98%</div>
                        <div class="mt-2 text-sm font-medium text-slate-500">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white" id="about">
        <div class="max-w-6xl px-6 mx-auto">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-3xl font-bold text-sky-900 sm:text-4xl">How It Works</h2>
                <p class="max-w-2xl mx-auto text-lg text-gray-500">With our simple four-step process, we makes it easy for you to find your lost items. Follow the guides below to know how.</p>
            </div>

            <div class="grid gap-10 md:grid-cols-4 lg:grid-cols-4">
                <div class="relative p-8 transition-all rounded-3xl shadow-lg">
                    <div class="absolute top-0 left-0 w-full h-full bg-white rounded-3xl opacity-10 z-10">
                        <img src="{{ asset('rounds5.svg') }}" alt="Rounded Shapes">
                    </div>
                    <div class="z-20 relative">
                        <div class="flex items-center justify-center w-16 h-16 mb-6 text-2xl font-bold text-white bg-sky-900 rounded-full">
                            1</div>
                        <h3 class="mb-3 text-xl font-bold text-gray-900">Search or found the items</h3>
                        <p class="text-gray-600">Search or browse our database for the item(s) you've lost.</p>
                    </div>
                </div>

                <div class="relative p-8 transition-all rounded-3xl shadow-lg">
                    <div class="absolute top-0 left-0 w-full h-full bg-white rounded-3xl opacity-10">
                        <img src="{{ asset('rounds3.svg') }}" alt="Rounded Shapes">
                    </div>
                    <div class="z-20 relative">
                        <div
                            class="flex items-center justify-center w-16 h-16 mb-6 text-2xl font-bold text-white bg-sky-900 rounded-full">
                            2</div>
                        <h3 class="mb-3 text-xl font-bold text-gray-900">Send a retrieval Request</h3>
                        <p class="text-gray-600">Login or sign up to send a request to the admin for item retrieval.
                        </p>
                    </div>
                </div>

                <div class="relative p-8 transition-all rounded-3xl shadow-lg">
                    <div class="absolute top-0 left-0 w-full h-full bg-white rounded-3xl opacity-10">
                        <img src="{{ asset('rounds2.svg') }}" alt="Rounded Shapes">
                    </div>
                    <div class="z-20 relative">
                        <div
                            class="flex items-center justify-center w-16 h-16 mb-6 text-2xl font-bold text-white bg-sky-900 rounded-full">
                            3</div>
                        <h3 class="mb-3 text-xl font-bold text-gray-900">Verification process</h3>
                        <p class="text-gray-600">Admin schedules a meet up for full verifications process.</p>
                    </div>
                </div>

                <div class="relative p-8 transition-all rounded-3xl shadow-lg">
                    <div class="absolute top-0 left-0 w-full h-full bg-white rounded-3xl opacity-10">
                        <img src="{{ asset('rounds1.svg') }}" alt="Rounded Shapes">
                    </div>
                    <div class="z-20 relative">
                        <div
                            class="flex items-center justify-center w-16 h-16 mb-6 text-2xl font-bold text-white bg-sky-900 rounded-full">
                            4</div>
                        <h3 class="mb-3 text-xl font-bold text-gray-900">Done! You got your item back</h3>
                        <p class="text-gray-600">Wow, you just received your treasure back at no cost at all.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-6xl px-6 mx-auto">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-3xl font-bold text-sky-900 sm:text-4xl">Recent success stories</h2>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">See how we're putting smiles on people's faces with their precious
                belongings. You can also message US about your lost items and we will find it for you. </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="overflow-hidden transition-all bg-white rounded-3xl shadow-sm hover:shadow-xl">
                    <img class="object-cover w-full h-48"
                        src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Reunited wallet">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-10 h-10 rounded-full" src="https://randomuser.me/api/portraits/men/96.jpg"
                                alt="User">
                            <div class="ml-3">
                                <h4 class="text-sm font-semibold text-slate-600">Michael Johnson</h4>
                                <p class="text-sm text-gray-400">2 days ago</p>
                            </div>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-gray-900">Phone Found Within Hours</h3>
                        <p class="text-gray-600">"I lost my phone at the park and thought it was gone forever. Thanks
                            to
                            this platform, a kind stranger found it and contacted me the same day!"</p>
                    </div>
                </div>

                <div class="overflow-hidden transition-all bg-white rounded-3xl shadow-sm hover:shadow-xl">
                    <img class="object-cover w-full h-48"
                        src="https://media.licdn.com/dms/image/v2/D4D12AQGQFtwWs14jpA/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1665140762359?e=2147483647&v=beta&t=y1Ef5X3orvHvZ1FSDWNRZHDdJbDx4OJ4Uf9YqHMob7Y"
                        alt="Reunited laptop">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-10 h-10 rounded-full" src="https://randomuser.me/api/portraits/women/94.jpg"
                                alt="Ghana card review">
                            <div class="ml-3">
                                <h4 class="text-sm font-semibold text-slate-600">Adizah Jones</h4>
                                <p class="text-sm text-gray-400">1 week ago</p>
                            </div>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-gray-900">Ghana Card Retreived</h3>
                        <p class="text-gray-600">"I lost my Ghana Card a week ago and when prompted to visit this site website I did and to my surprise, they got it for me. I think they deserve a 7 Star credit."</p>
                    </div>
                </div>

                <div class="overflow-hidden transition-all bg-white rounded-3xl shadow-sm hover:shadow-xl">
                    <img class="object-cover w-full h-48"
                        src="https://photos5.appleinsider.com/gallery/45240-88149-The-new-MacBook-Pro-16-inch-xl.jpg"
                        alt="Reunited laptop review">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-10 h-10 rounded-full" src="https://randomuser.me/api/portraits/men/64.jpg"
                                alt="User">
                            <div class="ml-3">
                                <h4 class="text-sm font-semibold text-slate-600">Adeliyine Courage</h4>
                                <p class="text-sm text-gray-400">2 months ago</p>
                            </div>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-gray-900">Reunited with my laptop</h3>
                        <p class="text-gray-600">"I lost my back pack with my laptop in it which i couldnt find later. Thanks to Lost and Found systems who gave it back to me fully intact."</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a wire:navigate href="#" class="px-6 py-3 font-medium text-blue-600 hover:text-blue-800">View More Stories →</a>
            </div>
        </div>
    </section>

    <section class="relative py-20 bg-[url('https://github.blog/wp-content/uploads/2024/02/Enterprise-LightMode-2.png')] bg-cover bg-center-center bg-no-repeat">
        <div class="absolute inset-0 backdrop-blur-md bg-white/10 z-10"></div>
        <div class="max-w-4xl px-6 mx-auto text-center relative z-20">
            <h2 class="mb-6 text-3xl font-bold text-blue-900 sm:text-4xl">Ready to Find Your Lost Item?</h2>
            <p class="mb-8 text-xl text-gray-600">Join thousands of others who have successfully reunited with their
                lost
                belongings.</p>
            <div class="flex flex-col justify-center gap-4 sm:flex-row sm:gap-6">
                <a wire:navigate href="{{ route('claimer-register') }}"
                    class="px-8 py-4 text-base font-medium text-black bg-white/60 backdrop-blur-sm rounded-full focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition-all hover-scale">
                    Get Started Now
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-4xl px-6 mx-auto">
            <div class="mb-16 text-center">
                <h2 class="mb-4 text-3xl font-bold text-gray-900 sm:text-4xl">Frequently Asked Questions</h2>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">Have questions? We've got answers.</p>
            </div>

            <div class="space-y-6">
                <div x-data="{ open: false }" class="overflow-hidden hover:shadow-lg rounded-3xl shadow-sm transition-all duration-300">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">Is this service free to use?</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-200 transform"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="p-6 pt-0 text-gray-600">
                        <p>Yes, our basic service is completely free to use. We may offer premium features in the
                            future,
                            but the core functionality of reporting and searching for lost items will always remain
                            free.
                        </p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="overflow-hidden hover:shadow-lg rounded-3xl shadow-sm transition-all duration-300">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">How do I know if an item is mine?</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-200 transform"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="p-6 pt-0 text-gray-600">
                        <p>We recommend asking specific questions about the item that only the owner would know. For
                            valuable items, we suggest meeting in a public place and verifying identification before
                            handing
                            over the item.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="overflow-hidden hover:shadow-lg rounded-3xl shadow-sm transition-all duration-300">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">What should I do if I find something valuable?
                        </h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-200 transform"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="p-6 pt-0 text-gray-600">
                        <p>First, post it on our platform with as much detail as possible (without compromising
                            security).
                            For items like wallets or phones, you may also consider turning them into local authorities
                            if
                            they contain identification.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="overflow-hidden hover:shadow-lg rounded-3xl shadow-sm transition-all duration-300">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">How long do you keep listings active?</h3>
                        <svg class="w-5 h-5 text-gray-500 transition-transform duration-200 transform"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="p-6 pt-0 text-gray-600">
                        <p>Listings remain active for 90 days by default, but you can extend them if needed. We'll send
                            you
                            reminders to check if you still need the listing to be active.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-20 bg-gray-50">
        <img src="{{ asset('data-globe-hero@3x.png') }}" alt="Overlay Image"
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
    <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
                particles: {
                    number: {
                        value: 50,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: "#135E9B"
                    },
                    shape: {
                        type: "circle"
                    },
                    opacity: {
                        value: 0.8,
                        random: true
                    },
                    size: {
                        value: 3,
                        random: true
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#74CEFB",
                        opacity: 0.5,
                        width: 0.5
                    },
                    move: {
                        enable: true,
                        speed: 2,
                        direction: "none",
                        out_mode: "out"
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: true,
                            mode: "grab"
                        }
                    },
                    modes: {
                        grab: {
                            distance: 200,
                            line_linked: {
                                opacity: 0.5
                            }
                        }
                    }
                },
                retina_detect: false
            });
    </script>

</body>

</html>
