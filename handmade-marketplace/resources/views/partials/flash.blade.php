@if (session('success') || session('error') || session('status'))
    <div class="mx-auto max-w-5xl px-4 pt-4 sm:px-6">
        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @if (session('status'))
            <div class="rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                {{ session('status') }}
            </div>
        @endif
    </div>
@endif
