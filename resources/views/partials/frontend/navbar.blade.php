<div class="relative w-auto h-auto" x-data>
    <div x-data="{
            title: 'Success Notification',
            description: '',
            type: 'success',
            popToast(){
                toast(this.title, { description: this.description, type: this.type })
            }
        }" x-init="
            window.toast = function(message, options = {}){
                let description = '';
                let type = 'success';
                if(typeof options.description != 'undefined') description = options.description;
                if(typeof options.type != 'undefined') type = options.type;

                window.dispatchEvent(new CustomEvent('toast-show', { detail : { type: type, message: message, description: description }}));
            }
        " class="relative space-y-5">
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('toast-show', (event) => {
                const detail = Array.isArray(event) ? event[0] : event;
                window.dispatchEvent(new CustomEvent('toast-show', { detail }));
            });
            @php
                $toast = session('toast');
            @endphp
            @if($toast)
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: {
                    type: '{{ $toast['type'] }}',
                    message: '{{ $toast['message'] }}',
                    description: '{{ $toast['description'] }}'
                }
            }));
            @endif
            @if(session('error'))
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: {
                    type: 'danger',
                    message: 'Error!',
                    description: '{{ session('error') }}'
                }
            }));
            @endif
            @if(session('success'))
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: {
                    type: 'success',
                    message: 'Success!',
                    description: '{{ session('success') }}'
                }
            }));
            @endif
            @if(session('warning'))
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: {
                    type: 'warning',
                    message: 'Warning!',
                    description: '{{ session('warning') }}'
                }
            }));
            @endif
            @if(session('info'))
            window.dispatchEvent(new CustomEvent('toast-show', {
                detail: {
                    type: 'info',
                    message: 'Info!',
                    description: '{{ session('info') }}'
                }
            }));
            @endif
        });
    </script>

    <template x-teleport="body">
        <ul x-data="{
                    toasts: [],
                    toastsHovered: false,
                    paddingBetweenToasts: 15,
                    deleteToastWithId (id){
                        for(let i = 0; i < this.toasts.length; i++){
                            if(this.toasts[i].id === id){
                                this.toasts.splice(i, 1);
                                break;
                            }
                        }
                    },
                    burnToast(id){
                        burnToast = this.getToastWithId(id);
                        burnToastElement = document.getElementById(burnToast.id);
                        if(burnToastElement){
                            burnToastElement.classList.add('opacity-0');
                            burnToastElement.classList.add('-translate-y-full');
                            let that = this;
                            setTimeout(function(){
                                that.deleteToastWithId(id);
                                setTimeout(function(){
                                    that.stackToasts();
                                }, 1)
                            }, 300);
                        }
                    },
                    getToastWithId(id){
                        for(let i = 0; i < this.toasts.length; i++){
                            if(this.toasts[i].id === id){
                                return this.toasts[i];
                            }
                        }
                    },
                    stackToasts(){
                        this.positionToasts();
                        this.calculateHeightOfToastsContainer();
                        let that = this;
                        setTimeout(function(){
                            that.calculateHeightOfToastsContainer();
                        }, 300);
                    },
                    positionToasts() {
                        if (this.toasts.length == 0) return;

                        for (let i = 0; i < this.toasts.length; i++) {
                            let toastElement = document.getElementById(this.toasts[i].id);
                            if (!toastElement) continue;

                            toastElement.style.zIndex = 100 - (i * 10);

                            if (this.toastsHovered) {
                                toastElement.style.top = (i * (toastElement.getBoundingClientRect().height + this.paddingBetweenToasts)) + 'px';
                                toastElement.style.scale = '100%';
                                toastElement.style.transform = 'translateY(0px)';
                                toastElement.firstElementChild.classList.remove('opacity-0');
                                toastElement.firstElementChild.classList.add('opacity-100');
                            } else {
                                toastElement.style.top = '0px';

                                if (i >= 3) {
                                    toastElement.style.opacity = '0';
                                    toastElement.style.pointerEvents = 'none';
                                } else {
                                    const scale = 100 - (i * 6);
                                    const translateY = i * 16;
                                    toastElement.style.scale = `${scale}%`;
                                    toastElement.style.transform = `translateY(${translateY}px)`;
                                    toastElement.style.opacity = '1';
                                    toastElement.style.pointerEvents = 'auto';
                                }
                            }
                        }

                        if (!this.toastsHovered && this.toasts.length > 3) {
                            setTimeout(() => {
                                this.toasts.pop();
                                this.stackToasts();
                            }, 300);
                        }
                    },
                    calculateHeightOfToastsContainer(){
                        if(this.toasts.length == 0){
                            $el.style.height = '0px';
                            return;
                        }

                        let firstToast = this.toasts[0];
                        let firstToastElement = document.getElementById(firstToast.id);
                        if(firstToastElement){
                            let firstToastRectangle = firstToastElement.getBoundingClientRect();

                            if(this.toastsHovered && this.toasts.length > 1){
                                let totalHeight = 0;
                                for(let i = 0; i < this.toasts.length; i++){
                                    let toastElement = document.getElementById(this.toasts[i].id);
                                    if(toastElement){
                                        totalHeight += toastElement.getBoundingClientRect().height;
                                        if(i < this.toasts.length - 1){
                                            totalHeight += this.paddingBetweenToasts;
                                        }
                                    }
                                }
                                $el.style.height = totalHeight + 'px';
                            } else {
                                $el.style.height = firstToastRectangle.height + 'px';
                            }
                        }
                    }
                }" @toast-show.window="
                event.stopPropagation();
                let detail = event.detail;
                if (Array.isArray(event.detail) && event.detail[0]?.data) {
                    detail = event.detail[0].data;
                } else if (event.detail?.data) {
                    detail = event.detail.data;
                }
                toasts.unshift({
                    id: 'toast-' + Math.random().toString(16).slice(2),
                    show: false,
                    message: detail.message || 'Notification',
                    description: detail.description || '',
                    type: detail.type || 'info'
                });
                stackToasts();
                " @mouseenter="toastsHovered=true;" @mouseleave="toastsHovered=false" x-init="
                    stackToasts();
                    $watch('toastsHovered', function(value){
                        if(value){
                            stackToasts();
                        } else {
                            setTimeout(function(){
                                stackToasts();
                            }, 10);
                            setTimeout(function(){
                                stackToasts();
                            }, 20)
                        }
                    });
                " class="fixed top-0 left-1/2 transform -translate-x-1/2 z-[99] sm:mt-6 w-full sm:max-w-xs group"
            x-cloak>

            <template x-for="(toast, index) in toasts" :key="toast.id">
                <li :id="toast.id" x-data="{
                                    toastHovered: false,
                                    timeoutId: null,
                                    initToast() {
                                        $el.firstElementChild.classList.add('opacity-0', '-translate-y-full');
                                        setTimeout(() => {
                                            $el.firstElementChild.classList.remove('opacity-0', '-translate-y-full');
                                            $el.firstElementChild.classList.add('opacity-100', 'translate-y-0');
                                            this.stackToasts();

                                            if (!this.toastHovered) {
                                                this.startDismissTimer();
                                            }
                                        }, 50);
                                    },
                                    startDismissTimer() {
                                        if (this.timeoutId) clearTimeout(this.timeoutId);

                                        this.timeoutId = setTimeout(() => {
                                            if (!this.toastHovered) {
                                                this.dismissToast();
                                            }
                                        }, 4000);
                                    },
                                    dismissToast() {
                                        $el.firstElementChild.classList.remove('opacity-100');
                                        $el.firstElementChild.classList.add('opacity-0');

                                        setTimeout(() => {
                                            this.deleteToastWithId(toast.id);
                                            this.stackToasts();
                                        }, 300);
                                    }
                                }" x-init="initToast()" @mouseover="toastHovered = true; if (timeoutId) clearTimeout(timeoutId);"
                    @mouseleave="toastHovered = false; startDismissTimer();" class="absolute w-full duration-300 ease-out select-none sm:max-w-xs">
                    <span
                        class="relative flex flex-col items-start shadow-[0_5px_15px_-3px_rgb(0_0_0_/_0.08)] w-full transition-all duration-300 ease-out bg-white border border-gray-100 sm:rounded-2xl sm:max-w-xs group p-4">
                        <div class="relative">
                            <div class="flex items-center"
                                :class="{ 'text-green-500' : toast.type=='success', 'text-blue-500' : toast.type=='info', 'text-orange-400' : toast.type=='warning', 'text-red-500' : toast.type=='danger' }">

                                <flux:icon.check-circle variant="solid" x-show="toast.type=='success'" class="w-[22px] h-[22px] mr-1.5 -ml-1" />
                                <flux:icon.information-circle variant="solid" x-show="toast.type=='info'" class="w-[22px] h-[22px] mr-1.5 -ml-1" />
                                <flux:icon.exclamation-triangle variant="solid" x-show="toast.type=='warning'" class="w-[22px] h-[22px] mr-1.5 -ml-1" />
                                <flux:icon.exclamation-triangle variant="solid" x-show="toast.type=='danger'" class="w-[22px] h-[22px] mr-1.5 -ml-1" />
                                <p class="text-[13px] font-medium leading-none text-gray-800" x-text="toast.message">
                                </p>
                            </div>
                            <p x-show="toast.description" class="mt-1.5 text-xs leading-none opacity-70 pl-5"
                                x-text="toast.description"></p>
                        </div>
                        <span @click="burnToast(toast.id)"
                            class="absolute right-0 p-1.5 mr-2.5 text-gray-400 duration-100 ease-in-out rounded-full opacity-0 cursor-pointer hover:bg-red-50 hover:text-red-500 top-0 mt-2.5"
                            :class="{ 'opacity-100' : toastHovered, 'opacity-0' : !toastHovered }">
                            <flux:icon.x class="w-3 h-3" />
                        </span>
                    </span>
                </li>
            </template>
        </ul>
    </template>
