<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="min-h-screen flex items-center justify-center bg-blue-50">
    <div class="flex flex-col md:flex-row bg-white shadow-2xl rounded-2xl overflow-hidden max-w-4xl w-full">
        <!-- LEFT FORM -->
        <div class="md:flex-1 p-10 md:p-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">ADMIN LOGIN</h2>
            <p class="text-gray-500 mb-8">Please enter your credentials to access the dashboard.</p>

            <!-- Form POST ke route /login -->
            <form action="/login" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2  text-lg">
                        <i class="bi bi-envelope-fill"></i>
                    </span>
                    <input type="email" name="email" placeholder="Email"
                        class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition duration-300"
                        required>
                </div>

                <!-- Password -->
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2  text-lg">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition duration-300"
                        required>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                       text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-2xl 
                       transform hover:-translate-y-1 transition-all duration-300 ease-in-out">
                    Login
                </button>

            </form>
        </div>

        <!-- RIGHT IMAGE -->
        <div class="md:flex-1 relative text-white flex flex-col justify-center items-center p-10 md:p-16
        bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 overflow-hidden">

            <!-- Decorative blobs (optional, for corak modern) -->
            <span
                class="absolute top-0 left-0 w-72 h-72 bg-indigo-500 rounded-full opacity-30 -translate-x-1/2 -translate-y-1/2"></span>
            <span
                class="absolute bottom-0 right-0 w-80 h-80 bg-blue-500 rounded-full opacity-20 translate-x-1/3 translate-y-1/3"></span>

            <!-- Content -->
            <h3 class="text-2xl md:text-3xl font-semibold mb-2 z-10">Welcome Back Admin!</h3>
            <p class="mb-6 text-center z-10">Manage your dashboard securely and efficiently.</p>
        </div>

    </div>
</body>

</html>