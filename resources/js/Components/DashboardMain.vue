<script setup>
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';

const summary = ref({});
const loading = ref(true);
const userName = reactive({ name: '' });

const fetchSummary = async () => {
    try {
        const response = await axios.get('/summary');
        summary.value = response.data;
        console.log(summary.value);

    } catch (error) {
        console.error('Error fetching summary:', error);
    } finally {
        loading.value = false;
    }
};

const getName = async () => {
    const response = await axios.get('/user-profile');
    let data = response.data.data;
    userName.name = `${data.firstName} ${data.lastName}`;
};

onMounted(() => {
    fetchSummary();
    getName();
});
</script>

<template>
    <!-- Main Content -->
    <main class="flex-1 p-8 bg-transparent backdrop-blur-lg">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-purple-500 drop-shadow-lg">
                    Welcome Back, {{ userName.name }}
                </h1>
                <p class="text-lg text-gray-500 mt-2">Here's an overview of your activity and details.</p>
            </div>

            <!-- Stats Section -->
            <div
                class="p-8 max-w-4xl mx-auto bg-white/30 rounded-3xl shadow-2xl backdrop-blur-lg border border-white/10">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center mb-6">
                    <i class="fas fa-chart-line mr-3 text-purple-500"></i> Summary
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <template v-for="(value, key) in summary" :key="key">
                        <template v-if="key !== 'recentActivity'">
                            <div
                                class="flex items-center p-5 bg-white/20 rounded-xl shadow-md border border-white/10 backdrop-blur-md">
                                <i v-if="key === 'product'" class="fas fa-box text-3xl text-teal-500 mr-4"></i>
                                <i v-else-if="key === 'category'" class="fas fa-tags text-3xl text-indigo-500 mr-4"></i>
                                <i v-else-if="key === 'customer'" class="fas fa-user text-3xl text-pink-500 mr-4"></i>
                                <i v-else-if="key === 'invoice'"
                                    class="fas fa-file-invoice text-3xl text-yellow-500 mr-4"></i>
                                <i v-else-if="key === 'total'"
                                    class="fas fa-dollar-sign text-3xl text-green-500 mr-4"></i>
                                <i v-else-if="key === 'vat'"
                                    class="fas fa-percentage text-3xl text-purple-500 mr-4"></i>
                                <i v-else-if="key === 'payable'"
                                    class="fas fa-money-bill-wave text-3xl text-red-500 mr-4"></i>

                                <div>
                                    <p class="text-gray-500 capitalize font-semibold">{{ key }}</p>
                                    <p class="text-2xl font-bold text-gray-800">{{ value }}</p>
                                </div>
                            </div>
                        </template>
                    </template>

                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="mt-12">
                <h2 class="text-3xl font-extrabold text-purple-500 mb-6">Recent Activity</h2>
                <div class="bg-white/30 p-8 rounded-3xl shadow-lg border border-white/10 backdrop-blur-lg">
                    <ul class="space-y-5">
                        <li class="flex items-center text-gray-600">
                            <i class="fa fa-check-circle text-green-500 text-xl mr-4"></i>
                            Add a New <span class="font-bold text-green-600"> &nbsp;Customer&nbsp; </span> "{{
                                summary.recentActivity?.customer || 'N/A' }}"
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fa fa-check-circle text-green-500 text-xl mr-4"></i>
                            Add a New <span class="font-bold text-green-600"> &nbsp;Category&nbsp; </span> "{{
                                summary.recentActivity?.category || 'N/A' }}"
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fa fa-check-circle text-green-500 text-xl mr-4"></i>
                            Add a New <span class=" font-bold text-green-600"> &nbsp;Product&nbsp; </span> "{{
                                summary.recentActivity?.product || 'N/A' }}"
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</template>

<style scoped></style>
