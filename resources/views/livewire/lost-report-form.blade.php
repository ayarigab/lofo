<div>
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
