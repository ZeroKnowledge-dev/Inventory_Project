<script setup>
import nProgress from 'nprogress';
import { reactive } from 'vue';

const state = reactive({
    otp: '',
    email: sessionStorage.getItem('email')
});

async function verifyOTP() {
    if (state.otp === '') {
        alert('Please enter OTP');
    } else {
        nProgress.start();
        const response = await axios.post('/verify-otp', state);
        nProgress.done();
        if (response.status === 200 && response.data.status === 'success') {
            sessionStorage.clear();
            window.location.href = '/resetPassword';
        } else {
            alert(response.data.message);
        }
    }
}
</script>

<template>
    <div
        class="relative z-10 max-w-[440px] w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-12 shadow-xl animate-[slideIn_0.6s_ease-out_forwards]">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-white-500 mb-2">
                Verify Your OTP</h1>
            <p class="text-white-500 text-base">Enter the OTP sent to your email</p>
        </div>
        <form>
            <div class="relative mb-6">
                <input v-model="state.otp" type="text"
                    class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Enter OTP" required maxlength="4" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-key"></i>
            </div>

            <button @click="verifyOTP" type="submit"
                class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                Verify OTP
            </button>
        </form>

        <div class="text-center text-sm text-white/60 mt-6">
            <p class="mt-4">
                Back to Login?
                <a href="/login" class="hover:opacity-80">Sign In</a>
            </p>
        </div>
    </div>
</template>

<style scoped></style>
