<script setup>
import { ref } from 'vue';

const showDropdown = ref(false);

function toggleDropdown() {
    showDropdown.value = !showDropdown.value;
}



</script>

<template>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <div class="min-h-screen flex flex-col">

        <!-- Top Bar -->
        <div class="bg-purple-500 text-white p-4 flex justify-between items-center shadow-lg">
            <!-- Left Side: Logo or App Name -->
            <div class="text-2xl font-extrabold">
                <a href="/dashboard">Dashboard</a>
            </div>

            <!-- Right Side: User Profile and Actions -->
            <div class="flex items-center space-x-4">
                <!-- Notifications icon (optional) -->
                <i class="fa fa-bell text-white text-xl cursor-pointer hover:text-yellow-300 transition"></i>

                <!-- Profile Picture and Dropdown Menu -->
                <div class="relative">
                    <img src="https://uxwing.com/wp-content/themes/uxwing/download/peoples-avatars/corporate-user-icon.png"
                        alt="User Profile" class="w-10 h-10 rounded-full object-cover cursor-pointer"
                        @click="toggleDropdown" />
                    <!-- Dropdown Menu -->
                    <div v-if="showDropdown"
                        class="absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-lg z-10">
                        <ul class="py-2">
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                <a href="/profile"><i class="fa fa-user-circle mr-4"></i> Profile</a>
                            </li>
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                <a href="#"><i class="fa fa-cogs mr-4"></i> Settings</a>
                            </li>
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                <a href="/logout"><i class="fa fa-sign-out-alt mr-4"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-1">

            <!-- Sidebar -->
            <div class="w-64 bg-cyan-300/50 backdrop-blur-xl border-r border-cyan-300/10 p-4 shadow-xl">
                <ul class="space-y-6 ml-4">
                    <li>
                        <a href="/profile"
                            class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                            <i class="fa fa-user-circle mr-4"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                            <i class="fa fa-cogs mr-4"></i> Settings
                        </a>
                    </li>
                    <li>
                        <a href="/logout"
                            class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                            <i class="fa fa-sign-out-alt mr-4"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="flex-1 relative p-8 bg-white overflow-hidden">
                <!-- Background -->
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

                <!-- Foreground Content -->
                <div class="relative z-10">
                    <div class="text-center mb-12">
                        <h1 class="text-4xl font-extrabold text-purple-500">Welcome Back, User</h1>
                        <p class="text-lg text-gray-500">Here's an overview of your activity and details.</p>
                    </div>

                    <!-- Stats Section -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-gradient-to-br from-pink-400 to-yellow-500 p-6 rounded-lg shadow-xl">
                            <h3 class="text-xl font-bold text-white">Total Sales</h3>
                            <p class="text-white text-2xl mt-2">$5,340</p>
                        </div>
                        <!-- Card 2 -->
                        <div class="bg-gradient-to-br from-blue-400 to-indigo-500 p-6 rounded-lg shadow-xl">
                            <h3 class="text-xl font-bold text-white">Active Users</h3>
                            <p class="text-white text-2xl mt-2">1,250</p>
                        </div>
                        <!-- Card 3 -->
                        <div class="bg-gradient-to-br from-green-400 to-teal-500 p-6 rounded-lg shadow-xl">
                            <h3 class="text-xl font-bold text-white">New Sign-Ups</h3>
                            <p class="text-white text-2xl mt-2">340</p>
                        </div>
                    </div>

                    <!-- Recent Activity Section -->
                    <div class="mt-12">
                        <h2 class="text-2xl font-extrabold text-purple-500 mb-4">Recent Activity</h2>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-xl">
                            <ul class="space-y-4">
                                <li class="flex items-center text-gray-600">
                                    <i class="fa fa-check-circle mr-4 text-green-500"></i> Completed task "Project A"
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fa fa-times-circle mr-4 text-red-500"></i> Task "Meeting Notes" was
                                    overdue
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fa fa-comment-alt mr-4 text-blue-500"></i> New comment on "Task 42"
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fa fa-user-plus mr-4 text-teal-500"></i> New user signed up
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
/* Ensure grid layout adjusts well on smaller screens */
@media (max-width: 640px) {
    .grid {
        grid-template-columns: 1fr;
    }
}
</style>
