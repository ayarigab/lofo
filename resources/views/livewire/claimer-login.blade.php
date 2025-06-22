<div>
    <form wire:submit.prevent="login">
        <div>
            <label for="email">Email</label>
            <input wire:model="email" type="email" id="email" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input wire:model="password" type="password" id="password" required>
        </div>

        <div>
            <label>
                <input wire:model="remember" type="checkbox"> Remember me
            </label>
        </div>

        <button type="submit">Login</button>
    </form>
</div>
