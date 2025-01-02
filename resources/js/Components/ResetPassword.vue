<script setup>
import nProgress from 'nprogress';
import { reactive } from 'vue';

const state = reactive({
    password: '',
    confirmPassword: '',
    showPassword: false,
    showConfirmPassword: false,
    errorMessage: ''
});

// Regular expression for strong password validation (at least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character)
const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

function togglePasswordVisibility() {
    state.showPassword = !state.showPassword;
}

function toggleConfirmPasswordVisibility() {
    state.showConfirmPassword = !state.showConfirmPassword;
}

function validatePasswords() {
    if (state.password === '' || state.confirmPassword === '') {
        state.errorMessage = 'Please enter both password fields.';
        return false;
    } else if (state.password !== state.confirmPassword) {
        state.errorMessage = 'Passwords do not match.';
        return false;
    } else if (!passwordRegex.test(state.password)) {
        let message = 'Password must be at least 8 characters long, ';
        if (!/[A-Z]/.test(state.password)) {
            message += 'include at least one uppercase letter, ';
        }
        if (!/[a-z]/.test(state.password)) {
            message += 'include at least one lowercase letter, ';
        }
        if (!/\d/.test(state.password)) {
            message += 'include at least one number, ';
        }
        if (!/[!@#$%^&*]/.test(state.password)) {
            message += 'include at least one special character.';
        }
        state.errorMessage = message.trim();
        return false;
    } else {
        state.errorMessage = '';
        return true;
    }
}

async function resetPassword() {
    // Validate before submitting the form
    if (!validatePasswords()) {
        return;
    }

    try {
        nProgress.start();
        const response = await axios.post('/reset-password', { password: state.password });
        nProgress.done();
        if (response.status === 200 && response.data.status === 'success') {
            window.location.href = '/login';
        } else {
            alert(response.data.message);
        }
    } catch (error) {
        console.error(error);
        alert('An error occurred while processing the request.');
    }
}
</script>

<template>
    <div
        class="relative z-10 max-w-[440px] w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-12 shadow-xl animate-[slideIn_0.6s_ease-out_forwards]">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-white-500 mb-2">Reset Password</h1>
            <p class="text-white-500 text-base">Enter your new password below</p>
        </div>
        <form @submit.prevent="resetPassword">
            <!-- New Password Field -->
            <div class="relative mb-6">
                <input v-model="state.password" :type="state.showPassword ? 'text' : 'password'"
                    class="w-full py-4 pl-12 bg-teal-300/5  border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="New Password" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-lock"></i>
                <i @click="togglePasswordVisibility"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white-500 fa"
                    :class="state.showPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
            </div>

            <!-- Confirm Password Field -->
            <div class="relative mb-6">
                <input v-model="state.confirmPassword" :type="state.showConfirmPassword ? 'text' : 'password'"
                    class="w-full py-4 pl-12 bg-teal-300/5  border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Confirm Password" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-lock"></i>
                <i @click="toggleConfirmPasswordVisibility"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white-500 fa"
                    :class="state.showConfirmPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
            </div>

            <!-- Error message -->
            <p v-if="state.errorMessage" class="text-red-500 text-sm mb-4">{{ state.errorMessage }}</p>

            <button @click="resetPassword" type="submit"
                class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                Reset Password
            </button>
        </form>

        <div class="text-center text-sm text-white/60 mt-6">
            <p>
                Remembered your password?
                <a href="/login" class="hover:opacity-80">Back to Sign In</a>
            </p>
        </div>
    </div>
</template>

<style scoped></style>
