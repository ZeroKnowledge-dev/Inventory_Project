<script setup>
import PostLogin from '@/Layouts/PostLogin.vue';
import Sidebar from '@/Components/Sidebar.vue';
import DashboardMain from '@/Components/DashboardMain.vue';
</script>

<template>

    <div class="min-h-screen relative flex flex-col">

        <PostLogin />

        <!-- Sidebar and Main Content -->
        <div class="flex flex-1">
            <!-- Sidebar  -->
            <Sidebar />

            <!-- Main Content  -->
            <DashboardMain />
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
