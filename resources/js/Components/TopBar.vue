<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Sidebar from './Sidebar.vue';

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
            <Link href="/">Dashboard</Link>
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
                    class="absolute right-0 py-4 w-48 bg-cyan-300/50 backdrop-blur-xl border-r border-cyan-300/10 text-black rounded-lg shadow-lg z-50">
                    <Sidebar />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
