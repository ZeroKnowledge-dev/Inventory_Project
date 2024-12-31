<script setup>
import nProgress from 'nprogress';
import { reactive } from 'vue';

const state = reactive({
    password: '',
    confirmPassword: '',
    showPassword: false,
    showConfirmPassword: false
});

function togglePasswordVisibility() {
    state.showPassword = !state.showPassword;
}

function toggleConfirmPasswordVisibility() {
    state.showConfirmPassword = !state.showConfirmPassword;
}

async function resetPassword() {
    if (state.password === '' || state.confirmPassword === '') {
        alert('Please enter all fields');
    } else if (state.password !== state.confirmPassword) {
        alert('Passwords do not match');
    } else {
        nProgress.start();
        const response = await axios.post('/reset-password', { password: state.password });
        nProgress.done();
        if (response.status === 200 && response.data.status === 'success') {
            debugger;
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
                    Reset Password</h1>
                <p class="text-white-500 text-base">Enter your new password below</p>
            </div>
            <form>
                <!-- New Password Field -->
                <div class="relative mb-6">
                    <input v-model="state.password" :type="state.showPassword ? 'text' : 'password'" id="password"
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
                        id="password"
                        class="w-full py-4 pl-12 bg-teal-300/5  border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                        placeholder="Confirm Password" />
                    <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-lock"></i>
                    <i @click="toggleConfirmPasswordVisibility"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white-500 fa"
                        :class="state.showConfirmPassword ? 'fa-eye' : 'fa-eye-slash'"></i>
                </div>

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

    </div>
</template>

<style scoped></style>
