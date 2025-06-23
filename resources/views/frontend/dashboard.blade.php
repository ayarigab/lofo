<div>
    @auth('claimer')
        <h1 class="text-2xl font-bold">Welcome, {{ auth()->guard('claimer')->user()->full_name ?? 'Guest' }}</h1>
        <form method="POST" action="{{ route('claimer-logout') }}">
            @csrf
            <button type="submit" class="mt-4 px-4 py-2 bg-red-600 text-white rounded">Logout</button>
        </form>
    @else
        <p>You need to <a href="{{ route('claimer-login') }}" class="text-blue-600">login</a> to access this page.</p>
    @endauth
</div>
