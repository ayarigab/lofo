@include('partials.frontend.header', ['title' => __('Sign Up')])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    <section class="w-full px-6 pb-0 antialiased bg-white particles-js">
        <div class="mx-auto max-w-7xl">
            @include('partials.frontend.navbar')

            <div class="px-6 py-24 mx-auto max-w-7xl sm:px-10">
                <div class="w-full mx-auto text-left md:text-center">
                    <div class="flex inset-0 z-[99] bg-white">
                        <div class="relative flex flex-wrap items-center w-full h-full px-8">

                            <div class="relative w-full max-w-sm mx-auto lg:mb-0">
                                @livewire('claimer-register')
                                <p class="mt-6 text-sm text-center text-neutral-500">Already have an account? <a href="#_"
                                        class="relative font-medium text-blue-600 group"><span>Login here</span><span
                                            class="absolute bottom-0 left-0 w-0 group-hover:w-full ease-out duration-300 h-0.5 bg-blue-600"></span></a>
                                </p>
                                <p class="px-8 mt-1 text-sm text-center text-neutral-500">By continuing, you agree to our <a
                                        class="underline underline-offset-4 hover:text-primary" href="/terms">Terms</a> and
                                    <a class="underline underline-offset-4 hover:text-primary" href="/privacy">Policy</a>.
                                </p>
                            </div>
                        </div>
                        <div class="relative top-0 bottom-0 right-0 flex-shrink-0 hidden w-1/3 overflow-hidden bg-cover lg:block">
                            <a href="#_"
                                class="absolute bottom-0 right-0 z-30 inline-flex items-end mb-4 mr-3 font-sans text-2xl font-extrabold text-left text-white no-underline bg-transparent cursor-pointer group focus:no-underline">
                                <svg class="w-auto h-4 text-white fill-current lg:h-5" viewBox="0 0 355 99" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs>
                                        <path
                                            d="M119.1 87V66.4h19.8c34.3 0 34.2-49.5 0-49.5-11 0-22 .1-33 .1v70h13.2zm19.8-32.7h-19.8V29.5h19.8c16.8 0 16.9 24.8 0 24.8zm32.6-30.5c0 9.5 14.4 9.5 14.4 0s-14.4-9.5-14.4 0zM184.8 87V37.5h-12.2V87h12.2zm22.8 0V61.8c0-7.5 5.1-13.8 12.6-13.8 7.8 0 11.9 5.7 11.9 13.2V87h12.2V61.1c0-15.5-9.3-24.2-20.9-24.2-6.2 0-11.2 2.5-16.2 7.4l-.8-6.7h-10.9V87h12.1zm72.1 1.3c7.5 0 16-2.6 21.2-8l-7.8-7.7c-2.8 2.9-8.7 4.6-13.2 4.6-8.6 0-13.9-4.4-14.7-10.5h38.5c1.9-20.3-8.4-30.5-24.9-30.5-16 0-26.2 10.8-26.2 25.8 0 15.8 10.1 26.3 27.1 26.3zM292 56.6h-26.6c1.8-6.4 7.2-9.6 13.8-9.6 7 0 12 3.2 12.8 9.6zm41.2 32.1c14.1 0 21.2-7.5 21.2-16.2 0-13.1-11.8-15.2-21.1-15.8-6.3-.4-9.2-2.2-9.2-5.4 0-3.1 3.2-4.9 9-4.9 4.7 0 8.7 1.1 12.2 4.4l6.8-8c-5.7-5-11.5-6.5-19.2-6.5-9 0-20.8 4-20.8 15.4 0 11.2 11.1 14.6 20.4 15.3 7 .4 9.8 1.8 9.8 5.2 0 3.6-4.3 6-8.9 5.9-5.5-.1-13.5-3-17-6.9l-6 8.7c7.2 7.5 15 8.8 22.8 8.8z"
                                            id="a"></path>
                                    </defs>
                                    <g fill="none" fill-rule="evenodd">
                                        <g fill="currentColor">
                                            <path d="M19.742 49h28.516L68 83H0l19.742-34z"></path>
                                            <path d="M26 69h14v30H26V69zM4 50L33.127 0 63 50H4z"></path>
                                        </g>
                                        <g fill-rule="nonzero">
                                            <use fill="currentColor" xlink:href="#a"></use>
                                            <use fill="currentColor" xlink:href="#a"></use>
                                        </g>
                                    </g>
                                </svg>
                                <span
                                    class="flex opacity-90 group-hover:scale-150 group-hover:opacity-100 items-center h-full group-hover:-rotate-6 ease-out duration-500 px-0.5 py-px ml-2 -translate-x-px text-[0.6rem] font-bold leading-none border-[2px] rounded border-white -translate-y-px">UI</span>
                            </a>
                            <div class="absolute inset-0 z-20 w-full h-full opacity-70 bg-gradient-to-t from-black"></div>
                            <img src="https://cdn.devdojo.com/images/may2023/pines-bg-2.png" class="z-10 object-cover w-full h-full" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.frontend.footer')
</body>

</html>
