<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign in — Keystone</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>body{font-family:Inter,sans-serif}</style>
</head>
<body class="bg-[#EEF1EF] min-h-screen flex items-center justify-center">
<div class="w-[380px] bg-white border border-[#DDE2DF] rounded-xl p-8">
    <div class="flex items-center gap-2.5 mb-6">
        <svg width="26" height="26" viewBox="0 0 40 40" fill="none">
            <path d="M6 34V20C6 11.16 12.16 5 20 5C27.84 5 34 11.16 34 20V34" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round" fill="none"/>
            <path d="M20 5V15" stroke="#B8862E" stroke-width="4.2" stroke-linecap="round"/>
        </svg>
        <span style="font-family: Fraunces, serif" class="text-lg">Keystone</span>
    </div>

    @if ($errors->any())
        <div class="bg-[#F5DEE0] text-[#B23A48] text-sm rounded-md px-3 py-2 mb-4">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.store') }}" method="POST" class="flex flex-col gap-3.5">
        @csrf
        <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-[#5B6472]">Email</span>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus class="border border-[#DDE2DF] rounded-md px-3 py-2 text-sm"></label>
        <label class="flex flex-col gap-1.5"><span class="text-xs font-semibold text-[#5B6472]">Password</span>
            <input type="password" name="password" required class="border border-[#DDE2DF] rounded-md px-3 py-2 text-sm"></label>
        <label class="flex items-center gap-2 text-xs text-[#5B6472]"><input type="checkbox" name="remember"> Remember me</label>
        <button class="bg-[#161B22] text-white rounded-md py-2.5 text-sm font-semibold mt-1">Sign in</button>
    </form>
</div>
</body>
</html>
