@php
    $user = filament()->auth()->user();
@endphp


        <div class="flex items-center gap-x-3">
            <!-- <x-filament-panels::avatar.user size="lg" :user="$user" /> -->

            <div class="flex-1">
                <!-- <h2
                    class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
            Welcome
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ filament()->getUserName($user) }}
                </p> -->
            </div>

            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="my-auto"
            >
                @csrf

                <x-filament::button
                    color="gray"
                    icon="heroicon-m-arrow-left-on-rectangle"
                    icon-alias="panels::widgets.account.logout-button"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
                </x-filament::button>
            </form>
        </div>

