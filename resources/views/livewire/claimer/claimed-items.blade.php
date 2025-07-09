<div class="overflow-hidden rounded-lg">
    <table class="min-w-full">
        <thead class="sticky top-0 bg-slate-50/50 backdrop-blur-sm uppercase text-slate-500 text-left text-xs font-medium tracking-wider">
            <tr>
                <th scope="col" class="px-6 py-3">Item</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Date Claimed</th>
                <th scope="col" class="px-6 py-3"><span class="sr-only">Actions</span></th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($items as $item)
            <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-200 transition-colors">
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/'.$item->lostFound->image) }}"
                                alt="">
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->lostFound->title }}</div>
                            <div class="text-sm text-slate-500">{{ $item->lostFound->category->name ?? 'Uncategorized' }}
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $item->is_claimed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $item->is_claimed ? 'Claimed' : 'Pending' }}
                    </span>
                </td>
                <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-500">
                    {{-- {{ $item->claimed_at?->format('M d, Y') ?? 'Not claimed yet' }} --}}
                    {{ $item->claimed_at }}
                </td>
                <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                    <a href=""
                        class="text-[#4F46E5] hover:text-[#4338CA]">Details</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                    No items claimed yet
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
