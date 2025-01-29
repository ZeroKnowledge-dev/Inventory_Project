<script setup>
import { ref } from 'vue';

const fromDate = ref('');
const toDate = ref('');

function SalesReport() {
    if (fromDate.value === '' || toDate.value === '') {
        alert("Date Range Required!");
    } else {
        window.location.href = '/sales-report/' + fromDate.value + '/' + toDate.value;
    }
}


</script>

<template>
    <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10 flex justify-center items-center">
        <div
            class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-purple-500">Make a New Report</h1>
            </div>
            <form class="space-y-4">
                <div>
                    <label class="block text-purple-700 font-semibold">From Date</label>
                    <input v-model="fromDate" type="date"
                        class="w-full p-2 border rounded-lg bg-white/80 border-pink-300 focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-purple-700 font-semibold">To Date</label>
                    <input v-model="toDate" type="date"
                        class="w-full p-2 border rounded-lg bg-white/80 border-pink-300 focus:ring-2 focus:ring-purple-400">
                </div>
                <button @click.prevent="SalesReport()" type="submit"
                    class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                    Generate Report
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped></style>
