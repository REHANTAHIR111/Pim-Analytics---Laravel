@if (session('message') || $errors->any())
    <div
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 50); setTimeout(() => show = false, 3500);"
        x-show="show"
        x-transition:enter="transform transition ease-out duration-500"
        x-transition:enter-start="translate-x-full opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transform transition ease-in duration-500"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-full opacity-0"
        class="fixed top-4 right-8 z-[999999] w-80 p-5 text-white rounded shadow-lg justify-between flex items-start gap-3 {{ $errors->any() ? 'bg-danger dark:bg-danger-dark-light' : 'bg-success dark:bg-success-dark-light' }}"
        style="display: none;"
    >
        <div class="w-full">
            @if (session('message'))
                <div>{{ session('message') }}</div>
            @endif

            @if ($errors->any())
                <div class="text-sm text-white/90">
                    {{ implode(', ', $errors->all()) }}
                </div>
            @endif
        </div>
        <button @click="show = false" class="hover:opacity-80">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
@endif

