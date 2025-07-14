<div x-data="phoneInput">
    <form wire:submit.prevent="register" class="space-y-4 px-8 py-6 bg-white rounded-3xl shadow-xl">
        <div class="mb-4">
            <label for="full_name" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.your_name') }}</label>
            <input wire:model="full_name" type="text" id="full_name" required placeholder="{{ __('lang_v1.enter_full_name') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('full_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.email_address') }}{{ __('lang_v1.this_will_be_used_as_login') }}</label>
            <input wire:model="email" type="email" id="email" required placeholder="{{ __('lang_v1.enter_email_address') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.phone') }}</label>
            <input x-ref="phoneInput" wire:model="phone" type="tel" id="phone" required placeholder="{{ __('lang_v1.enter_phone_number') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="location" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.current_location') }}</label>
            <input wire:model="location" type="text" id="location" required placeholder="{{ __('lang_v1.enter_your_current_location') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('location') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4" x-data
            x-init="
            flatpickr($refs.dateInput, {
                altInput: true,
                locale: '{{ (app()->getLocale() === 'zh-CN') ? 'zh' : app()->getLocale() }}',
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                maxDate: new Date(new Date().getFullYear() - 5, 11, 31)
            })">
            <label for="dob" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.dob') }}</label>
            <input wire:model="dob" x-ref="dateInput" type="text" id="dob" required placeholder="{{ __('lang_v1.select_your_date_of_birth') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('dob') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.new_password') }}</label>
            <input wire:model="password" type="password" id="password" required placeholder="{{ __('lang_v1.choose_a_new_password') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('lang_v1.confirm_password') }}</label>
            <input wire:model="password_confirmation" type="password" id="password_confirmation" required
                placeholder="{{ __('lang_v1.confirm_your_password') }}"
                class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div x-data="{
                cropOpen: false,
                currentField: null,
                cropper: null,
                roundedCanvas: null,

                initCropper(imageId, fieldName) {
                    this.currentField = fieldName;
                    const image = document.getElementById(imageId);
                    const imageToCrop = document.getElementById('imageToCrop');

                    imageToCrop.onload = () => {
                        if (this.cropper) {
                            this.cropper.destroy();
                        }

                        this.cropper = new Cropper(imageToCrop, {
                            aspectRatio: 1,
                            viewMode: 1,
                            autoCropArea: 1,
                            responsive: true,
                            guides: false,
                            movable: true,
                            zoomable: true,
                            rotatable: true,
                            scalable: true,
                            center: true
                        });
                    };

                    imageToCrop.src = image.src;
                    this.cropOpen = true;
                },

                closeCropper() {
                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }
                    this.cropOpen = false;
                },

                getRoundedCanvas(sourceCanvas) {
                    var rnCanvas = document.createElement('canvas');
                    var context = rnCanvas.getContext('2d');
                    var width = sourceCanvas.width;
                    var height = sourceCanvas.height;

                    rnCanvas.width = width;
                    rnCanvas.height = height;
                    context.imageSmoothingEnabled = true;
                    context.drawImage(sourceCanvas, 0, 0, width, height);
                    context.globalCompositeOperation = 'destination-in';
                    context.beginPath();
                    context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
                    context.fill();
                    return rnCanvas;
                },

                async cropButton() {
                    if (this.cropper) {
                        const canvas = this.cropper.getCroppedCanvas();

                        this.roundedCanvas = this.getRoundedCanvas(canvas);

                        this.roundedCanvas.toBlob((blob) => {
                            const file = new File([blob], 'cropped-image.webp', {
                                type: 'image/webp',
                            });

                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);

                            let input;
                            if (this.currentField === 'avatar') {
                                input = document.getElementById('avatar');
                            }

                            if (input) {
                                input.files = dataTransfer.files;
                                const event = new Event('change', { bubbles: true });
                                input.dispatchEvent(event);
                            }

                            this.closeCropper();
                        }, 'image/webp', 0.9);
                    }
                },
            }">
            <div class="mb-6">
                <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('lang_v1.user_photo') }}{{ __('lang_v1.required') }}</label>
                <div class="flex items-center space-x-4">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center relative group overflow-hidden">
                        @if($previewAvatar)
                        <img src="{{ $previewAvatar }}" class="w-full h-full object-cover" id="avatar-preview" alt="{{ __('lang_v1.profile_picture') }}">
                        <div
                            x-data="{
                                init() {
                                    initCropper('avatar-preview', 'avatar');
                                }
                            }"
                            class="absolute inset-0 bg-white/10 rounded-2xl backdrop-blur-[2px] opacity-0 -translate-y-2 scale-95 ease-out duration-300 group-hover:opacity-100 group-hover:translate-y-0 group-hover:scale-100 transition-all flex items-center justify-center space-x-2">
                            <button type="button" @click="cropOpen = true; initCropper('avatar-preview', 'avatar')"
                                class="p-1 bg-white/70 rounded-full hover-scale">
                                <flux:icon name="adjustments-horizontal" class="h-5 w-5" />
                            </button>
                            <button type="button" wire:click="$set('avatar', null)" class="p-1 bg-white/70 rounded-full hover-scale">
                                <flux:icon name="trash" class="h-5 w-5" />
                            </button>
                        </div>
                        @else
                        <flux:icon name="image" class="w-10 h-10 text-gray-400 inline-block" />
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" id="avatar" wire:model="avatar" accept=".png, .jpg, .jpeg, .gif, .webp, .svg" class="hidden">
                        <label for="avatar"
                            class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm hover-scale font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <flux:icon name="image-up" class="w-5 h-5 inline-block mr-2" />
                            {{ __('lang_v1.choose_file') }}
                        </label>
                        @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <template x-teleport="body">
                <div x-show="cropOpen" class="fixed top-0 left-0 z-50 w-screen h-screen" x-cloak>
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="cropOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="cropButton()"
                            class="absolute inset-0 w-full h-full bg-white/10 backdrop-blur-sm bg-opacity-70">
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="cropOpen" x-trap.inert.noscroll="cropOpen" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                            class="inline-block align-bottom bg-white rounded-3xl border text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ __('lang_v1.crop_image') }}</h3>
                                        <div class="mt-2">
                                            <div class="img-container">
                                                <img id="imageToCrop" src="" style="max-width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" @click="cropButton()"
                                    class="w-full inline-flex justify-center rounded-full px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 hover-scale focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ __('lang_v1.save') }}
                                </button>
                                <button type="button" @click="cropButton()"
                                    class="w-full inline-flex justify-center rounded-full border border-gray-400 px-4 py-2 bg-white text-base font-medium text-gray-700 hover-scale hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ __('lang_v1.cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="mb-4">
            <button type="submit" wire:loading.attr="disabled"
                class="w-full px-6 py-3 text-white bg-green-600 rounded-full hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 transition-all hover-scale disabled:opacity-50 disabled:cursor-not-wait">
                <span wire:loading.remove>{{ __('lang_v1.create_account') }}</span>
                <span wire:loading class="flex items-center justify-center">
                    <flux:icon name="loader-pinwheel" class="animate-spin -ml-1 mr-3 h-5 w-5 text-whit inline-block" />
                    {{ __('lang_v1.processing') }}
                </span>
            </button>
        </div>
        <div class="relative py-6">
            <div class="absolute inset-0 flex items-center"><span class="w-full border-t"></span></div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="px-2 bg-white text-neutral-500">{{ __('lang_v1.already_have_an_account') }}</span>
            </div>
        </div>
        <a class="hover-scale inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium border rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 disabled:opacity-50 disabled:pointer-events-none border-input hover:bg-neutral-100"
            wire:navigate href="{{ route('claimer-login') }}">
            {{ __('lang_v1.login_here') }}
        </a>
        <p class="px-8 mt-2 text-xs text-center text-neutral-500">{{ __('lang_v1.by_continuing_you_agree') }}
            <a class="underline underline-offset-4 hover:text-black" href="/terms">{{ __('lang_v1.terms_and_conditions') }}</a>
            ||
            <a class="underline underline-offset-4 hover:text-black" href="/privacy">{{ __('lang_v1.privacy_policies') }}</a>.
        </p>
    </form>
</div>
