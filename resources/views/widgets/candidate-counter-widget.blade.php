<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <x-filament::icon-button
                icon="heroicon-m-users"
                size="xl"
            />
            <div class="flex-1">
                <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Current Number of Applications: {{ $candidatesCount }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Total Number of Candidates Applied
                </p>
            </div>
            <form action="{{ route('download-csv') }}" method="post">
                @csrf
                <input type="hidden" name="action" value="download_csv">
                <x-filament::button
                    type="submit"
                    color="gray"
                    icon="heroicon-m-plus"
                    icon-alias="panels::widgets.account.logout-button"
                    labeled-from="sm"
                >
                    Download CSV
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
