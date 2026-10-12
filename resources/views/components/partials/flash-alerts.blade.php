<div class="space-y-4">
    @if (session('success'))
        <div class="rounded-2xl border border-[#9edbd5] bg-[#e6f7f5] px-4 py-3 text-sm text-[#005454]">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-2xl border border-[#f5a8a8] bg-[#fff0f0] px-4 py-3 text-sm text-[#ba1a1a]">
            {{ session('error') }}
        </div>
    @endif
</div>
