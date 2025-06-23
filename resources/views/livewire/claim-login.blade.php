<div class="relative flex flex-wrap items-center w-full h-full px-8">
    <div class="relative w-full max-w-sm mx-auto lg:mb-0">
        <div class="relative">
            <div class="flex flex-col mb-6 space-y-2">
                <h1 class="mb-4 text-3xl font-bold text-sky-900 sm:text-4xl">Login now</h1>
                <p class="text-sm text-neutral-500">Enter your email and password below to login to your
                    account dashboard.
                </p>
            </div>
            <form wire:submit.prevent="login" class="space-y-4 px-8 py-6 bg-white rounded-3xl shadow-xl text-start">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input wire:model="email" type="email" id="email" required placeholder="Enter email address"
                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Enter password</label>
                    <input wire:model="password" type="password" id="password" required
                        placeholder="Enter your password"
                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label>
                        <input wire:model="remember" type="checkbox"> Remember me
                    </label>
                </div>
                <button type="submit"
                    class="hover-scale inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-full bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">
                    Sign in
                </button>
                <div class="relative py-6">
                    <div class="absolute inset-0 flex items-center"><span class="w-full border-t"></span></div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="px-2 bg-white text-neutral-500">Don't have an account?</span>
                    </div>
                </div>
                <a class="hover-scale inline-flex items-center justify-center w-full h-10 px-4 py-2 text-sm font-medium border rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 disabled:opacity-50 disabled:pointer-events-none border-input hover:bg-neutral-100"
                    wire:navigate href="{{ route('claimer-register') }}">
                    Sign up now
                </a>
                <p class="px-8 mt-2 text-xs text-center text-neutral-500">By continuing, you agree to
                    our <a class="underline underline-offset-4 hover:text-blue-500" href="/terms">Terms & conditions</a>
                    and
                    <a class="underline underline-offset-4 hover:text-blue-500" href="/privacy">Privacy Policies</a>.
                </p>
            </form>
        </div>
    </div>
</div>
