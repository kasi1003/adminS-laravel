<!-- Full Code -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Light/Dark Mode Toggle Button -->
            <div class="flex justify-end mb-4">
                <button id="mode-toggle" class="px-3 py-1 rounded-md bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                    Toggle Mode
                </button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('addGraveyards') }}" class="card-link">
                        <div class="card m-3">
                            <div class="card-body mx-auto">
                                <h5 class="card-title">Manage Graveyards</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('burialRecords') }}" class="card-link">
                        <div class="card m-3">
                            <div class="card-body mx-auto">
                                <h5 class="card-title">Manage Burial Records</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('serviceProviders') }}" class="card-link">
                        <div class="card m-3">
                            <div class="card-body mx-auto">
                                <h5 class="card-title">Service Providers</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('quotations') }}" class="card-link">
                        <div class="card m-3">
                            <div class="card-body mx-auto">
                                <h5 class="card-title">Quotations</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        /* Your existing styles */

        /* Dark mode styles */
        .dark-mode .text-gray-800,
        .dark-mode .text-gray-900 {
            color: #f7fafc; /* Change to your desired dark mode text color */
        }

        .dark-mode .bg-gray-200,
        .dark-mode .bg-gray-300 {
            background-color: #1a202c; /* Change to your desired dark mode background color */
        }

        .dark-mode .bg-gray-800 {
            background-color: #121212; /* Change to a very dark color */
        }

        /* Dark mode button line */
        .dark-mode button {
            background-color: #121212; /* Dark mode background color for button */
            color: #ffffff; /* Dark mode text color for button */
        }

        /* Card text */
        .card-title {
            color: #000000; /* Default text color */
        }

        .dark-mode .card-title {
            color: #ffffff; /* Dark mode text color */
        }

        /* Card background */
        .card {
            background-color: #ffffff; /* Default background color in light mode */
        }

        .dark-mode .card {
            background-color: #1a202c; /* Dark mode background color */
        }
    </style>

    <!-- JavaScript -->
    <script>
        const toggleButton = document.getElementById('mode-toggle');
        const body = document.body;

        toggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
        });
    </script>
</x-app-layout>
