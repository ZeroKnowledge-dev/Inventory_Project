<script setup>
import nProgress from 'nprogress';
import { reactive } from 'vue';

const state = reactive({
    email: '',
    errorMessage: ''
});

// Validate email format
function validateEmail() {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (state.email === '') {
        state.errorMessage = 'Email is required';
    } else if (!emailRegex.test(state.email)) {
        state.errorMessage = 'Please enter a valid email address';
    } else {
        state.errorMessage = '';
    }
}

async function forgotPassword() {
    // Validate email before proceeding
    validateEmail();

    // If there's an error, don't proceed with the request
    if (state.errorMessage) {
        return;
    }

    try {
        nProgress.start();
        const response = await axios.post('/send-otp', { email: state.email });
        nProgress.done();
        if (response.status === 200 && response.data.status === 'success') {
            sessionStorage.setItem('email', state.email);
            window.location.href = '/otpVerification';
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
        <div class="text-center mb-6">
            <h1 class="text-4xl font-extrabold text-white-500 mb-2">
                Forgot Password?</h1>
            <p class="text-white-500 text-base mt-4">Enter your email to reset your password</p>
        </div>
        <form>
            <div class="relative mb-6">
                <input v-model="state.email" type="email" @blur="validateEmail"
                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Email address" required />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-envelope"></i>

                <!-- Display error message if email is invalid -->
                <p v-if="state.errorMessage" class="text-red-500 text-sm mt-1">{{ state.errorMessage }}</p>
            </div>

            <button @click.prevent="forgotPassword" type="submit"
                class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                Send Reset Link
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
