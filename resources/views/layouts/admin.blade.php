<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - management control panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        @include('admin.sidebar')

        <div class="flex-1 flex flex-col">
            @include('components.admin.header')

            <div class="px-6 py-4">
                @include('components.alert')
            </div>

            <main class="flex-1 px-6 py-8 overflow-auto">
                @yield('content')
            </main>

            @include('view.admin.footer')
        </div>
    </div>
</body>
</html>