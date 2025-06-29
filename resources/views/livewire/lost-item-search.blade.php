<div x-data="{ inputText: '' }">
    <div class="relative">
        <input type="text" wire:model.live.debounce.500ms="search"
            placeholder="{{ __('lang_v1.search_input_description') }}"
            x-model="inputText"
            class="w-full px-6 py-3 border rounded-full focus:outline-none focus:ring-2 focus:ring-[#3B82F6] focus:border-transparent"
            x-ref="searchInput" @keydown.enter.prevent />
        @if($search)
        <button wire:click="resetFilters"
            class="absolute right-0 top-0 h-full p-4 text-gray-500 hover:text-gray-700 transition-all duration-300 rounded-full"
            title="{{ __('lang_v1.clear_search') }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        @endif
    </div>

    <div class="flex items-center justify-between mt-4">
        <h4 class="font-medium text-gray-700">{{ __('lang_v1.search_filters') }}</h4>
        @if($search || ($category && $category !== 'all'))
        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:underline">
            {{ __('lang_v1.reset_filters') }}
        </button>
        @endif
    </div>

    <div class="flex gap-2 my-3 flex-wrap" x-data="{
            init() {
                this.$el.querySelectorAll('button').forEach((el, i) => {
                    el.style.transitionDelay = `${i * 30}ms`;
                    el.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => {
                        el.classList.add('transition-all', 'duration-200', 'ease-out');
                        el.classList.remove('opacity-0', 'translate-y-2');
                    }, 10);
                });
            }
        }">
        <button wire:click="$set('category', 'all')" class="px-3 py-1 text-sm rounded-full transition-all
            {{ $category === 'all' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
            {{ __('lang_v1.all_items') }}
        </button>

        @foreach($categories as $cat)
        <button wire:click="$set('category', '{{ $cat->id }}')" class="px-3 py-1 text-sm rounded-full transition-all
            {{ $category == $cat->id ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
            <!-- TODO: Use live translations for models data -->
            {{-- @php
                $translator = new Stichoza\GoogleTranslate\GoogleTranslate(app()->getLocale());
            @endphp --}}
            {{ $cat->name }}
            {{-- {{ $translator->translate($cat->name) }} --}}
        </button>
        @endforeach
    </div>

    <div wire:loading.delay class="grid grid-cols-1 gap-4 mt-4 max-h-[60vh] w-full overflow-y-auto" x-data="{
            init() {
                $el.style.minHeight = '300px';
            }
        }">
        <div class="p-4 border rounded-3xl bg-white relative overflow-hidden group w-full">
            <div
                class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/60 to-transparent shimmer-animation z-10">
            </div>

            <div class="flex items-start gap-3 animate-opacity w-full">
                <div
                    class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-lg transition-all duration-300 group-hover:bg-gray-200">
                </div>
                <div class="flex-1 space-y-2 w-full">
                    <div class="h-5 bg-gray-100 rounded w-full transition-all duration-300 group-hover:bg-gray-200">
                    </div>
                    <div class="h-4 bg-gray-100 rounded w-full transition-all duration-300 group-hover:bg-gray-200">
                    </div>
                    <div class="flex items-center mt-2 space-x-2 w-full">
                        <div class="h-3 bg-gray-100 rounded w-1/3 transition-all duration-300 group-hover:bg-gray-200">
                        </div>
                        <div class="h-1 w-1 bg-gray-200 rounded-full"></div>
                        <div class="h-3 bg-gray-100 rounded w-1/3 transition-all duration-300 group-hover:bg-gray-200">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:loading.remove>
        @if($showResults)
        <div class="grid grid-cols-1 gap-4 mt-4 max-h-[60vh] overflow-y-auto">
            @forelse($results as $index => $item)
            <a wire:navigate href="{{ route('lost-items.show', $item->slug) }}"
                class="block p-4 border rounded-3xl bg-white hover:shadow-md transition-all animate-fade-in"
                @click="modalOpen = false" x-data="{ show: false }"
                x-init="setTimeout(() => show = true, {{ $index * 100 }})">
                <template x-if="show">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded-lg">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                class="object-cover w-full h-full">
                        </div>
                        <div>
                            <h3 class="font-semibold">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $item->description }}</p>
                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                <span>
                                    <flux:icon name="map-pin" class="w-4 h-4 mx-auto text-gray-400 inline-block" /> {{
                                    $item->found_location ?? 'Unknown' }}
                                </span>
                                <span class="mx-2">•</span>
                                <span>
                                    <flux:icon name="clock" class="w-4 h-4 mx-auto text-gray-400 inline-block" /> {{
                                    $item->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </template>
            </a>
            @empty
            <div class="p-4 text-center text-red-600 rounded-3xl bg-red-50 animate-fade-in">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-red-600 animate-fade-in" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                @if($search || ($category && $category !== 'all'))
                {{ __('lang_v1.no_items_found_criteria') }} "<span class="font-bold">{{ $search }}</span>"
                @else
                {{ __('lang_v1.no_items_available') }}
                @endif
            </div>
            @endforelse
        </div>
        @endif
    </div>
</div>
