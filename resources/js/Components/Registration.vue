<script setup>
import nProgress from 'nprogress';
import { reactive, computed } from 'vue';

const state = reactive({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    password: '',
    showPassword: false,
    errors: {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        password: '',
    }
});

function togglePasswordVisibility() {
    state.showPassword = !state.showPassword;
}

// Email Validation Regex
const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

// Phone Validation Regex (10 digits)
const phoneRegex = /^[0-9]/;

// Password Validation Regex (at least 8 characters, 1 number, 1 special character)
const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/;

// Function to validate each field on blur
function validateField(field) {
    switch (field) {
        case 'firstName':
            state.errors.firstName = state.firstName.trim() === '' ? 'First name is required' : '';
            break;
        case 'lastName':
            state.errors.lastName = state.lastName.trim() === '' ? 'Last name is required' : '';
            break;
        case 'email':
            state.errors.email = !emailRegex.test(state.email) ? 'Please enter a valid email address' : '';
            break;
        case 'phone':
            state.errors.phone = !phoneRegex.test(state.phone) ? 'Please enter a valid 10-digit phone number' : '';
            break;
        case 'password':
            state.errors.password = !passwordRegex.test(state.password) ? 'Password must be at least 8 characters long\n contain at least one number, and one special character' : '';
            break;
        default:
            break;
    }
}

// Computed property for the form's validity
const isFormValid = computed(() => {
    // Check if there are any errors or if any fields are empty
    return (
        state.firstName &&
        state.lastName &&
        state.email &&
        state.phone &&
        state.password &&
        !Object.values(state.errors).some(error => error)
    );
});

async function register() {
    // Perform final validation
    validateField('firstName');
    validateField('lastName');
    validateField('email');
    validateField('phone');
    validateField('password');

    // If the form is invalid, do not proceed
    if (!isFormValid.value) {
        return;
    }

    nProgress.start();
    try {
        const response = await axios.post('/user-registration', state);
        nProgress.done();

        if (response.status === 200 && response.data.status === 'success') {
            window.location.href = '/login';
        } else {
            alert(response.data.message);
        }
    } catch (error) {
        nProgress.done();
        alert('An error occurred while registering. Please try again later.');
    }
}
</script>

<template>
    <div
        class="relative z-10 max-w-[440px] w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-12 shadow-xl animate-[slideIn_0.6s_ease-out_forwards]">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-white-500 mb-2">Create an Account</h1>
            <p class="text-white-500 text-base">Sign up to continue your journey</p>
        </div>
        <form id="signupForm" @submit.prevent="register">
            <p v-if="state.errors.firstName" class="text-red-500 text-sm ml-2">{{
                state.errors.firstName }}
            </p>
            <div class="relative mb-6">
                <input v-model="state.firstName" minlength="2" type="text"
                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="First Name" @blur="validateField('firstName')" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
            </div>

            <p v-if="state.errors.lastName" class="text-red-500 text-sm ml-2">{{ state.errors.lastName }}</p>
            <div class="relative mb-6">
                <input v-model="state.lastName" minlength="2" type="text"
                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Last Name" @blur="validateField('lastName')" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
            </div>

            <p v-if="state.errors.email" class="text-red-500 text-sm ml-2">{{ state.errors.email }}</p>
            <div class="relative mb-6">
                <input v-model="state.email" type="email"
                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Email address" @blur="validateField('email')" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-envelope"></i>
            </div>

            <p v-if="state.errors.phone" class="text-red-500 text-sm ml-2">{{ state.errors.phone }}</p>
            <div class="relative mb-6">
                <input v-model="state.phone" type="text"
                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Phone Number" @blur="validateField('phone')" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-phone"></i>
            </div>

            <p v-if="state.errors.password" class="text-red-500 text-sm ml-2">{{ state.errors.password }}</p>
            <div class="relative mb-6">
                <input v-model="state.password" :type="state.showPassword ? 'text' : 'password'"
                    class="w-full py-4 pl-12 bg-teal-300/5  border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Password" @blur="validateField('password')" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-lock"></i>
                <i @click="togglePasswordVisibility"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white-500 fa"
                    :class="state.showPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
            </div>

            <button :disabled="!isFormValid" type="submit"
                class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                Sign Up
            </button>
        </form>

        <!-- Continue with social login buttons -->
        <div class="flex items-center my-6 text-white/40">
            <div class="flex-1 border-t border-white/20"></div>
            <span class="px-4 text-white text-sm">or continue with</span>
            <div class="flex-1 border-t border-white/20"></div>
        </div>

        <div class="flex justify-center gap-4 mb-6">
            <button
                class="w-12 h-12 border border-white/20 rounded-xl bg-white/5 flex items-center justify-center text-white text-xl hover:scale-105 transition">
                <i class="fab fa-google"></i>
            </button>
            <button
                class="w-12 h-12 border border-white/20 rounded-xl bg-white/5 flex items-center justify-center text-white text-xl hover:scale-105 transition">
                <i class="fab fa-apple"></i>
            </button>
            <button
                class="w-12 h-12 border border-white/20 rounded-xl bg-white/5 flex items-center justify-center text-white text-xl hover:scale-105 transition">
                <i class="fab fa-github"></i>
            </button>
        </div>

        <div class="text-center text-sm text-white/60">
            <p class="mt-4">
                Already have an account?
                <a href="/login" class="hover:opacity-80">Sign in</a>
            </p>
        </div>
    </div>
</template>

<style scoped></style>
