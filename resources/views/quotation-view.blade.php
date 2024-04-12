<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quotations') }}
        </h2>
    </x-slot>
    <div class="container flex">
        <livewire:quotations/>

    </div>
</x-app-layout>