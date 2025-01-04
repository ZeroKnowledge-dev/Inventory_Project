<script setup>
import { reactive } from 'vue';
import nProgress from 'nprogress';

const state = reactive({
    id: '',
    name: '',
    categories: [],
    addCategory: false,
    editCategory: false
});

async function getCategories() {
    nProgress.start();
    const res = await axios.get('/list-category');
    nProgress.done();
    state.categories = res.data;
}

async function addCategory() {
    if (state.name === '') {
        alert('Please enter category name');
    } else {
        nProgress.start();
        const res = await axios.post('/create-category', { name: state.name });
        nProgress.done();
        if (res.status === 201) {
            await getCategories();
            state.addCategory = false;
            state.name = '';
        } else {
            alert('Something went wrong');
        }
    }
}

async function updateCategory() {
    if (state.name === '') {
        alert('Please enter category name');
    } else {
        nProgress.start();
        const res = await axios.post('/update-category', { id: state.id, name: state.name });
        nProgress.done();
        if (res.data === 1 && res.status === 200) {
            await getCategories();
            state.editCategory = false;
            state.name = '';
            state.id = '';
        } else {
            alert('Something went wrong');
        }
    }
}

async function deleteCategory() {
    nProgress.start();
    const res = await axios.post('/delete-category', { id: state.id });
    nProgress.done();
    if (res.data === 1) {
        alert('Category deleted successfully');
        getCategories();
    } else {
        alert('Something went wrong');
    }
}

function toggleAddCategoryModal() {
    state.addCategory = !state.addCategory;
}

function toggleEditCategoryModal(category) {
    state.editCategory = !state.editCategory;
    if (category) {
        state.id = category.id;
        state.name = category.name;
    }
}

getCategories();
</script>


<template>
    <!-- Main Content -->
    <template v-if="!state.addCategory && !state.editCategory">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10">
            <div class="w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="pl-4 flex flex-row pb-10">
                    <h1 class="text-2xl font-semibold text-purple-500 flex-1">Category</h1>
                    <button @click="toggleAddCategoryModal"
                        class="py-2 px-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Add
                        Category</button>
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="bg-pink-300/50">
                            <th class="py-4">No</th>
                            <th class="py-4">Category Name</th>
                            <th class="py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, index) in state.categories" :key="category.id">
                            <td class="py-4 text-center">{{ index + 1 }}</td>
                            <td class="py-4 text-center">{{ category.name }}</td>
                            <td class="py-4 text-center">
                                <button @click="toggleEditCategoryModal(category)"
                                    class="bg-red-300 py-2 px-4 mr-4 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Edit</button>
                                <button @click="state.id = category.id; deleteCategory()"
                                    class="bg-red-300 py-2 px-4 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>

    <!-- Add Category Modal -->
    <template v-if="state.addCategory">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10 flex justify-center items-center">
            <div
                class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="text-center mb-12 px-24">
                    <h1 class="text-3xl font-extrabold text-purple-500">Add a New Category</h1>
                </div>
                <i class="fa fa-close absolute top-4 right-4 text-2xl cursor-pointer"
                    @click="toggleAddCategoryModal"></i>
                <form action="">
                    <div class="relative mb-6">
                        <input v-model="state.name" type="text"
                            class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                            placeholder="Category Name" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-list"></i>
                    </div>
                    <button @click.prevent="addCategory()" type="submit"
                        class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                        Add Category
                    </button>
                </form>
            </div>
        </div>
    </template>

    <!-- Edit Category Modal -->
    <template v-if="state.editCategory">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10 flex justify-center items-center">
            <div
                class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="text-center mb-12 px-24">
                    <h1 class="text-3xl font-extrabold text-purple-500">Change Category Name</h1>
                </div>
                <i class="fa fa-close absolute top-4 right-4 text-2xl cursor-pointer"
                    @click="toggleEditCategoryModal"></i>
                <form action="">
                    <div class="relative mb-6">
                        <input v-model="state.name" type="text"
                            class="w-full py-4 pl-12 bg-teal-300/5 border border-black/10 rounded-xl text-white-500 text-base focus:outline-none focus:ring-1 focus:ring-white/30 placeholder-white-500 transition"
                            placeholder="Category Name" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white-500 fa fa-list"></i>
                    </div>
                    <button @click.prevent="updateCategory()" type="submit"
                        class="w-full py-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </template>
</template>

<style scoped></style>