</div>

<nav class="relative z-50 h-24 select-none w-auto border-b border-gray-200 bg-white px-4" x-data="{
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
        class="container relative flex flex-wrap items-center justify-between h-24 mx-auto overflow-hidden font-medium md:overflow-visible lg:justify-center sm:px-4 md:px-2 lg:px-0">
        <div class="flex items-center justify-start w-1/4 h-full pr-4">
            <a wire:navigate href="{{ route('home') }}" class="flex items-center py-4 space-x-2 font-extrabold text-gray-900 md:py-0 group">
                <span
                    class="flex items-center justify-center w-16 h-12 p-2 rounded-full transition-all duration-300 group-hover:rotate-12 border border-gray-300 text-white">
                    <x-app-logo-icon />
                </span>
                <span
                    class="uppercase text-xl transition-all duration-300 group-hover:text-[#3B82F6]">{{ __('lang_v1.lostfound') }}</span>
            </a>
        </div>

        <div class="top-0 left-0 items-start hidden w-full h-full p-4 text-sm md:items-center md:w-3/4 lg:text-base md:bg-transparent md:p-0 md:relative md:flex"
            :class="{'flex fixed': showMenu, 'hidden': !showMenu }">
            <div
                class="flex flex-col w-full h-auto overflow-hidden bg-white rounded-lg md:bg-transparent md:overflow-visible md:rounded-none md:relative md:flex md:flex-row">
                <a wire:navigate href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'bg-black text-slate-100 hover:bg-gray-900 mx-1' : 'bg-transparent text-black hover:bg-slate-100' }} relative px-4 inline-block w-full py-2 ml-6 rounded-3xl transition-all md:ml-0 md:w-auto md:text-center">
                    {{ __('lang_v1.home') }}
                </a>

                <div class="relative"
                    @mouseover="navigationMenuOpen=true; navigationMenuReposition($el); navigationMenu='lost-found'"
                    @mouseleave="navigationMenuLeave()">
                    <button
                        class="inline-flex items-center justify-center rounded-3xl w-full px-4 py-2 md:w-auto bg-transparent text-black md:text-center hover:bg-slate-100">
                        {{ __('lang_v1.lost_and_found') }}
                        <svg :class="{ '-rotate-180' : navigationMenuOpen==true && navigationMenu == 'lost-found' }"
                            class="relative ml-1 h-4 w-4 ease-out duration-300"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                </div>

                <a wire:navigate href="{{ route('about-us') }}"
                    class="{{ request()->routeIs('about-us') ? 'bg-black text-slate-100 hover:bg-gray-900 mx-1' : 'bg-transparent text-black hover:bg-slate-100' }} relative px-4 inline-block w-full py-2 ml-6 rounded-3xl transition-all md:ml-0 md:w-auto md:text-center">
                    {{ __('lang_v1.about_us') }}
                </a>
                <a wire:navigate href="{{ route('contact-us') }}"
                    class="{{ request()->routeIs('contact-us') ? 'bg-black text-slate-100 hover:bg-gray-900 mx-1' : 'bg-transparent text-black hover:bg-slate-100' }} relative px-4 inline-block w-full py-2 ml-6 rounded-3xl transition-all md:ml-0 md:w-auto md:text-center">
                    {{ __('lang_v1.contact_us') }}
                </a>

                <button @click="modalOpen=true"
                    class="absolute top-0 left-0 hidden items-center py-2 border rounded-full mt-6 ml-10 mr-2 text-gray-600 lg:inline-flex md:mt-0 md:ml-2 lg:mx-3 md:relative group transition-all duration-300 hover:border-black hover:text-black hover-scale"
                    x-data="{
                        sparkle: false,
                        spin: false
                    }" x-init="
                        $watch('sparkle', val => {
                            if (val) setTimeout(() => sparkle = false, 1000);
                        });
                    " @mouseenter="
                        sparkle = true;
                        setTimeout(() => spin = true, 150);
                    " @mouseleave="spin = false">
                    <div class="relative flex items-center justify-between w-full px-8 pl-4">
                        <flux:icon.search-smart />
                        <span class="hidden ml-2 mr-4 md:inline">{{ __('lang_v1.search...') }}</span>
                        <div
                            class="absolute top-0 bottom-0 flex items-center gap-x-1.5 pe-3 end-0 text-xs text-zinc-400 pointer-events-none">
                            ⌘K
                        </div>
                    </div>
                </button>
            </div>

            <div class="flex flex-col items-start justify-end w-full pt-4 md:items-center md:w-1/3 md:flex-row md:py-0">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @mouseenter="open = true"
                        class="flex items-center rounded-3xl overflow-hidden w-full px-6 py-3 bg-transparent text-black hover:bg-slate-100 hover-scale">
                        <flux:icon name="globe-alt" class="w-4 h-4" />
                        <span class="text-sm">
                            @switch(app()->getLocale())
                            @case('ar') {{ __('lang_v1.language') }} @break
                            @case('de') {{ __('lang_v1.language') }} @break
                            @case('en') {{ __('lang_v1.language') }} @break
                            @case('es') {{ __('lang_v1.language') }} @break
                            @case('fa') {{ __('lang_v1.language') }} @break
                            @case('fr') {{ __('lang_v1.language') }} @break
                            @case('ha') {{ __('lang_v1.language') }} @break
                            @case('hi') {{ __('lang_v1.language') }} @break
                            @case('it') {{ __('lang_v1.language') }} @break
                            @case('pt') {{ __('lang_v1.language') }} @break
                            @case('ru') {{ __('lang_v1.language') }} @break
                            @case('vi') {{ __('lang_v1.language') }} @break
                            @case('zh-CN') {{ __('lang_v1.language') }} @break
                            @endswitch
                        </span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'motion-safe:animate-[squeeze_0.6s_ease-in-out]': open }"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-3xl bg-white shadow-xl border focus:outline-none">
                        @foreach(config('app.available_locales') as $locale)
                        <a wire:navigate href="{{ route('lang.switch', $locale) }}" class="flex items-center px-4 py-2 transition-all text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 last:rounded-b-3xl first:rounded-t-3xl
                            {{ app()->getLocale() === $locale ? 'bg-gray-100 font-medium' : '' }}">
                            <span class="mr-2">
                                @switch($locale)
                                @case('ar') 🇸🇦 @break
                                @case('de') 🇩🇪 @break
                                @case('en') 🇬🇧 @break
                                @case('es') 🇪🇸 @break
                                @case('fa') 🇮🇷 @break
                                @case('fr') 🇫🇷 @break
                                @case('ha') 🇳🇬 @break
                                @case('hi') 🇮🇳 @break
                                @case('it') 🇮🇹 @break
                                @case('pt') 🇵🇹 @break
                                @case('ru') 🇷🇺 @break
                                @case('vi') 🇻🇳 @break
                                @case('zh-CN') 🇨🇳 @break
                                @endswitch
                            </span>
                            {{ config('app.locale_names')[$locale] }}
                        </a>
                        @endforeach
                    </div>
                </div>
                <a wire:navigate href="{{ route('claimer-register') }}"
                    class="relative inline-flex items-center overflow-hidden w-full px-6 py-3 text-sm font-medium leading-4 text-white bg-gradient-to-r from-blue-400  to-green-400 md:w-auto md:rounded-full hover:bg-[#3B82F6] focus:outline-none md:focus:ring-2 focus:ring-0 focus:ring-offset-2 focus:ring-blue-800 transition-all duration-300 hover-scale">
                    @auth('claimer')
                    {{ __('lang_v1.dashboard') }}
                    @else
                    {{ __('lang_v1.sign_up') }}
                    @endauth
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
                            <span class="block mb-1 font-medium text-black">{{ __('lang_v1.lost_items') }}</span>
                            <span class="block font-light leading-5 text-gray-600">{{ __('lang_v1.lost_items_description') }}</span>
                        </a>
                        <a wire:navigate href="{{ route('lost-items.store') }}" @click="navigationMenuClose()"
                            class="block px-3.5 py-3 text-sm rounded-xl hover:bg-slate-100 transition-all duration-300 border border-transparent mt-2">
                            <span class="block mb-1 font-medium text-black">{{ __('lang_v1.post_item') }}</span>
                            <span class="block font-light leading-5 text-gray-600">{{ __('lang_v1.post_item_description') }}</span>
                        </a>
                    </div>
                    <div class="w-full mt-4 sm:mt-0 sm:w-72">
                        <a href="#" @click.prevent="$dispatch('open-contact-form')" @click="navigationMenuClose()"
                            class="block px-3.5 py-3 text-sm rounded-xl hover:bg-slate-100 transition-all duration-300 border border-transparent">
                            <span class="block mb-1 font-medium text-black">{{ __('lang_v1.send_message') }} <span class="ml-2  text-xs pointer-events-none text-gray-400">⌘M</span></span>
                            <span class="block font-light leading-5 text-gray-600">{{ __('lang_v1.send_message_description') }}</span>
                        </a>
                        <a wire:navigate href="{{ route('contact-us') }}" @click="navigationMenuClose()"
                            class="block px-3.5 py-3 text-sm rounded-xl hover:bg-slate-100 transition-all duration-300 border border-transparent mt-2">
                            <span class="block mb-1 font-medium text-black">{{ __('lang_v1.report_lost_item') }}</span>
                            <span class="block font-light leading-5 text-gray-600">{{ __('lang_v1.we_love_to_here_from_you') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="modalOpen" x-data="{
                     resetSearch() {
                         Livewire.dispatch('reset-search');
                         this.modalOpen = false;
                     }
                 }" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>

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
                    <h3 class="text-lg font-semibold">{{ __('lang_v1.search_lost_items') }}</h3>
                    <button @click="resetSearch()"
                        class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50 transition-all duration-300">
                        <flux:icon.x class="w-5 h-5" />
                    </button>
                </div>

                <livewire:lost-item-search lazy />

                <div class="flex justify-end mt-4">
                    <button @click="resetSearch()" type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors border border-gray-300 rounded-full hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-neutral-100 focus:ring-offset-2">
                        {{ __('lang_v1.close') }}
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
                        <h2 class="text-lg font-medium text-gray-900">{{ __('lang_v1.send_message') }}</h2>
                        <button @click="showContactForm = false" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">{{ __('lang_v1.close_panel') }}</span>
                            <flux:icon.x class="w-6 h-6" />
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

        window.addEventListener('close-contact-form', () => {
            const panel = document.querySelector('[x-data*="showContactForm"]');
            if (panel) {
                panel.__x.$data.showContactForm = false;
            }
        });
    });
</script>
