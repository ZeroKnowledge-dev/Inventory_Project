<script setup>
</script>

<template>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Center Div -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="absolute bg-slate-400 top-0 left-0 w-full h-full z-0 overflow-hidden">
            <div
                class="absolute rounded-full blur-3xl animate-[moveSphere_20s_infinite_ease-in-out] w-[600px] h-[600px] bg-gradient-to-br from-pink-500 to-yellow-400 -top-72 -left-72 animate-delay-[-5s]">
            </div>
            <div
                class="absolute rounded-full blur-3xl animate-[moveSphere_20s_infinite_ease-in-out] w-[500px] h-[500px] bg-gradient-to-br from-indigo-500 to-cyan-500 -bottom-64 -right-64 animate-delay-[-2s]">
            </div>
            <div
                class="absolute rounded-full blur-3xl animate-[moveSphere_20s_infinite_ease-in-out] w-[400px] h-[400px] bg-gradient-to-br from-purple-700 to-pink-500 top-1/2 left-1/3 animate-delay-[-8s]">
            </div>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-5xl font-extrabold leading-tight mb-6 text-black">
                Welcome to Inventory Manager <span role="img" aria-label="rocket">🚀</span>
            </h1>
            <p class="text-lg text-black mb-8">
                Take control of your inventory with ease. Whether you're a small business or an enterprise, our system
                streamlines your product management.
            </p>

            <!-- Key Features Section -->
            <div class="mt-12 space-y-8 text-center text-black">
                <h2 class="text-3xl font-semibold text-black mb-6">
                    Why Choose Us?
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mt-8">
                    <!-- Feature 1 -->
                    <div class="p-6 bg-white bg-opacity-25 rounded-xl shadow-xl">
                        <h3 class="text-2xl font-semibold text-black">
                            Easy Tracking 📦
                        </h3>
                        <p class="mt-4 text-black">
                            Manage and track all your products with ease in one central dashboard.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-6 bg-white bg-opacity-25 rounded-xl shadow-xl">
                        <h3 class="text-2xl font-semibold text-black">
                            Real-Time Updates 📊
                        </h3>
                        <p class="mt-4 text-black">
                            Receive instant notifications on stock levels, sales trends, and more.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-6 bg-white bg-opacity-25 rounded-xl shadow-xl">
                        <h3 class="text-2xl font-semibold text-black">
                            Order Management 🛒
                        </h3>
                        <p class="mt-4 text-black">
                            Simplify order management and keep everything organized for quick access.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Call to Action (Get Started Button) -->
            <div class="mt-16">
                <a href="/login"
                    class="inline-block px-8 py-3 text-xl font-semibold bg-black text-white rounded-full hover:bg-gray-800 transition ease-in-out duration-300 transform hover:scale-105">
                    Log In
                </a>
                <a href="/registration"
                    class="inline-block px-8 py-3 text-xl font-semibold bg-black text-white rounded-full hover:bg-gray-800 transition ease-in-out duration-300 transform hover:scale-105 ml-6">
                    Sign Up
                </a>
            </div>

            <!-- Footer (Small section) -->
            <footer class="mt-12 text-sm text-black">
                <p>&copy; 2024 Inventory Manager. All Rights Reserved. ⚙️</p>
            </footer>
        </div>
    </div>
</template>

<style scoped>
/* Custom styles if needed for animation and overall design */
</style>
