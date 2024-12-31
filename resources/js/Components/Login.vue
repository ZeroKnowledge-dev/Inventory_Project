<script setup>
import nProgress from 'nprogress';
import { reactive } from 'vue';


const state = reactive({
    email: '',
    password: '',
    showPassword: false
});

async function login() {
    if (state.email === '' || state.password === '') {
        alert('Please enter email and password');
    } else {
        nProgress.start();
        const response = await axios.post('/user-login', state);
        nProgress.done();
        if (response.status === 200 && response.data.status === 'success') {
            window.location.href = '/dashboard';
        } else {
            alert(response.data.message);
        }
    }
};

function togglePasswordVisibility() {
    state.showPassword = !state.showPassword;
}
</script>

<template>
    <div
        class="relative z-10 max-w-[440px] w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-12 shadow-xl animate-[slideIn_0.6s_ease-out_forwards]">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-white-500 mb-2">
                Welcome Back</h1>
            <p class="text-white-500 text-base">Sign in to continue your journey</p>
        </div>
        <form id="loginForm">
            <div class="relative mb-6">
                <input v-model="state.email" type="email" id="email"
                    class="w-full py-4 pl-12 bg-teal-300/5  border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Email address" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-envelope"></i>
                <span class="text-red-500 text-sm mt-1 hidden" id="emailError"></span>
            </div>

            <div class="relative mb-6">
                <input v-model="state.password" :type="state.showPassword ? 'text' : 'password'" id="password"
                    class="w-full py-4 pl-12 bg-teal-300/5  border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                    placeholder="Password" />
                <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-lock"></i>
                <i @click="togglePasswordVisibility"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white-500 fa"
                    :class="state.showPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
            </div>

            <button @click="login" type="submit"
                class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                Sign In
            </button>
        </form>
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
            <a href="/forgotPassword" class="hover:opacity-80">Forgot password?</a>
            <p class="mt-4">
                Don't have an account?
                <a href="/registration" class="hover:opacity-80">Sign up</a>
            </p>
        </div>
    </div>
</template>

<style scoped></style>
