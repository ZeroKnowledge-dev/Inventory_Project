<script setup>
import { reactive } from 'vue';


const userName = reactive({
    name: ''
});

getName();

async function getName() {
    const response = await axios.get('/user-profile');
    let data = response.data.data;
    userName.name = data.firstName + ' ' + data.lastName;
}

</script>

<template>
    <!-- Main Content -->
    <main class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-purple-500">Welcome Back, {{ userName.name }}</h1>
                <p class="text-lg text-gray-500 mt-2">Here's an overview of your activity and details.</p>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
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
    </main>
</template>

<style scoped></style>
