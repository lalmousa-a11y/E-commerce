<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <div class="flex h-screen">

        <!-- Sidebar -->
        <div class="fixed left-0 top-0 bottom-0 z-40 w-64">
            @include('components.admin.sidebar')
        </div>

        <!-- Main Content -->
        <div class="ml-64 flex-1 flex flex-col min-h-screen">

            <!-- Header -->
            @include('components.admin.header')

            <!-- Alerts -->
            <div class="px-4 sm:px-6 lg:px-8 py-4 bg-white border-b border-gray-200">
                @include('components.alert')
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 bg-gray-50">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('admin.footer')

        </div>

    </div>

</body>
</html>
