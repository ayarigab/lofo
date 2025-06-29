@include('partials.frontend.header', ['title' => $item->title])

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">
    @include('partials.frontend.navbar')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-4xl mx-auto">
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a wire:navigate href="{{ route('home') }}"
                            class="inline-flex  text-sm font-medium text-gray-700 hover:text-green-600 transition-colors">
                            <flux:icon name="house" class="h-5 w-5 mr-1" />
                            {{ __('lang_v1.home') }}
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <flux:icon name="chevron-right" class="h-5 w-5 text-gray-300" />
                            <a wire:navigate href="{{ route('lost-items') }}"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600 transition-colors md:ml-2">
                                {{ __('lang_v1.lost_items') }}
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <flux:icon name="chevron-right" class="h-5 w-5 text-gray-300" />
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 truncate max-w-xs">{{
                                $item->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white shadow-sm rounded-3xl overflow-hidden">
                <div class="relative">
                    <div x-data="{
                                        imageGalleryOpened: false,
                                        imageGalleryActiveUrl: null,
                                        imageGalleryImageIndex: null,
                                        imageGalleryDirection: 'right',
                                        imageGallery: [
                                            @foreach ([$item->image_url, $item->image2_url, $item->image3_url] as $index => $imageUrl)
                                                @if ($imageUrl)
                                                    {
                                                        'photo': '{{ $imageUrl }}',
                                                        'alt': '{{ $item->title }} Image {{ $index + 1 }}'
                                                    },
                                                @endif
                                            @endforeach
                                        ],
                                        imageGalleryOpen(event) {
                                            this.imageGalleryImageIndex = parseInt(event.target.dataset.index);
                                            this.imageGalleryActiveUrl = this.imageGallery[this.imageGalleryImageIndex-1].photo;
                                            this.imageGalleryOpened = true;
                                        },
                                        imageGalleryClose() {
                                            this.imageGalleryOpened = false;
                                            setTimeout(() => this.imageGalleryActiveUrl = null, 300);
                                        },
                                        imageGalleryNext(){
                                            this.imageGalleryDirection = 'right';
                                            this.imageGalleryImageIndex = (this.imageGalleryImageIndex == this.imageGallery.length) ? 1 : (this.imageGalleryImageIndex + 1);
                                            this.imageGalleryActiveUrl = this.imageGallery[this.imageGalleryImageIndex-1].photo;
                                        },
                                        imageGalleryPrev() {
                                            this.imageGalleryDirection = 'left';
                                            this.imageGalleryImageIndex = (this.imageGalleryImageIndex == 1) ? this.imageGallery.length : (this.imageGalleryImageIndex - 1);
                                            this.imageGalleryActiveUrl = this.imageGallery[this.imageGalleryImageIndex-1].photo;
                                        }
                                    }" @keyup.right.window="imageGalleryNext();" @keyup.left.window="imageGalleryPrev();"
                        class="w-full h-full select-none">

                        <div class="relative overflow-hidden">
                            @if($item->image_url)
                            <img x-on:click="imageGallery.length > 0 ? imageGalleryOpen($event) : null" src="{{ $item->image_url }}"
                                alt="{{ $item->title }}" data-index="1"
                                class="w-full h-full object-cover rounded-t-2xl transition-transform duration-500 hover:scale-105 cursor-pointer"
                                :class="{'cursor-zoom-in': imageGallery.length > 0, 'cursor-default': imageGallery.length === 0}">
                            @endif

                            @if($item->image2_url || $item->image3_url)
                            <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-black to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 px-4 -mt-8">
                                <div class="flex gap-2 items-center justify-center p-2">
                                    @foreach([$item->image_url, $item->image2_url, $item->image3_url] as $index => $imageUrl)
                                    @if($imageUrl)
                                    <img x-on:click="imageGalleryOpen" src="{{ $imageUrl }}" alt="Thumbnail {{ $index + 1 }}"
                                        data-index="{{ $index + 1 }}"
                                        class="w-16 h-16 object-cover rounded-md cursor-pointer hover:ring-2 bg-[url(data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAYGBgYGBgYHBwYJCgkKCQ0MCwsMDRQODw4PDhQfExYTExYTHxshGxkbIRsxJiIiJjE4Ly0vOEQ9PURWUVZwcJb/wgALCAApACkBAREA/8QAGgAAAgMBAQAAAAAAAAAAAAAABQYCAwQAB//aAAgBAQAAAAD2Yw1q4Se7YYEYuchae2GKwErao8vGGxYBTznmtZXbv//EADkQAAEBBQMFDQkBAAAAAAAAAAECAAMEBRESFTEGECE0kRMUIiMkQVFUc4GSorEWMjM1U3GDssHh/9oACAEBAAE/AATQaS0jPLTXTxSsdLWR0Bp8LEW6A0cUGqektU9J2tdEyA0wx2hoKHfS17viLRYdlJQFY6T9mM3lxAo/8paOdLmj5D2CRuiEosKOFD3tdEx6sdoa6476PmGafWd4IomnHJ780hURCPwOd7/M9/qpqg8bJiTOuSFAdD4lqtr3djezoprmAqeBgxf3ITDhO7W+HaPBpzNf6uqDxtfZ6t5/8YYBpJrquyVmygJMa7NCKuh65qsnBsnfmX4V+oYNlLrznsB+xz//2Q==)] hover:ring-green-600 transition-all duration-200">
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <template x-teleport="body">
                            <div x-show="imageGalleryOpened" x-transition:enter="transition ease-in-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:leave="transition ease-in-out duration-300"
                                x-transition:leave-end="opacity-0" @click="imageGalleryClose" @keydown.window.escape="imageGalleryClose"
                                x-trap.inert.noscroll="imageGalleryOpened"
                                class="fixed inset-0 z-[99] flex items-center justify-center bg-white/10 backdrop-blur-sm bg-opacity-70 transition-opacity select-none cursor-zoom-out"
                                x-cloak>
                                <div class="relative flex items-center justify-center w-11/12 xl:w-4/5 h-4/5">
                                    <div class="relative w-full h-full overflow-hidden">
                                        <template x-for="(image, index) in imageGallery" :key="index">
                                            <img x-show="imageGalleryImageIndex === index + 1"
                                                x-transition:enter="transition ease duration-300"
                                                x-transition:enter-start="opacity-0 transform translate-y-10"
                                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                                x-transition:leave="transition ease duration-300"
                                                x-transition:leave-start="opacity-100 transform scale-0"
                                                x-transition:leave-end="opacity-0 transition scale-90" :class="{
                                                                    'absolute inset-0': true,
                                                                    'scale-90': imageGalleryDirection === 'right' && imageGalleryImageIndex !== index + 1,
                                                                    'scale-90': imageGalleryDirection === 'left' && imageGalleryImageIndex !== index + 1
                                                                }"
                                                class="object-contain object-center w-full h-full select-none rounded-lg"
                                                :src="image.photo" :alt="image.alt">
                                        </template>
                                    </div>

                                    <button x-show="imageGallery.length > 1" @click.stop="imageGalleryPrev()" @keydown.window.next="imageGalleryPrev()"
                                        class="absolute left-0 flex items-center justify-center text-black rounded-full cursor-pointer bg-black/10 w-14 h-14 hover:bg-black/20 active:scale-110 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition-all">
                                        <flux:icon name="chevron-left" class="w-6 h-6" />
                                    </button>

                                    <button x-show="imageGallery.length > 1" @click.stop="imageGalleryNext()"
                                        class="absolute right-0 flex items-center justify-center text-black rounded-full cursor-pointer bg-black/10 w-14 h-14 hover:bg-black/20 active:scale-110 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition-all">
                                        <flux:icon name="chevron-right" class="w-6 h-6" />
                                    </button>

                                    <button @click.stop="imageGalleryClose"
                                        class="absolute top-4 right-4 p-2 text-white rounded-full bg-black/50 hover:bg-black/75 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 hover-scale">
                                        <flux:icon name="x" class="w-6 h-6" />
                                    </button>

                                    <div x-show="imageGallery.length > 1"
                                        class="absolute bottom-4 invert left-0 right-0 mx-auto text-center text-black text-sm bg-white/10 backdrop-blur-sm rounded-full shadow-sm w-12 px-2">
                                        <span x-text="imageGalleryImageIndex"></span> / <span x-text="imageGallery.length"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    @php
                    $statusConfig = [
                        'pending' => [
                            'text' => 'text-red-800',
                            'bg' => 'bg-red-100',
                            'icon' => 'clock',
                            'label' => __('lang_v1.pending')
                        ],
                        'archived' => [
                            'text' => 'text-yellow-800',
                            'bg' => 'bg-yellow-100',
                            'icon' => 'trash',
                            'label' => __('lang_v1.archived')
                        ],
                        'claimed' => [
                            'text' => 'text-purple-800',
                            'bg' => 'bg-purple-100',
                            'icon' => 'heart-handshake',
                            'label' => __('lang_v1.claimed')
                        ],
                        'approved' => [
                            'text' => 'text-green-800',
                            'bg' => 'bg-green-100',
                            'icon' => 'circle-check-big',
                            'label' => __('lang_v1.approved')
                        ],
                        'default' => [
                            'text' => 'text-green-800',
                            'bg' => 'bg-green-100',
                            'icon' => 'circle-check-big',
                            'label' => __('lang_v1.approved')
                        ]
                    ];
                    $config = $statusConfig[$item->status] ?? $statusConfig['default'];
                    @endphp
                    <div
                        class="absolute top-4 right-4 flex items-center bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold shadow-sm {{ $config['text'] }} {{ $config['bg'] }}">
                        <flux:icon name="{{ $config['icon'] }}" class="h-4 w-4 mr-1" />
                        {{ $config['label'] }}
                    </div>
                </div>

                <div class="px-8 py-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $item->title }}</h1>
                            <div class="mt-2 flex items-center space-x-2">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <flux:icon name="tag" class="h-4 w-4 mr-1" />
                                    {{ $item->category->name ?? __('lang_v1.uncategorized') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <flux:icon name="calendar-days" class="h-5 w-5 mr-1" />
                            {{ $item->created_at->format('M j, Y') }}
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <div class="flex items-center mb-3">
                                <flux:icon name="newspaper" class="h-6 w-6 text-gray-500 mr-2" />
                                <h3 class="text-xl font-semibold text-gray-900">{{ __('lang_v1.description') }}</h3>
                            </div>
                            <p class="mt-2 text-gray-600 whitespace-pre-line leading-relaxed">{{ $item->description }}</p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-2xl">
                            <div class="flex items-center mb-3">
                                <flux:icon name="badge-info" class="h-6 w-6 text-gray-500 mr-2" />
                                <h3 class="text-xl font-semibold text-gray-900">{{ __('lang_v1.details') }}</h3>
                            </div>
                            <dl class="space-y-4">
                                @if($item->brand)
                                <div class="flex justify-between items-center">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <flux:icon name="briefcase" class="h-4 w-4 mr-2" />
                                        Brand
                                    </dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $item->brand }}</dd>
                                </div>
                                @endif

                                @if($item->model)
                                <div class="flex justify-between items-center">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <flux:icon name="cog" class="h-4 w-4 mr-2" />
                                        Model
                                    </dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $item->model }}</dd>
                                </div>
                                @endif

                                @if($item->color)
                                <div class="flex justify-between items-center">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <flux:icon name="swatch" class="h-4 w-4 mr-2" />
                                        Color
                                    </dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $item->color }}</dd>
                                </div>
                                @endif

                                <div class="flex justify-between items-center">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <flux:icon name="map-pin" class="h-4 w-4 mr-2" />
                                        Found Location
                                    </dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $item->found_location ?? 'Unknown'
                                        }}</dd>
                                </div>

                                <div class="flex justify-between items-center">
                                    <dt class="flex items-center text-sm font-medium text-gray-500">
                                        <flux:icon name="calendar-days" class="h-4 w-4 mr-2" />
                                        Found Date
                                    </dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $item->found_date ?
                                        $item->found_date->diffForHumans() : 'Unknown' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-8">
                        <div class="flex items-center mb-4">
                            <flux:icon name="user-circle" class="h-6 w-6 text-gray-500 mr-2" />
                            <h3 class="text-xl font-semibold text-gray-900">Founder Information</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Founder Name</h4>
                                <p class="text-sm font-medium text-gray-900">{{ $item->founder_name }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Contact Phone</h4>
                                <p class="text-sm font-medium text-gray-900">{{ $item->founder_phone }}</p>
                            </div>
                            @if($item->founder_email)
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Email</h4>
                                <p class="text-sm font-medium text-gray-900">{{ $item->founder_email }}</p>
                            </div>
                            @endif
                            @if($item->founder_address)
                            <div class="bg-gray-50 p-4 rounded-xl md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Address</h4>
                                <p class="text-sm font-medium text-gray-900">{{ $item->founder_address }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div
                    x-data="{
                        claimItem() {
                            @auth('claimer')
                                window.dispatchEvent(new CustomEvent('toast-show', {
                                    detail: {
                                        type: 'success',
                                        message: 'Success!',
                                        description: 'Item has been successfully reported.'
                                    }
                                }));
                            @else
                                window.dispatchEvent(new CustomEvent('toast-show', {
                                    detail: {
                                        type: 'danger',
                                        message: 'Login to claim Item',
                                        description: 'To claim {{ $item->title }} you need to login now.'
                                    }
                                }));
                            @endauth
                        }
                    }"
                    class="mt-10 border-t border-gray-200 pt-8 text-center">
                        <button
                            @click="claimItem"
                            class="inline-flex items-center px-8 py-3 bg-green-600 text-white rounded-full shadow-lg text-base font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-all transform hover-scale">
                            <flux:icon name="gift" />
                            Claim This Item
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('partials.frontend.footer')
</body>

</html>
