
<section class="w-full px-4 pb-0 antialiased bg-white">
    @include('partials.frontend.navbar')
    <div class="mx-auto max-w-7xl">
        <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="w-full lg:w-1/4 xl:w-1/5 lg:border-r lg:border-gray-200 lg:pr-6">
                    <div class="sticky top-24 space-y-6">
                        <div class="p-4 bg-white rounded-3xl shadow">
                            <h3 class="text-lg font-medium mb-3">{{ __('lang_v1.search_items') }}</h3>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.500ms="search"
                                    placeholder="{{ __('lang_v1.search_items') }}"
                                    class="w-full px-4 py-2 border rounded-full ring-none focus:ring-2 focus:ring-blue-500 focus:border-none">
                                <button class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-4 bg-white rounded-3xl shadow">
                            <h3 class="text-lg font-medium mb-3">{{ __('lang_v1.categories') }}</h3>
                            <ul class="space-y-2">
                                <li>
                                    <button wire:click="$set('category', 'all')"
                                        class="flex items-center w-full px-3 py-2 text-sm font-medium border {{ $category === 'all' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-700' }} rounded-full hover:bg-gray-100 hover:text-blue-600 transition-all">
                                        <span
                                            class="w-2 h-2 mr-3 rounded-full {{ $category === 'all' ? 'bg-blue-600' : 'bg-gray-400' }}"></span>
                                        {{ __('lang_v1.all_items') }}
                                    </button>
                                </li>
                                @foreach($categories as $cat)
                                <li>
                                    <button wire:click="$set('category', '{{ $cat->id }}')"
                                        class="flex items-center w-full px-3 py-2 text-sm font-medium border {{ $category == $cat->id ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-700' }} rounded-full hover:bg-gray-100 hover:text-blue-600 transition-all">
                                        <span
                                            class="w-2 h-2 mr-3 rounded-full {{ $category == $cat->id ? 'bg-blue-600' : 'bg-gray-400' }}"></span>
                                        {{ $cat->name }}
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="p-4 bg-white rounded-3xl shadow">
                            <h3 class="text-lg font-medium mb-3">{{ __('lang_v1.status') }}</h3>
                            <div class="space-y-2">
                                @foreach(['pending', 'claimed', 'approved', 'archived'] as $statusOption)
                                <div class="w-full overflow-hidden rounded-2xl">
                                    <label
                                        class="flex items-center p-2 justify-between w-full text-gray-500 bg-white border-1 border-gray-200 rounded-2xl cursor-pointer hover:text-gray-600 hover:bg-gray-50 peer-checked:border-green-600 peer-checked:text-green-600">
                                        <input type="checkbox" wire:model.live="status" value="{{ $statusOption }}" class="hidden peer"
                                            id="status-{{ $statusOption }}">
                                        <flux:icon name="check-circle" class="w-8 h-8 text-gray-400 peer-checked:text-green-600" />
                                        <div class="block ml-2">
                                            <div class="w-full text-lg font-semibold">
                                                @switch($statusOption)
                                                @case('pending')
                                                {{ __('lang_v1.pending') }}
                                                @break
                                                @case('claimed')
                                                {{ __('lang_v1.claimed') }}
                                                @break
                                                @case('approved')
                                                {{ __('lang_v1.approved') }}
                                                @break
                                                @case('archived')
                                                {{ __('lang_v1.archived') }}
                                                @break
                                                @endswitch
                                            </div>
                                            <div class="w-full text-xs text-gray-400">
                                                @switch($statusOption)
                                                @case('pending')
                                                {{ __('lang_v1.items_waiting_review') }}
                                                @break
                                                @case('claimed')
                                                {{ __('lang_v1.items_claimed_by_users') }}
                                                @break
                                                @case('approved')
                                                {{ __('lang_v1.items_verified') }}
                                                @break
                                                @case('archived')
                                                {{ __('lang_v1.old_archives') }}
                                                @break
                                                @endswitch
                                            </div>
                                        </div>
                                        <span class="sr-only">
                                            @switch($statusOption)
                                            @case('pending')
                                            {{ __('lang_v1.select') }}{{ __('lang_v1.pending') }}
                                            @break
                                            @case('claimed')
                                            {{ __('lang_v1.select') }}{{ __('lang_v1.claimed') }}
                                            @break
                                            @case('approved')
                                            {{ __('lang_v1.select') }}{{ __('lang_v1.approved') }}
                                            @break
                                            @case('archived')
                                            {{ __('lang_v1.select') }}{{ __('lang_v1.archived') }}
                                            @break
                                            @endswitch
                                        </span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @if($search || $category !== 'all' || !empty($status))
                        <div class="p-4 bg-white rounded-3xl shadow">
                            <button wire:click="resetFilters"
                                class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-full hover:bg-red-200 transition-colors">
                                {{ __('lang_v1.reset_filters') }}
                            </button>
                        </div>
                        @endif
                    </div>
                </aside>

                <main class="w-full lg:w-3/4 xl:w-4/5">
                    <div class="mb-8 text-center md:text-left">
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                            {{ __('lang_v1.lost_and_found') }}
                        </h1>
                        <p class="mt-3 text-lg text-gray-600 max-w-3xl">
                            {{ __('lang_v1.browse_through_the_list') }}
                        </p>
                    </div>

                    <div wire:loading.delay class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                        x-data="{minHeight: '300px'}">
                        @foreach(range(1, 1) as $i)
                        <div class="bg-white rounded-3xl shadow-sm overflow-hidden relative h-full"
                            x-bind:style="'min-height: ' + minHeight">
                            <div
                                class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/60 to-transparent shimmer-animation z-10">
                            </div>

                            <div class="p-4 animate-opacity">
                                <div class="relative h-48 mb-4 bg-gray-100 rounded-2xl"></div>
                                <div class="h-6 w-3/4 bg-gray-100 rounded mb-2"></div>
                                <div class="h-4 w-1/2 bg-gray-100 rounded mb-3"></div>
                                <div class="h-3 w-full bg-gray-100 rounded mb-1"></div>
                                <div class="h-3 w-2/3 bg-gray-100 rounded"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div wire:loading.remove class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                        id="items-container">
                        @forelse ($lostItems as $lostItem)
                        <div class="bg-white rounded-3xl shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300"
                            x-data x-intersect="$el.classList.add('animate-fade-in')">
                            <a wire:navigate href="{{ route('lost-items.show', $lostItem->slug) }}"
                                class="block h-full">
                                <div class="relative h-48 overflow-hidden p-2">
                                    <img class="w-full h-full object-cover transition-transform duration-500 rounded-2xl hover:scale-105"
                                        src="{{ $lostItem->image_url }}" alt="{{ $lostItem->title }}"
                                        loading="lazy">
                                    <div
                                        class="absolute top-4 right-4 bg-white/60 backdrop-blur-md px-2 py-1 rounded-full text-xs font-semibold">
                                        @switch($lostItem->status)
                                        @case('pending')
                                        {{ __('lang_v1.pending') }}
                                        @break
                                        @case('claimed')
                                        {{ __('lang_v1.claimed') }}
                                        @break
                                        @case('approved')
                                        {{ __('lang_v1.approved') }}
                                        @break
                                        @case('archived')
                                        {{ __('lang_v1.archived') }}
                                        @break
                                        @endswitch
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-800 mb-1">{{
                                                $lostItem->title }}</h3>
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-600 rounded-full">
                                                {{ $lostItem->category->name ?? __('lang_v1.uncategorized') }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="mt-3 text-gray-600 line-clamp-2">{{ $lostItem->description }}</p>
                                    <div class="flex items-center mt-2 text-xs text-gray-500">
                                        <span>
                                            <flux:icon name="map-pin" class="w-4 h-4 mx-auto text-gray-400 inline-block truncate text-ellipsis" />
                                            {{ $lostItem->found_location ?? __('lang_v1.unknown') }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span>
                                            <flux:icon name="clock" class="w-4 h-4 mx-auto text-gray-400 inline-block truncate text-ellipsis" /> {{
                                            $lostItem->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12 animate-fade-in">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">{{ __('lang_v1.no_items_available') }}</h3>
                            <p class="mt-1 text-gray-500">
                                @if($search || $category !== 'all' || !empty($status))
                                {{ __('lang_v1.no_items_found_criteria') }}
                                @else
                                {{ __('lang_v1.currently_no_lost_items') }}
                                @endif
                            </p>
                            <div class="mt-6">
                                <a wire:navigate href="{{ route('contact-us') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover-scale">
                                    {{ __('lang_v1.report_lost_item') }}
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    @if($lostItems->hasPages())
                    <div class="mt-10">
                        {{ $lostItems->links() }}
                    </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</section>
