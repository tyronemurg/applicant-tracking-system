<style>
    :is(.dark .dark\:bg-gray-950) {
    --tw-bg-opacity: 1;
    /* background-color: rgba(var(--gray-950), var(--tw-bg-opacity)); */
    background: radial-gradient(circle, #3b82f6 31%, #021878 77%)!important;
}
</style>
<x-slot name="subheading">
    {{ __('filament-panels::pages/auth/login.actions.register.before') }}
    <x-filament::link size="sm" :href="filament()->getPanel('candidate')->getLoginUrl()">
        sign in as candidate portal user
    </x-filament::link>
</x-slot>


