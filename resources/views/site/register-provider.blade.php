<x-site-layout title="Register your business — Keystone">
    <div class="max-w-lg mx-auto px-6 py-14">
        <h1 class="font-serif text-3xl mb-2">Register your business</h1>
        <p class="text-textmute mb-6 text-sm">List properties, manage inquiries, and track subscriptions from a dedicated dashboard. Your account is reviewed before your listings go live.</p>

        @if ($errors->any())<div class="bg-dangersoft text-kdanger text-sm rounded-md px-3 py-2 mb-4">{{ $errors->first() }}</div>@endif

        <form action="{{ route('register.provider.store') }}" method="POST" class="bg-white border border-line rounded-xl p-6 flex flex-col gap-3.5">
            @csrf
            <div class="grid grid-cols-2 gap-3.5">
                <input name="name" value="{{ old('name') }}" placeholder="Your full name" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                <input name="phone" value="{{ old('phone') }}" placeholder="Phone" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            </div>
            <input name="email" type="email" value="{{ old('email') }}" placeholder="Email" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <div class="grid grid-cols-2 gap-3.5">
                <input name="password" type="password" placeholder="Password" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                <input name="password_confirmation" type="password" placeholder="Confirm password" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            </div>
            <hr class="border-line my-1">
            <input name="office_name" value="{{ old('office_name') }}" placeholder="Office / business name" required class="border border-line rounded-md px-3 py-2.5 text-sm">
            <div class="grid grid-cols-2 gap-3.5">
                <select name="provider_type" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                    <option value="">Business type</option>
                    @foreach (['agency','broker','owner','developer'] as $t)<option value="{{ $t }}">{{ ucfirst($t) }}</option>@endforeach
                </select>
                <select name="city_id" required class="border border-line rounded-md px-3 py-2.5 text-sm">
                    <option value="">City</option>
                    @foreach ($cities as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                </select>
            </div>
            <input name="commercial_register_no" value="{{ old('commercial_register_no') }}" placeholder="Commercial register no. (optional)" class="border border-line rounded-md px-3 py-2.5 text-sm">
            <button class="bg-ink text-white rounded-md py-2.5 text-sm font-semibold">Submit application</button>
        </form>
    </div>
</x-site-layout>
