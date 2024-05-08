<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <button onclick="toggleDarkMode()" class="px-4 py-2 bg-gray-800 text-white dark:bg-gray-700 dark:text-gray-200 rounded-md">Dark Mode</button>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('addGraveyards') }}" class="card-link">
                        <div class="card m-3 bg-gray-200 dark:bg-gray-800">
                            <div class="card-body mx-auto" style="height: 10rem; display: flex; align-items: center;">
                                <h5 class="card-title text-blue-500 text-blue">Manage Graveyards</h5>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('burialRecords') }}" class="card-link">
                        <div class="card m-3 bg-gray-200 dark:bg-gray-800">
                            <div class="card-body mx-auto" style="height: 10rem; display:flex; align-items:center;">
                                <h5 class="card-title text-blue-500 text-blue">Manage Burial Records</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('serviceProviders') }}" class="card-link">
                        <div class="card m-3 bg-gray-200 dark:bg-gray-800">
                            <div class="card-body mx-auto" style="height: 10rem ; display:flex; align-items:center;">
                                <h5 class="card-title text-blue-500 text-blue">Service Providers</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('quotations') }}" class="card-link">
                        <div class="card m-3 bg-gray-200 dark:bg-gray-800">
                            <div class="card-body mx-auto" style="height: 10rem ; display:flex; align-items:center;">
                                <h5 class="card-title text-blue-500 text-blue">Quotations</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Your styles for both light and dark mode */
        .card {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        /* Dark mode styles */
        .dark-mode .text-gray-800,
        .dark-mode .text-gray-900 {
            color: #f7fafc; /* Change to your desired dark mode text color */
        }

        .dark-mode .text-gray-200,
        .dark-mode .text-gray-700 {
            color: #4b5563; /* Change to your desired dark mode text color */
        }

        .dark-mode .bg-gray-200,
        .dark-mode .bg-gray-300 {
            background-color: #1a202c; /* Change to your desired dark mode background color */
        }

        .dark-mode .bg-gray-800 {
            background-color: #121212; /* Change to a very dark color */
        }

        /* Add more dark mode styles as needed */
        
        /* Background color */
        body {
            background-color: #f3f4f6; /* Default background color in light mode */
        }

        .dark-mode body {
            background-color: #1a202c; /* Dark mode background color */
        }

        /* Main content */
        main {
            padding: 2rem; /* Adjust padding as needed */
            border-radius: 0.5rem; /* Add rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow */
            background-color: #ffffff; /* Default background color in light mode */
        }

        .dark-mode main {
            background-color: #1a202c; /* Dark mode background color */
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

        /* Dark mode button line */
        .dark-mode button {
            background-color: #121212; /* Dark mode background color for button */
            color: #ffffff; /* Dark mode text color for button */
        }
        
        /* Form styles */
        input[type="text"], 
        input[type="email"], 
        input[type="password"],
        textarea,
        select {
            padding: 0.5rem;
            border: 1px solid #d1d5db; /* Default border color */
            border-radius: 0.25rem;
            background-color: #f3f4f6; /* Default background color in light mode */
            color: #000000; /* Default text color */
        }
        
        .dark-mode input[type="text"], 
        .dark-mode input[type="email"], 
        .dark-mode input[type="password"],
        .dark-mode textarea,
        .dark-mode select {
            background-color: #374151; /* Dark mode background color */
            color: #ffffff; /* Dark mode text color */
        }
        
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        
        table th,
        table td {
            padding: 0.5rem;
            border: 1px solid #e2e8f0; /* Default border color */
        }
        
        table th {
            background-color: #f3f4f6; /* Default background color in light mode */
            color: #000000; /* Default text color */
        }
        
        .dark-mode table th {
            background-color: #374151; /* Dark mode background color */
            color: #ffffff; /* Dark mode text color */
        }
    </style>

    <script>
        // Function to toggle dark mode
        function toggleDarkMode() {
            const body = document.body;
            const isDarkMode = body.classList.contains('dark-mode');

            // Toggle between dark and light mode
            if (isDarkMode) {
                // Switch to light mode
                body.classList.remove('dark-mode');
            } else {
                // Switch to dark mode
                body.classList.add('dark-mode');
            }
        }
    </script>
</x-app-layout>
