<script setup>

</script>

<template>
    <!-- Sidebar -->
    <aside class="w-64 bg-cyan-300/50 backdrop-blur-xl border-r border-cyan-300/10 p-4 shadow-xl">
        <ul class="space-y-6 ml-4">
            <li>
                <a href="/profile"
                    class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                    <i class="fa fa-user-circle mr-4"></i> Profile
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
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
    </aside>
</template>

<style scoped></style>
