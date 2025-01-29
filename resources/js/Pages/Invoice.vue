<script setup>
import PostLogin from '@/Layouts/PostLogin.vue';
import Sidebar from '@/Components/Sidebar.vue';
import InvoiceMain from '@/Components/InvoiceMain.vue';

</script>

<template>
    <div class="min-h-screen relative flex flex-col">

        <PostLogin />

        <!-- Sidebar and Main Content -->
        <div class="flex flex-1">
            <!-- Sidebar  -->
            <aside class="w-64 bg-cyan-300/50 backdrop-blur-xl border-r border-cyan-300/10 p-4 shadow-xl">
                <Sidebar />
            </aside>
            <!-- Main Content  -->
            <InvoiceMain />
        </div>
    </div>
</template>

<style scoped></style>
