<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Service Providers') }}
        </h2>
    </x-slot>
    <div class="container flex">
        <livewire:add-provider-form/>
        <livewire:display-provider />

    </div>
</x-app-layout>