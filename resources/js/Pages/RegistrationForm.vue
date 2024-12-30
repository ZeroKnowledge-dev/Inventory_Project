<script setup>
import { reactive } from 'vue';

const state = reactive({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    password: ''
})

async function register() {
    if (state.firstName === '' || state.lastName === '' || state.email === '' || state.phone === '' || state.password === '') {
        alert('Please enter all fields');
    } else {
        const response = await axios.post('/user-registration', state);
        if (response.status === 200 && response.data.status === 'success') {
            window.location.href = '/login';
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
                    Create an Account</h1>
                <p class="text-white-500 text-base">Sign up to continue your journey</p>
            </div>
            <form id="signupForm">
                <div class="relative mb-6">
                    <input v-model="state.firstName" type="text" id="name"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="First Name" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
                </div>

                <div class="relative mb-6">
                    <input v-model="state.lastName" type="text" id="name"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Last Name" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
                </div>

                <div class="relative mb-6">
                    <input v-model="state.email" type="email" id="email"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Email address" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-envelope"></i>
                </div>

                <div class="relative mb-6">
                    <input v-model="state.phone" type="text" id="number"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Phone Number" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-phone"></i>
                </div>

                <div class="relative mb-6">
                    <input v-model="state.password" type="password" id="Password"
                        class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Password" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-lock"></i>
                </div>

                <button @click="register" type="submit"
                    class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                    Sign Up
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
                <p class="mt-4">
                    Already have an account?
                    <a href="/login" class="hover:opacity-80">Sign in</a>
                </p>
            </div>
        </div>

    </div>
</template>

<style scoped></style>
