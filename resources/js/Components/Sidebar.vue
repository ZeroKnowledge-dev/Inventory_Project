<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <!-- Sidebar -->

    <ul class="space-y-6 ml-4">
        <li>
            <Link href="/profile"
                class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
            <i class="fa fa-user-circle mr-4"></i> Profile
            </Link>
        </li>

        <li>
            <Link href="/category"
                class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
            <i class="fa fa-list mr-4"></i> Category
            </Link>
        </li>

        <li>
            <Link href="/customer"
                class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
            <i class="fa fa-users mr-4"></i> Customer
            </Link>
        </li>

        <li>
            <Link href="/product"
                class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
            <i class="fa fa-box mr-4"></i> Product
            </Link>
        </li>

        <li>
            <Link href="/logout"
                class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
            <i class="fa fa-sign-out-alt mr-4"></i> Logout
            </Link>
        </li>
    </ul>
</template>

<style scoped></style>
