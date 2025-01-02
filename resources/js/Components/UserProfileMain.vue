<script setup>
import nProgress from 'nprogress';
import { reactive } from 'vue';

const state = reactive({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    password: '',
    showPassword: false,
    passwordErrorMessage: '' // Added to hold password validation error message
})

// Regular expression for strong password validation (at least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character)
const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

function togglePasswordVisibility() {
    state.showPassword = !state.showPassword;
}

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

// Password validation function
function validatePassword() {
    if (!passwordRegex.test(state.password)) {
        state.passwordErrorMessage = 'Password must be at least 8 characters long, include at least one uppercase letter, one number, and one special character.';
        return false;
    } else {
        state.passwordErrorMessage = ''; // Clear error message if password is valid
        return true;
    }
}

async function updateProfile() {
    // Validate password before updating profile
    if (state.firstName === '' || state.lastName === '' || state.email === '' || state.phone === '' || state.password === '') {
        alert('Please enter all fields');
        return;
    }

    // Perform password validation
    if (!validatePassword()) {
        return; // Don't submit form if password is invalid
    }

    try {
        const response = await axios.post('/user-update', {
            firstName: state.firstName,
            lastName: state.lastName,
            phone: state.phone,
            password: state.password
        });
        if (response.status === 200 && response.data.status === 'success') {
            getProfile(); // Reload the profile after update
        } else {
            alert(response.data.message);
        }
    } catch (error) {
        console.error(error);
        alert('An error occurred while updating your profile.');
    }
}

getProfile(); // Fetch profile data on component load
</script>

<template>
    <!-- Main Content -->
    <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10 flex justify-center items-center">
        <div
            class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
            <div class="text-center mb-12 px-24">
                <h1 class="text-4xl font-extrabold text-purple-500">Update Your Profile</h1>
                <p class="text-lg text-gray-500">Keep your information up to date</p>
            </div>
            <form @submit.prevent="updateProfile">
                <div class="relative mb-6">
                    <input v-model="state.email" readonly type="email"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Email Address" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-envelope"></i>
                </div>

                <div class="relative mb-6">
                    <input v-model="state.firstName" type="text"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="First Name" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
                </div>

                <div class="relative mb-6">
                    <input v-model="state.lastName" type="text"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Last Name" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
                </div>

                <div class="relative mb-6">
                    <input v-model="state.phone" type="text"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Phone Number" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-phone"></i>
                </div>

                <div class="relative mb-6">
                    <input v-model="state.password" :type="state.showPassword ? 'text' : 'password'"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Password" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-lock"></i>
                    <i @click="togglePasswordVisibility"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white-500 fa"
                        :class="state.showPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
                </div>

                <!-- Error message for password -->
                <p v-if="state.passwordErrorMessage" class="text-red-500 text-sm mb-4">{{ state.passwordErrorMessage }}
                </p>

                <button type="submit"
                    class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped></style>
