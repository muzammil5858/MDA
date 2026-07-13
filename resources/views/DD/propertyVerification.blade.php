<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        i {
            position: relative;
            font-size: 16px;
        }
        .detail {
            font-size: 18px;
        }
        i:hover {
            cursor: pointer;
        }
    </style>

    <!-- Main content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            <div class="w-full sm:w-2/3 md:w-1/2 lg:w-1/3">
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Search Property</h2>

                    @if(session('error'))
                        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{route('propertyVerify')}}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="search_input" class="block text-sm font-medium text-gray-700 mb-1">
                                Enter a Code No
                            </label>
                            <input
                                type="text"
                                id="search_input"
                                name="search_input"
                                required
                                placeholder="Enter aCode No"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                        </div>

                        <div>
                            <button
                                type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200"
                            >
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
