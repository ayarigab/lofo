<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    @forelse($matches as $item)
    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
        <div class="h-40 bg-gray-100 overflow-hidden">
            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
        </div>
        <div class="p-4">
            <h3 class="font-medium text-gray-900 mb-1 truncate">{{ $item->title }}</h3>
            <p class="text-sm text-gray-500 mb-2">Found on {{ $item->found_date?->format('M d, Y') ?? 'Unknown date' }}
            </p>
            <div class="flex justify-between items-center">
                <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800">
                    {{ $item->category->name ?? 'Uncategorized' }}
                </span>
                <a href="{{ route('found-items.show', $item->id) }}"
                    class="text-xs text-[#4F46E5] hover:underline">View</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="mt-2 text-sm text-gray-500">No potential matches found for your reports</p>
    </div>
    @endforelse
</div>
