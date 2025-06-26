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
                window.dispatchEvent(new CustomEvent('toast-show', {
                    detail: detail
                }));
            });
        });
    </script>
    <script>
        document.addEventListener('livewire:initialized', function() {
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
                    positionToasts(){
                        if(this.toasts.length == 0) return;

                        for(let i = 0; i < this.toasts.length && i < 4; i++){
                            let toastElement = document.getElementById(this.toasts[i].id);
                            if(toastElement){
                                toastElement.style.zIndex = 100 - (i * 10);
                                if(this.toastsHovered){
                                    toastElement.style.top = (i * (toastElement.getBoundingClientRect().height + this.paddingBetweenToasts)) + 'px';
                                    toastElement.style.scale = '100%';
                                    toastElement.style.transform = 'translateY(0px)';
                                } else {
                                    toastElement.style.top = '0px';
                                    if(i === 0){
                                        toastElement.style.scale = '100%';
                                        toastElement.style.transform = 'translateY(0px)';
                                    } else if(i === 1){
                                        toastElement.style.scale = '94%';
                                        toastElement.style.transform = 'translateY(16px)';
                                    } else if(i === 2){
                                        toastElement.style.scale = '88%';
                                        toastElement.style.transform = 'translateY(32px)';
                                    } else {
                                        toastElement.style.scale = '82%';
                                        toastElement.style.transform = 'translateY(48px)';
                                        toastElement.firstElementChild.classList.remove('opacity-100');
                                        toastElement.firstElementChild.classList.add('opacity-0');
                                        let that = this;
                                        setTimeout(function(){
                                            that.toasts.pop();
                                        }, 300);
                                    }
                                }
                            }
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
                            toastHovered: false
                        }" x-init="
                            $el.firstElementChild.classList.add('opacity-0', '-translate-y-full');
                            setTimeout(function(){
                                setTimeout(function(){
                                    $el.firstElementChild.classList.remove('opacity-0', '-translate-y-full');
                                    $el.firstElementChild.classList.add('opacity-100', 'translate-y-0');
                                    setTimeout(function(){
                                        stackToasts();
                                    }, 10);
                                }, 5);
                            }, 50);

                            setTimeout(function(){
                                setTimeout(function(){
                                    $el.firstElementChild.classList.remove('opacity-100');
                                    $el.firstElementChild.classList.add('opacity-0');
                                    if(toasts.length == 1){
                                        $el.firstElementChild.classList.remove('translate-y-0');
                                        $el.firstElementChild.classList.add('-translate-y-full');
                                    }
                                    setTimeout(function(){
                                        deleteToastWithId(toast.id)
                                    }, 300);
                                }, 5);
                            }, 4000);
                        " @mouseover="toastHovered=true" @mouseout="toastHovered=false"
                    class="absolute w-full duration-300 ease-out select-none sm:max-w-xs">
                    <span
                        class="relative flex flex-col items-start shadow-[0_5px_15px_-3px_rgb(0_0_0_/_0.08)] w-full transition-all duration-300 ease-out bg-white border border-gray-100 sm:rounded-2xl sm:max-w-xs group p-4">
                        <div class="relative">
                            <div class="flex items-center"
                                :class="{ 'text-green-500' : toast.type=='success', 'text-blue-500' : toast.type=='info', 'text-orange-400' : toast.type=='warning', 'text-red-500' : toast.type=='danger' }">

                                <svg x-show="toast.type=='success'" class="w-[22px] h-[22px] mr-1.5 -ml-1"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM16.7744 9.63269C17.1238 9.20501 17.0604 8.57503 16.6327 8.22559C16.2051 7.87615 15.5751 7.93957 15.2256 8.36725L10.6321 13.9892L8.65936 12.2524C8.24484 11.8874 7.61295 11.9276 7.248 12.3421C6.88304 12.7566 6.92322 13.3885 7.33774 13.7535L9.31046 15.4903C10.1612 16.2393 11.4637 16.1324 12.1808 15.2547L16.7744 9.63269Z"
                                        fill="currentColor"></path>
                                </svg>
                                <svg x-show="toast.type=='info'" class="w-[22px] h-[22px] mr-1.5 -ml-1"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM12 9C12.5523 9 13 8.55228 13 8C13 7.44772 12.5523 7 12 7C11.4477 7 11 7.44772 11 8C11 8.55228 11.4477 9 12 9ZM13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12V16C11 16.5523 11.4477 17 12 17C12.5523 17 13 16.5523 13 16V12Z"
                                        fill="currentColor"></path>
                                </svg>
                                <svg x-show="toast.type=='warning'" class="w-[22px] h-[22px] mr-1.5 -ml-1"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.44829 4.46472C10.5836 2.51208 13.4105 2.51168 14.5464 4.46401L21.5988 16.5855C22.7423 18.5509 21.3145 21 19.05 21L4.94967 21C2.68547 21 1.25762 18.5516 2.4004 16.5862L9.44829 4.46472ZM11.9995 8C12.5518 8 12.9995 8.44772 12.9995 9V13C12.9995 13.5523 12.5518 14 11.9995 14C11.4473 14 10.9995 13.5523 10.9995 13V9C10.9995 8.44772 11.4473 8 11.9995 8ZM12.0009 15.99C11.4486 15.9892 11.0003 16.4363 10.9995 16.9886L10.9995 16.9986C10.9987 17.5509 11.4458 17.9992 11.9981 18C12.5504 18.0008 12.9987 17.5537 12.9995 17.0014L12.9995 16.9914C13.0003 16.4391 12.5532 15.9908 12.0009 15.99Z"
                                        fill="currentColor"></path>
                                </svg>
                                <svg x-show="toast.type=='danger'" class="w-[22px] h-[22px] mr-1.5 -ml-1"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9996 7C12.5519 7 12.9996 7.44772 12.9996 8V12C12.9996 12.5523 12.5519 13 11.9996 13C11.4474 13 10.9996 12.5523 10.9996 12V8C10.9996 7.44772 11.4474 7 11.9996 7ZM12.001 14.99C11.4488 14.9892 11.0004 15.4363 10.9997 15.9886L10.9996 15.9986C10.9989 16.5509 11.446 16.9992 11.9982 17C12.5505 17.0008 12.9989 16.5537 12.9996 16.0014L12.9996 15.9914C13.0004 15.4391 12.5533 14.9908 12.001 14.99Z"
                                        fill="currentColor"></path>
                                </svg>
                                <p class="text-[13px] font-medium leading-none text-gray-800" x-text="toast.message">
                                </p>
                            </div>
                            <p x-show="toast.description" class="mt-1.5 text-xs leading-none opacity-70 pl-5"
                                x-text="toast.description"></p>
                        </div>
                        <span @click="burnToast(toast.id)"
                            class="absolute right-0 p-1.5 mr-2.5 text-gray-400 duration-100 ease-in-out rounded-full opacity-0 cursor-pointer hover:bg-gray-50 hover:text-gray-500 top-0 mt-2.5"
                            :class="{ 'opacity-100' : toastHovered, 'opacity-0' : !toastHovered }">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </span>
                </li>
            </template>
        </ul>
    </template>
</div>

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
            <a wire:navigate href="{{ route('home') }}" class="flex items-center py-4 space-x-2 font-extrabold text-gray-900 md:py-0 group">
                <span
                    class="flex items-center justify-center w-16 h-12 p-2 rounded-full transition-all duration-300 group-hover:rotate-12 border-[1.5px] border-black text-white">
                    <x-app-logo-icon />
                </span>
                <span
                    class="uppercase text-xl transition-all duration-300 group-hover:text-[#3B82F6]">Lostfound</span>
            </a>
        </div>

        <div class="top-0 left-0 items-start hidden w-full h-full p-4 text-sm bg-white/10 backdrop-blur-sm bg-opacity-70 md:items-center md:w-3/4 lg:text-base md:bg-transparent md:p-0 md:relative md:flex"
            :class="{'flex fixed': showMenu, 'hidden': !showMenu }">
            <div
                class="flex flex-col w-full h-auto overflow-hidden bg-white rounded-lg md:bg-transparent md:overflow-visible md:rounded-none md:relative md:flex md:flex-row">
                <a wire:navigate href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'bg-black text-slate-100 hover:bg-gray-900' : 'bg-transparent text-black hover:bg-slate-100' }} relative px-4 inline-block w-full py-2 mx-0 ml-6 rounded-3xl transition-all md:ml-0 md:w-auto md:mx-1 lg:mx-2 md:text-center">
                    Home
                </a>

                <div class="relative"
                    @mouseover="navigationMenuOpen=true; navigationMenuReposition($el); navigationMenu='lost-found'"
                    @mouseleave="navigationMenuLeave()">
                    <button
                        class="inline-flex items-center justify-center rounded-3xl w-full px-4 py-2 mx-0 md:w-auto bg-transparent md:mx-1 text-black lg:mx-1 md:text-center hover:bg-slate-100">
                        Lost & Found
                        <svg :class="{ '-rotate-180' : navigationMenuOpen==true && navigationMenu == 'lost-found' }"
                            class="relative ml-1 h-4 w-4 ease-out duration-300"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                </div>

                <a wire:navigate href="{{ route('about-us') }}"
                    class="{{ request()->routeIs('about-us') ? 'bg-black text-slate-100 hover:bg-gray-900' : 'bg-transparent text-black hover:bg-slate-100' }} relative px-4 inline-block w-full py-2 mx-0 ml-6 rounded-3xl transition-all md:ml-0 md:w-auto md:mx-1 lg:mx-2 md:text-center">
                    About US
                </a>
                <a wire:navigate href="{{ route('contact-us') }}"
                    class="{{ request()->routeIs('contact-us') ? 'bg-black text-slate-100 hover:bg-gray-900' : 'bg-transparent text-black hover:bg-slate-100' }} relative px-4 inline-block w-full py-2 mx-0 ml-6 rounded-3xl transition-all md:ml-0 md:w-auto md:mx-1 lg:mx-2 md:text-center">
                    Contact US
                </a>

                <button @click="modalOpen=true"
                    class="absolute top-0 left-0 hidden items-center py-2 border rounded-full mt-6 ml-10 mr-2 text-gray-600 lg:inline-flex md:mt-0 md:ml-2 lg:mx-3 md:relative group transition-all duration-300 hover:border-[#3B82F6] hover:text-[#3B82F6] hover-scale"
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"
                            viewBox="0 0 24 24">

                            <path fill="currentColor"
                                d="M15.088 6.412a2.84 2.84 0 0 0-1.347-.955l-1.378-.448a.544.544 0 0 1 0-1.025l1.378-.448A2.84 2.84 0 0 0 15.5 1.774l.011-.034l.448-1.377a.544.544 0 0 1 1.027 0l.447 1.377a2.84 2.84 0 0 0 1.799 1.796l1.377.448l.028.007a.544.544 0 0 1 0 1.025l-1.378.448a2.84 2.84 0 0 0-1.798 1.796l-.448 1.377l-.013.034a.544.544 0 0 1-1.013-.034l-.448-1.377a2.8 2.8 0 0 0-.45-.848"
                                x-show="!sparkle" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" />

                            <path fill="currentColor"
                                d="M22.783 10.213l-.766-.248a1.58 1.58 0 0 1-.998-.999l-.25-.764a.302.302 0 0 0-.57 0l-.248.764a1.58 1.58 0 0 1-.984.999l-.765.248a.302.302 0 0 0 0 .57l.765.249a1.58 1.58 0 0 1 1 1.002l.248.764a.302.302 0 0 0 .57 0l.249-.764a1.58 1.58 0 0 1 .999-.999l.765-.248a.302.302 0 0 0 0-.57z"
                                x-show="!sparkle" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" />

                            <path fill="currentColor"
                                d="M15.088 6.412a2.84 2.84 0 0 0-1.347-.955l-1.378-.448a.544.544 0 0 1 0-1.025l1.378-.448A2.84 2.84 0 0 0 15.5 1.774l.011-.034l.448-1.377a.544.544 0 0 1 1.027 0l.447 1.377a2.84 2.84 0 0 0 1.799 1.796l1.377.448l.028.007a.544.544 0 0 1 0 1.025l-1.378.448a2.84 2.84 0 0 0-1.798 1.796l-.448 1.377l-.013.034a.544.544 0 0 1-1.013-.034l-.448-1.377a2.8 2.8 0 0 0-.45-.848"
                                x-show="sparkle" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 scale-50"
                                x-transition:enter-end="opacity-100 scale-110" class="text-yellow-600" style="transform-origin: center" />

                            <path fill="currentColor"
                                d="M22.783 10.213l-.766-.248a1.58 1.58 0 0 1-.998-.999l-.25-.764a.302.302 0 0 0-.57 0l-.248.764a1.58 1.58 0 0 1-.984.999l-.765.248a.302.302 0 0 0 0 .57l.765.249a1.58 1.58 0 0 1 1 1.002l.248.764a.302.302 0 0 0 .57 0l.249-.764a1.58 1.58 0 0 1 .999-.999l.765-.248a.302.302 0 0 0 0-.57z"
                                x-show="sparkle" x-transition:enter="transition-all duration-300 delay-100"
                                x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-110"
                                class="text-yellow-400" style="transform-origin: center" />

                            <path fill="currentColor"
                                d="M11.663 3.2a7 7 0 1 0 2.528 12.407l5.102 5.101a1 1 0 0 0 1.414-1.414l-5.1-5.1A6.97 6.97 0 0 0 17 10v-.048a1.5 1.5 0 0 1-.54.097c-.659-.002-1.347-.427-1.56-1.05v-.003q.099.488.1 1.004a5 5 0 1 1-3.852-4.868A1.6 1.6 0 0 1 11 4.47c.001-.517.257-.983.664-1.27"
                                :class="{
                                    'motion-safe:animate-[squeeze_0.6s_ease-in-out]': !spin
                                }" style="transform-origin: center" />
                        </svg>
                        <span class="hidden ml-2 mr-4 md:inline">Search...</span>
                        <div
                            class="absolute top-0 bottom-0 flex items-center gap-x-1.5 pe-3 end-0 text-xs text-zinc-400">
                            <span class="pointer-events-none group-hover:text-blue-500">⌘K</span>
                        </div>
                    </div>
                </button>
            </div>

            <div class="flex flex-col items-start justify-end w-full pt-4 md:items-center md:w-1/3 md:flex-row md:py-0">
                <a wire:navigate href="{{ route('claimer-login') }}"
                    class="w-full px-6 py-2 mr-0 text-gray-700 md:px-6 md:mr-2 lg:mr-3 md:w-auto rounded-full border transition-all duration-300 hover:text-[#3B82F6] hover-scale">Sign
                    In</a>
                <a wire:navigate href="{{ route('claimer-register') }}"
                    class="relative inline-flex items-center overflow-hidden w-full px-6 py-3 text-sm font-medium leading-4 text-white bg-gradient-to-r from-blue-400  to-green-400 md:w-auto md:rounded-full hover:bg-[#3B82F6] focus:outline-none md:focus:ring-2 focus:ring-0 focus:ring-offset-2 focus:ring-blue-800 transition-all duration-300 hover-scale">
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
            class="absolute right-0 flex flex-col items-center justify-center w-10 h-10 bg-white rounded-full cursor-pointer md:hidden hover:bg-gray-100 transition-all duration-300 z-50">
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
                    <h3 class="text-lg font-semibold">Search Lost & Found Items</h3>
                    <button @click="resetSearch()"
                        class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50 transition-all duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <livewire:lost-item-search lazy />

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

        window.addEventListener('close-contact-form', () => {
            const panel = document.querySelector('[x-data*="showContactForm"]');
            if (panel) {
                panel.__x.$data.showContactForm = false;
            }
        });
    });
    </script>
