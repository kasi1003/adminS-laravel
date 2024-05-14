<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Burial Records') }}
            </h2>
            <button onclick="toggleDarkMode()" class="px-4 py-2 bg-gray-800 text-white dark:bg-gray-700 dark:text-gray-200 rounded-md">Dark Mode</button>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Burial Records Table -->
            <div class="mb-4 light-mode:bg-white dark-mode:bg-gray-800 light-mode:shadow-md dark-mode:shadow-md">
                <h3 class="text-lg font-semibold mb-2 light-mode:text-gray-800 dark-mode:text-gray-200">Burial Records</h3>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full light-mode:text-gray-700 dark-mode:text-gray-300">
                        <thead class="bg-gray-200 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Age</th>
                                <th class="px-4 py-2">Date of Death</th>
                                <th class="px-4 py-2">Date of Burial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Burial records data will go here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form to Add Burial Record -->
            <div class="mb-4 light-mode:bg-white dark-mode:bg-gray-800 light-mode:shadow-md dark-mode:shadow-md">
                <h3 class="text-lg font-semibold mb-2 light-mode:text-gray-800 dark-mode:text-gray-200">Add Burial Record</h3>
                <form>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 mb-2">Name</label>
                            <input id="name" type="text" class="form-input w-full">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6">
                            <label for="age" class="block text-gray-700 dark:text-gray-300 mb-2">Age</label>
                            <input id="age" type="number" class="form-input w-full">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6">
                            <label for="date_of_death" class="block text-gray-700 dark:text-gray-300 mb-2">Date of Death</label>
                            <input id="date_of_death" type="date" class="form-input w-full">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6">
                            <label for="date_of_burial" class="block text-gray-700 dark:text-gray-300 mb-2">Date of Burial</label>
                            <input id="date_of_burial" type="date" class="form-input w-full">
                        </div>
                        <div class="w-full px-3 mb-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Record</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Your existing styles for both light and dark mode */

        /* Additional styles for burial records */
        .table-auto {
            border-collapse: collapse;
        }

        .table-auto th,
        .table-auto td {
            border: 1px solid #e2e8f0; /* Default border color */
            padding: 0.75rem;
            text-align: left;
        }

        /* Form styles */
        .form-input {
            padding: 0.5rem;
            border: 1px solid #d1d5db; /* Default border color */
            border-radius: 0.25rem;
            background-color: #f3f4f6; /* Default background color in light mode */
            color: #000000; /* Default text color */
        }

        /* Dark mode form styles */
        .dark-mode .form-input {
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
