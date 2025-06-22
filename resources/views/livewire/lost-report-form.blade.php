<div>
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
                        }
                        else if (event.detail?.data) {
                            detail = event.detail.data;
                        }

                        toasts.unshift({
                            id: 'toast-' + Math.random().toString(16).slice(2),
                            show: false,
                            message: detail.message || 'Notification',
                            description: detail.description || '',
                            type: detail.type || 'info'
                        });
                        stackToasts();" @mouseenter="toastsHovered=true;" @mouseleave="toastsHovered=false" x-init="
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

    <form wire:submit.prevent="submit" class="p-8 bg-white rounded-3xl shadow-xl">
        <div class="mb-4">
            <label for="full_name" class="block mb-2 text-sm font-medium text-gray-700">Your Name</label>
            <input type="text" id="full_name" wire:model="full_name"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="Enter full name" />
            @error('full_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" id="email" wire:model="email"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="Enter email address" />
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Phone</label>
            <input type="text" id="phone" wire:model="phone"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="Enter phone number" />
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="items_lost" class="block mb-2 text-sm font-medium text-gray-700">Item(s) Lost</label>
            <input type="text" id="items_lost" wire:model="items_lost"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="Enter the name of item(s)" />
            @error('items_lost') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="lost_date" class="block mb-2 text-sm font-medium text-gray-700">Date Lost (Optional)</label>
            <input type="date" id="lost_date" wire:model="lost_date" max="{{ now()->toDateString() }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]" />
            @error('lost_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="lost_location" class="block mb-2 text-sm font-medium text-gray-700">Lost Location
                (Optional)</label>
            <input type="text" id="lost_location" wire:model="lost_location"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="Enter location where item was lost" />
            @error('lost_location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" wire:model="description" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-3xl focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="Describe the item and any details..."></textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
            class="w-full px-6 py-3 text-white bg-green-600 rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-all hover-scale">
            Submit Report
        </button>
    </form>
</div>
