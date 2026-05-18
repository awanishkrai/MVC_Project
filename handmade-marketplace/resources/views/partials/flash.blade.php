@if (session('success') || session('error') || session('status') || $errors->any())
    <div class="cn-container space-y-2 pt-4">
        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif
        @if (session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif
        @if (session('status'))
            <x-alert type="info" :message="session('status')" />
        @endif
        @if ($errors->any())
            <x-alert type="error">
                <ul class="list-inside list-disc space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif
    </div>
@endif
