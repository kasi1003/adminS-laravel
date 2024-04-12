<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Burial Records') }}
        </h2>
    </x-slot>
    <div class="container flex">
        <livewire:burial-records />
        <livewire:show-burial-records />


    </div>
</x-app-layout>