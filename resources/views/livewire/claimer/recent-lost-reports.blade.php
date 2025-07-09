<div class="space-y-4">
    @forelse($reports as $report)
    <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg transition">
        <div class="flex-shrink-0 p-2 bg-gray-100 rounded-md mr-4">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate">{{ $report->items_lost }}</p>
            <p class="text-sm text-gray-500 truncate">Lost on {{ $report->lost_date?->format('M d, Y') ?? 'Unknown date'
                }}</p>
        </div>
        <div class="ml-4">
            <span
                class="px-2 py-1 text-xs rounded-full
                    {{ $report->status === 'found' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($report->status) }}
            </span>
        </div>
    </div>
    @empty
    <p class="text-gray-500 text-center py-4">No lost reports found</p>
    @endforelse
</div>
