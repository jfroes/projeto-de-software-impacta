<style>
    @keyframes flash-alert-fade {
        0% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-0.5rem); }
    }
</style>

<div class="mt-5 space-y-4">
    @if (session('success'))
        <div class="rounded-2xl border border-[#9edbd5] bg-[#e6f7f5] px-4 py-3 text-sm text-[#005454]" style="animation: flash-alert-fade 500ms ease 2s forwards;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-2xl border border-[#f5a8a8] bg-[#fff0f0] px-4 py-3 text-sm text-[#ba1a1a]" style="animation: flash-alert-fade 500ms ease 2s forwards;">
            {{ session('error') }}
        </div>
    @endif
</div>
