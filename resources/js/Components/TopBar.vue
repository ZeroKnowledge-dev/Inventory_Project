<script setup>
import { ref } from 'vue';

const showDropdown = ref(false);

function toggleDropdown() {
    showDropdown.value = !showDropdown.value;
}

</script>

<template>
    <!-- Top Bar -->
    <div class="bg-purple-500 z-20 text-white p-4 flex justify-between items-center shadow-lg">
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
                    class="absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-lg z-50">
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
</template>

<style scoped></style>
