<div class="container mx-auto px-4 py-8 min-h-dvh">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-sm p-6 md:p-8">
            <div class="flex flex-col md:flex-row gap-6 md:gap-8">
                <!-- Left Column - Avatar Section -->
                <div class="w-full md:w-1/3">
                    <div class="space-y-4 sticky top-4">
                        <div class="text-center">
                            <div class="relative inline-block">
                                <div
                                    class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-md mx-auto">
                                    @if($avatarPreview)
                                    <img src="{{ asset('storage/'.$avatarPreview) }}" class="w-full h-full object-cover"
                                        alt="Profile photo">
                                    @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <label
                                    class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full shadow-md cursor-pointer hover:bg-blue-600 transition">
                                    <input type="file" class="hidden" wire:model="avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </label>
                            </div>
                            <h2 class="mt-4 text-xl font-semibold text-gray-800">{{ $full_name }}</h2>
                            <p class="text-gray-500">{{ $email }}</p>
                        </div>

                        <div class="mt-6 space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Member since</p>
                                <p class="text-gray-700">{{ Auth::guard('claimer')->user()->created_at->format('M d,
                                    Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Last updated</p>
                                <p class="text-gray-700">{{ Auth::guard('claimer')->user()->updated_at->format('M d,
                                    Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form Section -->
                <div class="w-full md:w-2/3">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Profile Information</h3>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full
                                Name</label>
                            <input type="text" id="full_name" wire:model.defer="full_name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                Number</label>
                            <input type="tel" id="phone" wire:model.defer="phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">Date of
                                Birth</label>
                            <input type="date" id="dob" wire:model.defer="dob"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('dob') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" id="location" wire:model.defer="location"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email (readonly) -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                Address</label>
                            <input type="email" id="email" value="{{ $email }}" readonly
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                        </div>

                        <div class="pt-4 flex justify-end space-x-3">
                            <button type="button"
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                                <span wire:loading wire:target="save" class="mr-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </span>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
