<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800"
    x-data="{
        contextMenuOpen: false,
        contextMenuToggle: function(event) {
            this.contextMenuOpen = true;
            event.preventDefault();
            this.$refs.contextmenu.classList.add('opacity-0');
            let that = this;
            $nextTick(function(){
                that.calculateContextMenuPosition(event);
                that.calculateSubMenuPosition(event);
                that.$refs.contextmenu.classList.remove('opacity-0');
            });
        },
        calculateContextMenuPosition (clickEvent) {
            if(window.innerHeight < clickEvent.clientY + this.$refs.contextmenu.offsetHeight){
                this.$refs.contextmenu.style.top = (window.innerHeight - this.$refs.contextmenu.offsetHeight) + 'px';
            } else {
                this.$refs.contextmenu.style.top = clickEvent.clientY + 'px';
            }
            if(window.innerWidth < clickEvent.clientX + this.$refs.contextmenu.offsetWidth){
                this.$refs.contextmenu.style.left = (clickEvent.clientX - this.$refs.contextmenu.offsetWidth) + 'px';
            } else {
                this.$refs.contextmenu.style.left = clickEvent.clientX + 'px';
            }
        },
        calculateSubMenuPosition (clickEvent) {
            let submenus = document.querySelectorAll('[data-submenu]');
            let contextMenuWidth = this.$refs.contextmenu.offsetWidth;
            for(let i = 0; i < submenus.length; i++){
                if(window.innerWidth < (clickEvent.clientX + contextMenuWidth + submenus[i].offsetWidth)){
                    submenus[i].classList.add('left-0', '-translate-x-full');
                    submenus[i].classList.remove('right-0', 'translate-x-full');
                } else {
                    submenus[i].classList.remove('left-0', '-translate-x-full');
                    submenus[i].classList.add('right-0', 'translate-x-full');
                }
                if(window.innerHeight < (submenus[i].previousElementSibling.getBoundingClientRect().top + submenus[i].offsetHeight)){
                    let heightDifference = (window.innerHeight - submenus[i].previousElementSibling.getBoundingClientRect().top) - submenus[i].offsetHeight;
                    submenus[i].style.top = heightDifference + 'px';
                } else {
                    submenus[i].style.top = '';
                }
            }
        }
    }"
    x-init="
        $watch('contextMenuOpen', function(value){
            if(value === true){ document.body.classList.add('overflow-hidden') }
            else { document.body.classList.remove('overflow-hidden') }
        });
        window.addEventListener('resize', function(event) { contextMenuOpen = false; });
    "
    @contextmenu="contextMenuToggle(event)">

    </div>
    <template x-teleport="body">
        <div x-show="contextMenuOpen" @click.away="contextMenuOpen=false" x-ref="contextmenu"
            class="z-50 min-w-[8rem] text-neutral-800 rounded-md border border-neutral-200/70 bg-white text-sm fixed p-1 shadow-md w-64"
            x-cloak>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 10.5v6m3-3H9m4.06-7.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                </svg>
                <span>New Folder</span>
            </div>
            <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <span>Get Info</span>
            </div>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px stroke-current left-2" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="none">
                        <path
                            d="M20.2507 8.25V5.75C20.2507 4.64543 19.3553 3.75 18.2507 3.75H5.74902C4.64445 3.75 3.74902 4.64543 3.74902 5.75V8.25"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M12 20.25L12 3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M8.75 20.25L15.25 20.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
                <span>Rename</span>
            </div>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px stroke-current left-2" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="none">
                        <path
                            d="M3.75 20.25V5.75C3.75 4.09315 5.09315 2.75 6.75 2.75H12.9225C13.453 2.75 13.9617 2.96075 14.3368 3.33588L19.6643 8.66423C20.0393 9.0393 20.25 9.54796 20.25 10.0783V17.25C20.25 18.9069 18.9069 20.25 17.25 20.25H14.75"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M13.75 2.92993V7.24993C13.75 8.3545 14.6454 9.24993 15.75 9.24993H20.07"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M9.75 5H10.25M9.75 8H10.25M9.75 11H10.25M9.75 14H10.25M7.75 3.5L8.25 3.5M7.75 6.5H8.25M7.75 9.5H8.25M7.75 12.5H8.25M7.75 15.5H8.25"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M7.2627 21.25H10.75C11.0931 21.25 11.3343 20.9124 11.223 20.5879L10.655 18.9305C10.413 18.2244 9.74895 17.75 9.00244 17.75C8.2532 17.75 7.58738 18.2278 7.34748 18.9376L6.78902 20.5899C6.67946 20.914 6.92054 21.25 7.2627 21.25Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <span>Compress "Untitled.pdf"</span>
            </div>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                </svg>
                <span>Duplicate</span>
            </div>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <span>Quick Look</span>
            </div>


            <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px stroke-current left-2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="none">
                        <path d="M7.75 7.757V6.75a3 3 0 0 1 3-3h6.5a3 3 0 0 1 3 3v6.5a3 3 0 0 1-3 3h-.992"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M3.75 10.75a3 3 0 0 1 3-3h6.5a3 3 0 0 1 3 3v6.5a3 3 0 0 1-3 3h-6.5a3 3 0 0 1-3-3v-6.5z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                </svg>
                <span>Copy</span>
            </div>
            <div class="relative group">
                <div
                    class="flex cursor-default select-none items-center rounded px-2 hover:bg-blue-600 hover:text-white py-1.5 outline-none pl-8">
                    <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    <span>Share</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-4 h-4 ml-auto">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
                <div data-submenu
                    class="absolute top-0 right-0 invisible mr-1 duration-200 ease-out translate-x-full opacity-0 group-hover:mr-0 group-hover:visible group-hover:opacity-100">
                    <div
                        class="z-50 min-w-[8rem] overflow-hidden rounded-md border bg-white p-1 shadow-md animate-in slide-in-from-left-1 w-48">
                        <div @click="contextMenuOpen=false"
                            class="relative pl-8 flex cursor-default select-none items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white text-sm outline-none data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                            <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                            </svg>
                            <span>Upload File</span>
                        </div>
                        <div @click="contextMenuOpen=false"
                            class="relative pl-8 flex cursor-default select-none items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white text-sm outline-none data-[disabled]:pointer-events-none data-[disabled]:opacity-50">
                            <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            <span>Email File</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-blue-600 hover:text-white outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                </svg>
                <span>Tags</span>
                <span class="flex items-center h-full pl-3 mt-px space-x-2">
                    <span class="w-2.5 h-2.5 bg-red-400 rounded-full"></span>
                    <span class="w-2.5 h-2.5 bg-orange-400 rounded-full"></span>
                    <span class="w-2.5 h-2.5 bg-yellow-400 rounded-full"></span>
                    <span class="w-2.5 h-2.5 bg-green-400 rounded-full"></span>
                    <span class="w-2.5 h-2.5 bg-blue-400 rounded-full"></span>
                    <span class="w-2.5 h-2.5 bg-purple-400 rounded-full"></span>
                    <span class="w-2.5 h-2.5 bg-gray-300 rounded-full"></span>
                </span>
            </div>
            <div @click="contextMenuOpen=false"
                class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-red-600 hover:text-white text-red-600 outline-none pl-8  data-[disabled]:opacity-50 data-[disabled]:pointer-events-none">
                <svg class="absolute w-4 h-4 -mt-px left-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                <span>Move To Trash</span>
            </div>
        </div>
    </template>
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="layout-grid" :href="route('items')" :current="request()->routeIs('items')" wire:navigate>{{ __('Items') }}</flux:navlist.item>
                    <flux:navlist.item icon="chat-bubble-oval-left-ellipsis" :href="route('messages')" :current="request()->routeIs('messages')" wire:navigate>{{ __('Messages') }}</flux:navlist.item>
                    <flux:navlist.item icon="tag" :href="route('categories')" :current="request()->routeIs('categories')" wire:navigate>{{ __('Categories') }}</flux:navlist.item>
                    <flux:navlist.item icon="scan-search" :href="route('lost-report')" :current="request()->routeIs('lost-report')" wire:navigate>{{ __('Reported Lost') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>
            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="external-link" href="{{ route('home') }}" target="_blank">
                {{ __('Visit Frontend') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
