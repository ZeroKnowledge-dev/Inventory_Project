<script setup>
import nProgress from 'nprogress';
import Swal from 'sweetalert2';
import { reactive, ref } from 'vue';

const showDropdown = ref(false);

const state = reactive({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    password: '',
    showPassword: false
})

function togglePasswordVisibility() {
    state.showPassword = !state.showPassword;
}

function toggleDropdown() {
    showDropdown.value = !showDropdown.value;
}

getProfile();

async function getProfile() {
    nProgress.start();
    const response = await axios.get('/user-profile');
    nProgress.done();

    if (response.status === 200 && response.data.status === 'success') {
        let data = response.data.data;
        state.firstName = data.firstName;
        state.lastName = data.lastName;
        state.email = data.email;
        state.phone = data.phone;
        state.password = data.password;
    } else {
        alert(response.data.message);
    }
}

async function updateProfile() {
    if (state.firstName === '' || state.lastName === '' || state.email === '' || state.phone === '' || state.password === '') {
        alert('Please enter all fields');
    } else {
        const response = await axios.post('/user-update', {
            firstName: state.firstName,
            lastName: state.lastName,
            phone: state.phone,
            password: state.password
        });
        if (response.status === 200 && response.data.status === 'success') {
            getProfile();
        } else {
            alert(response.data.message);
        }
    }
}

</script>

<template>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <div class="min-h-screen flex flex-col">

        <!-- Top Bar -->
        <div class="bg-purple-500 text-white p-4 flex justify-between items-center shadow-lg">
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
                        class="absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-lg z-10">
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

        <div class="flex flex-1">

            <!-- Sidebar -->
            <div class="w-64 bg-cyan-300/50 backdrop-blur-xl border-r border-cyan-300/10 p-4 shadow-xl">
                <ul class="space-y-6 ml-4">
                    <li>
                        <a href="/profile"
                            class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
                            <i class="fa fa-user-circle mr-4"></i> Profile
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-black text-lg font-medium hover:text-purple-500 transition">
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
            </div>

            <!-- Main Content -->
            <div class="flex-1 relative p-8 bg-white overflow-hidden">
                <!-- Background -->
                <div class="absolute bg-slate-400 top-0 left-0 w-full h-full z-0 overflow-hidden">
                    <div
                        class="absolute rounded-full blur-3xl animate-[moveSphere_20s_infinite_ease-in-out] w-[600px] h-[600px] bg-gradient-to-br from-pink-500 to-yellow-400 -top-72 -left-72 animate-delay-[-5s]">
                    </div>
                    <div
                        class="absolute rounded-full blur-3xl animate-[moveSphere_20s_infinite_ease-in-out] w-[500px] h-[500px] bg-gradient-to-br from-indigo-500 to-cyan-500 -bottom-64 -right-64 animate-delay-[-2s]">
                    </div>
                    <div
                        class="absolute rounded-full blur-3xl animate-[moveSphere_20s_infinite_ease-in-out] w-[400px] h-[400px] bg-gradient-to-br from-purple-700 to-pink-500 top-1/2 left-1/3 animate-delay-[-8s]">
                    </div>
                </div>

                <!-- Foreground Content -->
                <div class="relative z-10">
                    <div class="text-center mb-12">
                        <h1 class="text-4xl font-extrabold text-purple-500">Update Your Profile</h1>
                        <p class="text-lg text-gray-500">Keep your information up to date</p>
                    </div>

                    <div
                        class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                        <form id="updateProfileForm">
                            <div class="relative mb-6">
                                <input v-model="state.email" readonly type="email" id="email"
                                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                                    placeholder="Email Address" />
                                <i
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-envelope"></i>
                            </div>

                            <div class="relative mb-6">
                                <input v-model="state.firstName" type="text" id="firstName"
                                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                                    placeholder="First Name" />
                                <i
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
                            </div>

                            <div class="relative mb-6">
                                <input v-model="state.lastName" type="text" id="lastName"
                                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                                    placeholder="Last Name" />
                                <i
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
                            </div>



                            <div class="relative mb-6">
                                <input v-model="state.phone" type="text" id="phone"
                                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                                    placeholder="Phone Number" />
                                <i
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-phone"></i>
                            </div>

                            <div class="relative mb-6">
                                <input v-model="state.password" :type="state.showPassword ? 'text' : 'password'"
                                    id="password"
                                    class="w-full py-4 pl-12 bg-teal-300/5  border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                                    placeholder="Password" />
                                <i
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-lock"></i>
                                <i @click="togglePasswordVisibility"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white-500 fa"
                                    :class="state.showPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
                            </div>

                            <button @click="updateProfile" type="submit"
                                class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                                Update Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>

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
