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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Center Div -->
    <div class="flex items-center justify-center min-h-screen">

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

        <div
            class="relative z-10 max-w-[440px] w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-12 shadow-xl animate-[slideIn_0.6s_ease-out_forwards]">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-white-500 mb-2">
                    Verify Your OTP</h1>
                <p class="text-white-500 text-base">Enter the OTP sent to your email</p>
            </div>
            <form>
                <div class="relative mb-6">
                    <input v-model="state.otp" type="text" id="otp"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Enter OTP" required maxlength="6" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-key"></i>
                    <span class="text-red-500 text-sm mt-1 hidden" id="otpError"></span>
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

    </div>
</template>

<style scoped></style>
