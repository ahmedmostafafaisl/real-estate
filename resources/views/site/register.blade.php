<x-site-layout title="Register — Keystone">
    <div class="max-w-md mx-auto px-6 py-14">
        <h1 class="font-serif text-3xl mb-2">Create your account</h1>
        <p class="text-textmute mb-6 text-sm">Save favorites, request viewings, and message providers directly.</p>

        @if ($errors->any())<div class="bg-dangersoft text-kdanger text-sm rounded-md px-3 py-2 mb-4">{{ $errors->first() }}</div>@endif

        <form action="{{ route('register.store') }}" method="POST" class="bg-white border border-line rounded-xl p-6 flex flex-col gap-3.5">
            @csrf
            <input name="name" value="{{ old('name') }}" placeholder="Full name" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <input name="phone" value="{{ old('phone') }}" placeholder="Phone (optional)" class="border border-line rounded-md px-3 py-2.5 text-sm">
            <input name="password" type="password" placeholder="Password" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <input name="password_confirmation" type="password" placeholder="Confirm password" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <button class="bg-ink text-white rounded-md py-2.5 text-sm font-semibold">Create account</button>
        </form>

        <div class="text-center text-sm text-textmute mt-5">Already have an account? <a href="{{ route('login') }}" class="text-brass font-semibold">Log in</a></div>
        <div class="text-center text-sm text-textmute mt-2">Own a property business? <a href="{{ route('register.provider') }}" class="text-brass font-semibold">Register as a service provider</a></div>
    </div>
</x-site-layout>
