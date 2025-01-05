<script setup>

</script>

<template>
    <!-- Sidebar -->

    <ul class="space-y-6 ml-4">
        <li>
            <a href="/profile"
                class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                <i class="fa fa-user-circle mr-4"></i> Profile
            </a>
        </li>

        <li>
            <a href="/category"
                class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                <i class="fa fa-list mr-4"></i> Category
            </a>
        </li>

        <li>
            <a href="/customer"
                class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                <i class="fa fa-users mr-4"></i> Customer
            </a>
        </li>

        <li>
            <a href="/logout" class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                <i class="fa fa-sign-out-alt mr-4"></i> Logout
            </a>
        </li>
    </ul>
</template>

<style scoped></style>
