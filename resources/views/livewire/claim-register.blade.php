<div>
    <form wire:submit.prevent="register" class="space-y-4 px-8 py-6 bg-white rounded-3xl shadow-xl">
        <div class="mb-4">
            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input wire:model="full_name" type="text" id="full_name" required placeholder="Enter your full name"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('full_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email (*this will be used for
                login)</label>
            <input wire:model="email" type="email" id="email" required placeholder="Enter email address"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input wire:model="phone" type="tel" id="phone" required placeholder="Enter your phone number"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
            <input wire:model="location" type="text" id="location" required placeholder="Enter your full address"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('location') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
            <input wire:model="dob" type="date" id="dob" required max="{{ now()->toDateString() }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('dob') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input wire:model="password" type="password" id="password" required placeholder="Choose a new password"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                Password</label>
            <input wire:model="password_confirmation" type="password" id="password_confirmation" required
                placeholder="Confirm your password"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="mb-6">
            <label class="block mb-1 text-sm font-medium text-gray-700">User Photo (*required)</label>
            <div class="flex items-center space-x-4">
                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                    @if($previewAvatar)
                    <img src="{{ $previewAvatar }}" class="w-full h-full object-cover">
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" id="avatar" wire:model="avatar" accept="image/*" class="hidden">
                    <label for="avatar"
                        class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Choose File
                    </label>
                    @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="submit" wire:loading.attr="disabled"
                class="w-full px-6 py-3 text-white bg-green-600 rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-all hover-scale disabled:opacity-50 disabled:cursor-not-wait">
                <span wire:loading.remove>Register now</span>
                <span wire:loading class="flex items-center justify-center">
                    <flux:icon name="loader-pinwheel" class="animate-spin -ml-1 mr-3 h-5 w-5 text-whit inline-block" />
                    Processing...
                </span>
            </button>
        </div>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('claimer-login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Login here
                </a>
            </p>
        </div>
    </form>
</div>
