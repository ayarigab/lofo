<div>
    <div class="relative">
        <input type="text" wire:model.live.debounce.500ms="search"
            placeholder="Search name, category, location, or description..."
            class="w-full px-6 py-3 border rounded-full focus:outline-none focus:ring-2 focus:ring-[#3B82F6] focus:border-transparent"
            x-ref="searchInput" @keydown.enter.prevent />
        @if($search)
        <button wire:click="resetFilters"
            class="absolute right-0 top-0 h-full p-4 text-gray-500 hover:text-gray-700 transition-all duration-300 rounded-full"
            title="Clear search">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        @endif
    </div>

    <div class="flex items-center justify-between mt-4">
        <h4 class="font-medium text-gray-700">Search Filters</h4>
        @if($search || ($category && $category !== 'all'))
        <button wire:click="resetFilters" class="text-sm text-blue-600 hover:underline">
            Reset filters
        </button>
        @endif
    </div>

    <div class="flex gap-2 my-3 flex-wrap">
        <button wire:click="$set('category', 'all')" class="px-3 py-1 text-sm rounded-full transition-all
            {{ $category === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
            All Items
        </button>

        @foreach($categories as $cat)
        <button wire:click="$set('category', '{{ $cat->id }}')" class="px-3 py-1 text-sm rounded-full transition-all
            {{ $category == $cat->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
            {{ $cat->name }}
        </button>
        @endforeach
    </div>

    <div wire:loading.delay class="grid grid-cols-1 gap-4 mt-4 max-h-[60vh] overflow-y-auto"
        x-data="{
            init() {
                $el.style.minHeight = '300px';
            }
        }">
        <div class="p-4 border rounded-3xl bg-white relative overflow-hidden group">
            <div
                class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/60 to-transparent shimmer-animation z-10">
            </div>

            <div class="flex items-start gap-3 animate-opacity">
                <div
                    class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-lg transition-all duration-300 group-hover:bg-gray-200">
                </div>
                <div class="flex-1 space-y-2">
                    <div class="h-5 bg-gray-100 rounded w-3/4 transition-all duration-300 group-hover:bg-gray-200"></div>
                    <div class="h-4 bg-gray-100 rounded transition-all duration-300 group-hover:bg-gray-200"></div>
                    <div class="flex items-center mt-2 space-x-2">
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

    <style>
        .shimmer-animation {
            animation: shimmer 2s infinite cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .animate-opacity {
            animation: fadeIn 0.3s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        [wire\:loading].grid {
            animation: contentFade 0.3s ease-out;
        }

        [wire\:loading\.remove].grid {
            animation: contentFade 0.3s ease-out;
        }

        @keyframes contentFade {
            from {
                opacity: 0.5;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div wire:loading.remove>
        @if($showResults)
        <div class="grid grid-cols-1 gap-4 mt-4 max-h-[60vh] overflow-y-auto">
            @forelse($results as $item)
            <a href="{{ route('lost-items.show', $item->slug) }}"
                class="block p-4 border rounded-3xl bg-white hover:shadow-md transition-shadow"
                @click="modalOpen = false">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded-lg">
                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="object-cover w-full h-full">
                    </div>
                    <div>
                        <h3 class="font-semibold">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $item->description }}</p>
                        <div class="flex items-center mt-2 text-xs text-gray-500">
                            <span><flux:icon name="map-pin" class="w-4 h-4 mx-auto text-gray-400 inline-block" /> {{ $item->found_location ?? 'Unknown' }}</span>
                            <span class="mx-2">•</span>
                            <span><flux:icon name="clock" class="w-4 h-4 mx-auto text-gray-400 inline-block" /> {{ $item->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="p-4 text-center text-gray-500 rounded-3xl bg-gray-50">
                @if($search || ($category && $category !== 'all'))
                No items found matching your search criteria.
                @else
                No items available at the moment.
                @endif
            </div>
            @endforelse
        </div>
        @endif
    </div>
</div>
