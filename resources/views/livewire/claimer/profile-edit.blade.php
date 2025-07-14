<div class="container mx-auto px-4 py-8 min-h-dvh">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-8">
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
            }" class="flex flex-col md:flex-row gap-6 md:gap-8">
                <div class="w-full md:w-1/3">
                    <div class="space-y-4 sticky top-4">
                        <div class="text-right">
                            <div class="relative inline-block">
                                <div
                                    class="group relative w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-md mx-auto">
                                    @if($avatarPreview)
                                    <img src="{{ $avatarPreview ? assetV('storage/'.$avatarPreview) : assetV('storage/'.auth()->guard('claimer')->user()->avatar) }}" class="w-full h-full object-cover" id="avatar-preview" alt="{{ __('lang_v1.profile_picture') }}">
                                    @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <flux:icon name="image" class="w-16 h-16 text-gray-400" />
                                    </div>
                                    @endif

                                    <input type="file" id="avatar" class="hidden" wire:model="avatar" accept=".png, .jpg, .jpeg, .gif, .webp, .svg">

                                    <div
                                        class="absolute inset-0 bg-white/20 backdrop-blur-[2px] opacity-0 -translate-y-2 scale-95 ease-out duration-300 group-hover:opacity-100 group-hover:translate-y-0 group-hover:scale-100 transition-all flex items-center justify-center space-x-2">
                                        <button type="button" @click="cropOpen = true; initCropper('avatar-preview', 'avatar')"
                                            class="p-2 bg-white/70 rounded-full hover-scale">
                                            <flux:icon name="adjustments-horizontal" class="h-6 w-6" />
                                        </button>
                                        <button @click="avatar.click()"
                                            class="p-2 bg-white/80 rounded-full hover-scale">
                                            <flux:icon.camera class="w-6 h-6" />
                                        </button>
                                    </div>
                                </div>

                                <h2 class="mt-4 text-xl font-semibold text-gray-800">{{ $full_name }}</h2>
                                <p class="text-gray-500">{{ $email }}</p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3 text-right">
                            <div>
                                <p class="text-sm text-gray-500">{{ __('lang_v1.member_since') }}</p>
                                <p class="font-medium text-gray-700">{{ Auth::guard('claimer')->user()->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('lang_v1.last_updated') }}</p>
                                <p class="font-medium text-gray-700">{{ Auth::guard('claimer')->user()->updated_at->format('M d, Y') }}</p>
                            </div>
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

                <div x-data="phoneInput" class="w-full md:w-2/3">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ __('lang_v1.profile_information') }}</h3>

                    <form wire:submit.prevent="save" class="space-y-6">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">{{__('lang_v1.enter_full_name')}}</label>
                            <input type="text" id="full_name" wire:model.defer="full_name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500">
                            @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('lang_v1.email_address') }}</label>
                            <input type="email" id="email" value="{{ $email }}" readonly
                                class="w-full px-4 py-2 border border-gray-300 rounded-full bg-gray-100 cursor-not-allowed">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('lang_v1.phone') }}</label>
                            <input x-ref="phoneInput" type="tel" id="phone" wire:model.defer="phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500">
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div x-data
                            x-init="
                            flatpickr($refs.dateInput, {
                                altInput: true,
                                locale: '{{ (app()->getLocale() === 'zh-CN') ? 'zh' : app()->getLocale() }}',
                                altFormat: 'F j, Y',
                                dateFormat: 'Y-m-d',
                                maxDate: new Date(new Date().getFullYear() - 5, 11, 31)
                            })">
                            <label for="dob" class="block text-sm font-medium text-gray-700 mb-1">{{ __('lang_v1.date_of_birth') }}</label>
                            <input x-ref="dateInput" placeholder="{{ $dob }}" type="text" id="dob" wire:model.defer="dob"
                                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500">
                            @error('dob') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">{{ __('lang_v1.current_location') }}</label>
                            <input type="text" id="location" wire:model.defer="location"
                                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500">
                            @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-4 flex justify-end space-x-3">
                            <button type="submit"
                                class="w-full px-6 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition flex items-center justify-center hover-scale">
                                <span wire:loading wire:target="save" class="flex items-center justify-center">
                                    <flux:icon name="loader-pinwheel" class="animate-spin -ml-1 mr-3 h-5 w-5 text-whit inline-block" />
                                    {{ __('lang_v1.processing') }}
                                </span>
                                <span wire:loading.remove>{{ __('lang_v1.save') }}</span>

                            </button>
                            <a wire:navigate href="{{ route('claimer-password') }}"
                                class="w-full px-6 py-2 bg-gray-200 text-black rounded-full flex items-center justify-center transition hover-scale">
                                {{ __('lang_v1.change_password') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
