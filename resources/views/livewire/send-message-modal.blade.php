<div>
    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Subject</label>
            <input type="text" id="title" wire:model="title"
                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="Enter message subject" required>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Your Message</label>
            <textarea id="message" wire:model="message" rows="4"
                class="w-full px-4 py-2 border border-gray-300 rounded-3xl focus:ring-[#3B82F6] focus:border-[#3B82F6]"
                placeholder="Write your message here..." required></textarea>
            @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <button type="button" @click="showContactForm = false"
                class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors border border-gray-300 rounded-full hover:bg-gray-50 hover-scale">
                Cancel
            </button>
            <button type="submit"
                class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 hover:bg-green-700 rounded-full hover-scale">
                Send Message
            </button>
        </div>
    </form>
</div>
