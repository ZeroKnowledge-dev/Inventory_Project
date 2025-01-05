<script setup>
import { reactive } from 'vue';
import nProgress from 'nprogress';

const state = reactive({
    id: '',
    name: '',
    email: '',
    mobile: '',
    categories: [],
    addCustomer: false,
    editCustomer: false
});

async function getCategories() {
    nProgress.start();
    const res = await axios.get('/list-customer');
    nProgress.done();
    state.categories = res.data;
}

// Email validation regex (basic pattern)
const emailRegex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;

// Phone number validation regex (basic pattern)
const phoneRegex = /^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/;

async function addCustomer() {
    // Check for empty fields
    if (state.name === '' || state.email === '' || state.mobile === '') {
        alert('Please enter customer name, email, and mobile number');
        return;
    }

    // Validate email format
    if (!emailRegex.test(state.email)) {
        alert('Please enter a valid email address');
        return;
    }

    // Validate phone number format
    if (!phoneRegex.test(state.mobile)) {
        alert('Please enter a valid mobile number');
        return;
    }

    nProgress.start();
    try {
        const res = await axios.post('/create-customer', { name: state.name, email: state.email, mobile: state.mobile });
        nProgress.done();
        if (res.status === 201) {
            await getCategories();
            state.addCustomer = false;
            state.name = '';
            state.email = '';
            state.mobile = '';
        } else {
            alert('Something went wrong');
        }
    } catch (error) {
        nProgress.done();
        alert('An error occurred while adding the customer');
    }
}

async function updateCustomer() {
    // Check for empty fields
    if (state.name === '' || state.email === '' || state.mobile === '') {
        alert('Please enter customer name, email, and mobile number');
        return;
    }

    // Validate email format
    if (!emailRegex.test(state.email)) {
        alert('Please enter a valid email address');
        return;
    }

    // Validate phone number format
    if (!phoneRegex.test(state.mobile)) {
        alert('Please enter 11 digit mobile number');
        return;
    }

    nProgress.start();
    try {
        const res = await axios.post('/update-customer', { id: state.id, name: state.name, email: state.email, mobile: state.mobile });
        nProgress.done();
        if (res.data === 1 && res.status === 200) {
            await getCategories();
            state.editCustomer = false;
            state.name = '';
            state.email = '';
            state.mobile = '';
            state.id = '';
        } else {
            alert('Something went wrong');
        }
    } catch (error) {
        nProgress.done();
        alert('An error occurred while updating the customer');
    }
}


async function deleteCustomer() {
    nProgress.start();
    const res = await axios.post('/delete-customer', { id: state.id });
    nProgress.done();
    if (res.data === 1) {
        alert('Customer deleted successfully');
        getCategories();
    } else {
        alert('Something went wrong');
    }
}

function toggleAddCustomerModal() {
    state.addCustomer = !state.addCustomer;
}

function toggleEditCustomerModal(Customer) {
    state.editCustomer = !state.editCustomer;
    if (Customer) {
        state.id = Customer.id;
        state.name = Customer.name;
        state.email = Customer.email;
        state.mobile = Customer.mobile;
    }
}

getCategories();
</script>


<template>
    <!-- Main Content -->
    <template v-if="!state.addCustomer && !state.editCustomer">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10">
            <div class="w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="pl-4 flex flex-row pb-10">
                    <h1 class="text-2xl font-semibold text-purple-500 flex-1">Customer</h1>
                    <button @click="toggleAddCustomerModal"
                        class="py-2 px-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Add
                        Customer</button>
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="bg-pink-300/50">
                            <th class="py-4">No</th>
                            <th class="py-4">Name</th>
                            <th class="py-4">Email</th>
                            <th class="py-4">Phone No</th>
                            <th class="py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(Customer, index) in state.categories" :key="Customer.id">
                            <td class="py-4 text-center">{{ index + 1 }}</td>
                            <td class="py-4 text-center">{{ Customer.name }}</td>
                            <td class="py-4 text-center">{{ Customer.email }}</td>
                            <td class="py-4 text-center">{{ Customer.mobile }}</td>
                            <td class="py-4 text-center">
                                <button @click="toggleEditCustomerModal(Customer)"
                                    class="bg-red-300 py-2 px-4 mr-4 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Edit</button>
                                <button @click="state.id = Customer.id; deleteCustomer()"
                                    class="bg-red-300 py-2 px-4 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>

    <!-- Add Customer Modal -->
    <template v-if="state.addCustomer">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10 flex justify-center items-center">
            <div
                class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="text-center mb-12 px-24">
                    <h1 class="text-3xl font-extrabold text-purple-500">Add a New Customer</h1>
                </div>
                <i class="fa fa-close absolute top-4 right-4 text-2xl cursor-pointer"
                    @click="toggleAddCustomerModal"></i>
                <form action="">
                    <div class="relative mb-6">
                        <input v-model="state.name" type="text"
                            class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                            placeholder="Customer Name" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
                    </div>
                    <div class="relative mb-6">
                        <input v-model="state.email" type="text"
                            class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                            placeholder="Customer Email" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-envelope"></i>
                    </div>
                    <div class="relative mb-6">
                        <input v-model="state.mobile" type="text"
                            class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                            placeholder="Customer Phone No" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-phone"></i>
                    </div>
                    <button @click.prevent="addCustomer()" type="submit"
                        class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                        Add Customer
                    </button>
                </form>
            </div>
        </div>
    </template>

    <!-- Edit Customer Modal -->
    <template v-if="state.editCustomer">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10 flex justify-center items-center">
            <div
                class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="text-center mb-12 px-24">
                    <h1 class="text-3xl font-extrabold text-purple-500">Change Customer Name</h1>
                </div>
                <i class="fa fa-close absolute top-4 right-4 text-2xl cursor-pointer"
                    @click="toggleEditCustomerModal"></i>
                <form action="">
                    <div class="relative mb-6">
                        <input v-model="state.name" type="text"
                            class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                            placeholder="Customer Name" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-user"></i>
                    </div>
                    <div class="relative mb-6">
                        <input v-model="state.email" type="text"
                            class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                            placeholder="Customer Email" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-envelope"></i>
                    </div>
                    <div class="relative mb-6">
                        <input v-model="state.mobile" type="text"
                            class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                            placeholder="Customer Phone No" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-phone"></i>
                    </div>
                    <button @click.prevent="updateCustomer()" type="submit"
                        class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </template>
</template>

<style scoped></style>
