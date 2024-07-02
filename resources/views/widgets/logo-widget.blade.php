@php
    $user = filament()->auth()->user();
@endphp

        <div class="flex items-center gap-x-3">
    <x-filament-panels::avatar.user size="lg" :user="$user" />
            <div class="flex-1">
                <h2
                    class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
            Welcome
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ filament()->getUserName($user) }}
                </p>
            </div>

         
        </div>
