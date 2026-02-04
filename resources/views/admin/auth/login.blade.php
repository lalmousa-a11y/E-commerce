<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - E-Commerce Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-3 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 sm:p-10 border border-gray-100">
            <!-- Header -->
            <div class="text-center mb-8 sm:mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-5 shadow-lg">
                    <span class="text-4xl">⚙️</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">Admin Panel</h1>
                <p class="text-gray-600 text-base sm:text-lg">Sign in to manage your store</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 sm:p-5 bg-red-50 border-r-4 border-red-500 rounded-lg">
                    <p class="text-red-700 font-semibold text-base">{{ $errors->first() }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 sm:p-5 bg-red-50 border-r-4 border-red-500 rounded-lg">
                    <p class="text-red-700 text-base">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5 sm:space-y-6">
                @csrf

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm sm:text-base font-semibold text-gray-800">
                        Email Address
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base bg-gray-50 hover:bg-white"
                        placeholder="admin@example.com"
                    >
                    @error('email')
                        <p class="text-red-600 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm sm:text-base font-semibold text-gray-800">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-4 sm:px-5 py-3 sm:py-4 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-base bg-gray-50 hover:bg-white"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="text-red-600 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer"
                        >
                        <label for="remember" class="ml-3 block text-sm text-gray-700 cursor-pointer">
                            Remember me
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 sm:py-4 px-4 rounded-lg transition duration-300 text-base sm:text-lg shadow-lg hover:shadow-xl transform hover:scale-105"
                >
                    Sign In
                </button>
            </form>

            <!-- Footer -->
            <p class="text-center text-gray-600 text-sm sm:text-base mt-8 sm:mt-10 pt-6 border-t border-gray-200">
                Only administrators can access this panel
            </p>
        </div>
    </div>
</body>
</html>
