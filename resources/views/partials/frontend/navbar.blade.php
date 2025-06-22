<nav class="relative z-50 h-24 select-none w-auto bg-white" x-data="{
                showMenu: false,
                navigationMenuOpen: false,
                navigationMenu: '',
                navigationMenuCloseDelay: 200,
                navigationMenuCloseTimeout: null,
                modalOpen: false,
                messageModalOpen: false,
                navigationMenuLeave() {
                    this.navigationMenuCloseTimeout = setTimeout(() => {
                        this.navigationMenuOpen = false;
                    }, this.navigationMenuCloseDelay);
                },
                navigationMenuReposition(navElement) {
                    clearTimeout(this.navigationMenuCloseTimeout);
                    this.navigationMenuOpen = true;
                    if (this.$refs.navigationDropdown) {
                        this.$refs.navigationDropdown.style.left = (navElement.offsetLeft+20) + 'px';
                        this.$refs.navigationDropdown.style.marginLeft = ((navElement.offsetWidth/2)+20) + 'px';
                    }
                },
                navigationMenuClearCloseTimeout(){
                    clearTimeout(this.navigationMenuCloseTimeout);
                },
                navigationMenuClose(){
                    this.navigationMenuOpen = false;
                    this.navigationMenu = '';
                }          }"
                x-on:keydown.window="
                if ((event.metaKey || event.ctrlKey) && event.key === 'k') {
                event.preventDefault();
                modalOpen = !modalOpen;
                }

                if (event.key === 'Escape') {
                modalOpen = false;
                }
                "
                >
    <div
        class="container relative flex flex-wrap items-center justify-between h-24 mx-auto overflow-hidden font-medium border-b border-gray-200 md:overflow-visible lg:justify-center sm:px-4 md:px-2 lg:px-0">
        <div class="flex items-center justify-start w-1/4 h-full pr-4">
            <a wire:navigate href="/" class="flex items-center py-4 space-x-2 font-extrabold text-gray-900 md:py-0 group">
                <span
                    class="flex items-center justify-center w-16 h-16 p-2 rounded-full transition-all duration-300 group-hover:rotate-12 border border-[#3B82F6] text-white">
                    <x-app-logo-icon />
                </span>
                <span
                    class="uppercase text-xl transition-all duration-300 group-hover:text-b[#3B82F6]">Lost&Found</span>
            </a>
        </div>

        <div class="top-0 left-0 items-start hidden w-full h-full p-4 text-sm bg-gray-900 bg-opacity-50 md:items-center md:w-3/4 md:absolute lg:text-base md:bg-transparent md:p-0 md:relative md:flex"
            :class="{'flex fixed': showMenu, 'hidden': !showMenu }">
            <div
                class="flex flex-col w-full h-auto overflow-hidden bg-white rounded-lg md:bg-transparent md:overflow-visible md:rounded-none md:relative md:flex md:flex-row">
                <a wire:navigate href="/"
                    class="relative inline-block w-full py-2 mx-0 ml-6 text-left text-black md:ml-0 md:w-auto md:px-0 md:mx-2 lg:mx-3 md:text-center group">
                    <span class="transition-all duration-300 group-hover:text-[#3B82F6]">Home</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#3B82F6] transition-all duration-300 group-hover:w-full"></span>
                </a>

                <div class="relative"
                    @mouseover="navigationMenuOpen=true; navigationMenuReposition($el); navigationMenu='lost-found'"
                    @mouseleave="navigationMenuLeave()">
                    <button
                        class="inline-flex items-center justify-center w-full py-2 mx-0 text-left text-gray-700 md:w-auto md:px-0 md:mx-2 hover:text-black lg:mx-3 md:text-center group">
                        <span class="transition-all duration-300 group-hover:text-[#3B82F6]">Lost &
                            Found</span>
                        <svg :class="{ '-rotate-180' : navigationMenuOpen==true && navigationMenu == 'lost-found' }"
                            class="relative top-[1px] ml-1 h-3 w-3 ease-out duration-300"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                </div>

                <a wire:navigate href="/about"
                    class="relative inline-block w-full py-2 mx-0 text-left text-gray-700 md:w-auto md:px-0 md:mx-2 hover:text-black lg:mx-3 md:text-center group">
                    <span class="transition-all duration-300 group-hover:text-[#3B82F6]">About US</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#3B82F6] transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a wire:navigate href="/contact"
                    class="relative inline-block w-full py-2 mx-0 text-left text-gray-700 md:w-auto md:px-0 md:mx-2 hover:text-black lg:mx-3 md:text-center group">
                    <span class="transition-all duration-300 group-hover:text-[#3B82F6]">Contact US</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#3B82F6] transition-all duration-300 group-hover:w-full"></span>
                </a>

                <button @click="modalOpen=true"
                    class="absolute top-0 left-0 hidden items-center py-2 border rounded-full mt-6 ml-10 mr-2 text-gray-600 lg:inline-flex md:mt-0 md:ml-2 lg:mx-3 md:relative group transition-all duration-300 hover:border-[#3B82F6] hover:text-[#3B82F6] hover-scale">
                    <div class="relative flex items-center justify-between w-full px-8 pl-4">
                        <svg class="w-5 h-5 transition-all duration-300 group-hover:scale-110" fill="none"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="hidden ml-2 mr-4 md:inline">Search...</span>
                        <div
                            class="absolute top-0 bottom-0 flex items-center gap-x-1.5 pe-3 end-0 text-xs text-zinc-400">
                            <span class="pointer-events-none">⌘K</span>
                        </div>
                    </div>
                </button>
            </div>

            <div class="flex flex-col items-start justify-end w-full pt-4 md:items-center md:w-1/3 md:flex-row md:py-0">
                <a wire:navigate href="/signin"
                    class="w-full px-6 py-2 mr-0 text-gray-700 md:px-6 md:mr-2 lg:mr-3 md:w-auto rounded-full border transition-all duration-300 hover:text-[#3B82F6] hover-scale">Sign
                    In</a>
                <a wire:navigate href="{{ route('claimer-register') }}"
                    class="relative inline-flex items-center overflow-hidden w-full px-6 py-3 text-sm font-medium leading-4 text-white bg-gradient-to-br from-teal-300 to-[#3B82F6] md:w-auto md:rounded-full hover:bg-[#3B82F6] focus:outline-none md:focus:ring-2 focus:ring-0 focus:ring-offset-2 focus:ring-blue-800 transition-all duration-300 hover-scale">
                    Sign Up
                </a>
            </div>
        </div>

        <div x-ref="navigationDropdown" x-show="navigationMenuOpen"
            x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            @mouseover="navigationMenuClearCloseTimeout()" @mouseleave="navigationMenuLeave()"
            class="absolute top-full duration-200 ease-out" x-cloak style="min-width: max-content;">

            <div
                class="flex justify-center w-auto h-auto overflow-hidden bg-white border rounded-3xl shadow-lg border-neutral-200/70">
                <div x-show="navigationMenu == 'lost-found'"
                    class="flex flex-col items-stretch justify-center w-full p-6 gap-x-3 sm:flex-row">
                    <div class="w-full sm:w-72">
                        <a wire:navigate href="{{ route('lost-items') }}" @click="navigationMenuClose()"
                            class="block px-3.5 py-3 text-sm rounded-xl hover:bg-slate-100 transition-all duration-300 border border-transparent">
                            <span class="block mb-1 font-medium text-black">Lost Items</span>
                            <span class="block font-light leading-5 text-gray-600">Browse items that have
                                been
                                reported as lost in our community.</span>
                        </a>
                        <a wire:navigate href="/post-item" @click="navigationMenuClose()"
                            class="block px-3.5 py-3 text-sm rounded-xl hover:bg-slate-100 transition-all duration-300 border border-transparent mt-2">
                            <span class="block mb-1 font-medium text-black">Post an Item</span>
                            <span class="block font-light leading-5 text-gray-600">Report a lost item you've
                                found to help reunite it with its owner.</span>
                        </a>
                    </div>
                    <div class="w-full mt-4 sm:mt-0 sm:w-72">
                        <a href="#" @click.prevent="$dispatch('open-contact-form')" @click="navigationMenuClose()"
                            class="block px-3.5 py-3 text-sm rounded-xl hover:bg-slate-100 transition-all duration-300 border border-transparent">
                            <span class="block mb-1 font-medium text-black">Send Us a Message <span class="ml-2  text-xs pointer-events-none text-gray-400">⌘M</span></span>
                            <span class="block font-light leading-5 text-gray-600">Send a message, lodge a complain or make a suggestion about
                                the website.</span>
                        </a>
                        <a wire:navigate href="/claimed-items" @click="navigationMenuClose()"
                            class="block px-3.5 py-3 text-sm rounded-xl hover:bg-slate-100 transition-all duration-300 border border-transparent mt-2">
                            <span class="block mb-1 font-medium text-black">Claimed Items</span>
                            <span class="block font-light leading-5 text-gray-600">View successfully
                                reunited
                                items and happy stories.</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div @click="showMenu = !showMenu"
            class="absolute right-0 flex flex-col items-center items-end justify-center w-10 h-10 bg-white rounded-full cursor-pointer md:hidden hover:bg-gray-100 transition-all duration-300 z-50">
            <svg class="w-6 h-6 text-gray-700" x-show="!showMenu" fill="none" stroke-linecap="round"
                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg class="w-6 h-6 text-gray-700" x-show="showMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="modalOpen"
            x-data="{
                resetSearch() {
                    Livewire.dispatch('reset-search');
                    this.modalOpen = false;
                }
            }"
            class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>

            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="resetSearch()"
                class="absolute inset-0 w-full h-full bg-white/10 backdrop-blur-sm bg-opacity-70">
            </div>

            <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                class="relative w-full py-6 bg-white border shadow-lg px-7 border-neutral-200 sm:max-w-lg sm:rounded-3xl">

                <div class="flex items-center justify-between pb-3">
                    <h3 class="text-lg font-semibold">Search Lost & Found Items</h3>
                    <button @click="resetSearch()"
                        class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50 transition-all duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @livewire('lost-item-search', key('search-'.now()->timestamp))

                <div class="flex justify-end mt-4">
                    <button @click="resetSearch()" type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors border border-gray-300 rounded-full hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-neutral-100 focus:ring-offset-2">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </template>

    <div
        x-data="{ showContactForm: false }"
        x-on:open-contact-form.window="showContactForm = true"
        x-on:keydown.window="
            if ((event.metaKey || event.ctrlKey) && event.key === 'm') {
                event.preventDefault();
                showContactForm = !showContactForm;
            }

            if (event.key === 'Escape') {
                showContactForm = false;
            }
        "
        class="fixed inset-0 z-[100] overflow-hidden" x-cloak x-show="showContactForm"
        x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="absolute inset-0 bg-white/10 backdrop-blur-sm bg-opacity-70 transition-opacity" @click="showContactForm = false"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex">
            <div class="relative w-screen max-w-md" x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full">

                <div class="h-full flex flex-col bg-white shadow-xl">
                    <div class="flex items-center justify-between px-4 py-6 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Send Us a Message</h2>
                        <button @click="showContactForm = false" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6">
                        @livewire('send-message-modal')
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('contactForm', {
            open() {
                window.dispatchEvent(new CustomEvent('open-contact-form'));
            },
            close() {
                window.dispatchEvent(new CustomEvent('close-contact-form'));
            }
        });

        // Handle the close event
        window.addEventListener('close-contact-form', () => {
            const panel = document.querySelector('[x-data*="showContactForm"]');
            if (panel) {
                panel.__x.$data.showContactForm = false;
            }
        });
    });
    </script>
