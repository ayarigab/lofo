<div class="flex flex-col gap-6 bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-lg">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model.live="name"
            :label="__('Name')"
            type="text"
            icon="circle-user-round"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Enter your full name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model.live="email"
            :label="__('Email address')"
            type="email"
            icon="mail"
            required
            autocomplete="email"
            placeholder="Enter email address"
        />

        <!-- Password -->
        <flux:input
            wire:model.live="password"
            :label="__('Enter new password')"
            type="password"
            icon="lock"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model.live="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            icon="lock"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm your password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" color="green" icon="user-round-plus" type="submit" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
