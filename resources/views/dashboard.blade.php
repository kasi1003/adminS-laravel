<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('grave.admin') }}" class="card-link">
                        <div class="card m-3">
                            <div class="card-body mx-auto" style="height: 10rem; display: flex; align-items: center;">
                                <h5 class="card-title">Manage Graveyards</h5>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-6">
                    <a href="{{ route('grave.records') }}" class="card-link">

                        <div class="card m-3">
                            <div class="card-body mx-auto" style="height: 10rem; display:flex; align-items:center;">
                                <h5 class="card-title">Manage Burial Records</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-12">
                    <div class="card m-3">
                        <div class="card-body mx-auto" style="height: 10rem ; display:flex; align-items:center;">
                            <h5 class="card-title">Quotations</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }
    </style>

</x-app-layout>
