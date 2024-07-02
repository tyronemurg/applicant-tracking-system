<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3">
        <x-filament::icon-button
    icon="heroicon-m-archive-box"
    size="xl"
/>
            <div class="flex-1">
                <h2
                    class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                Available Jobs: {{ $jobOpeningsCount }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Total Number of Open Roles
                </p>
               
            </div>
            <x-filament::button
                    color="gray"
                    icon="heroicon-m-plus"
                    icon-alias="panels::widgets.account.logout-button"
                    labeled-from="sm"
                    tag="a"
                    href="/job-openings"
                    
                >
                    View Openings
                </x-filament::button>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
