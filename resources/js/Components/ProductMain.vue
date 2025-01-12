<script setup>

import { ref, reactive } from "vue";
import { useForm } from "@inertiajs/vue3";
import nProgress from 'nprogress';

const url = ref(null);
const photo = ref(null);

const previewImage = (e) => {
    const file = e.target.files[0];
    url.value = URL.createObjectURL(file);
};

const createProductForm = useForm({
    category_id: '',
    name: '',
    price: '',
    unit: '',
    img_url: null,
});

const updateProductForm = useForm({
    id: '',
    category_id: '',
    name: '',
    price: '',
    unit: '',
    file_path: '',
    img_url: null,
});

const deleteProductForm = useForm({
    id: '',
    img_url: null,
})

const state = reactive({
    categories: [],
    products: [],
    addProduct: false,
    editProduct: false
});

// Reset form fields
const resetForm = () => {
    createProductForm.category_id = '';
    createProductForm.name = '';
    createProductForm.price = '';
    createProductForm.unit = '';
    createProductForm.img_url = null;

    updateProductForm.id = '';
    updateProductForm.category_id = '';
    updateProductForm.name = '';
    updateProductForm.price = '';
    updateProductForm.unit = '';
    updateProductForm.img_url = null;

    deleteProductForm.id = '';
    deleteProductForm.img_url = null;
};

// Fetch categories
async function getCategories() {
    try {
        nProgress.start();
        const res = await axios.get('/list-category');
        state.categories = res.data;
    } catch (error) {
        alert('Failed to load categories');
    } finally {
        nProgress.done();
    }
}

// Fetch products
async function getProducts() {
    try {
        nProgress.start();
        const res = await axios.get('/list-product');
        state.products = res.data;
    } catch (error) {
        alert('Failed to load products');
    } finally {
        nProgress.done();
    }
}

// Add product
async function addProduct() {

    if (!createProductForm.name || !createProductForm.price || !createProductForm.unit || !createProductForm.category_id) {
        alert('Please fill out all required fields');
        return;
    } else {
        try {
            nProgress.start();

            createProductForm.post('/create-product', {
                onSuccess: () => {
                    alert('Product added successfully');
                    getProducts();
                    toggleAddProductModal();
                    resetForm();
                }
            });
            nProgress.done();
        } catch (error) {
            alert('An error occurred while adding the product');
        }
    }
}

// Update product
async function updateProduct() {
    if (!updateProductForm.name || !updateProductForm.price || !updateProductForm.unit || !updateProductForm.category_id) {
        alert('Please fill out all required fields');
        return;
    } else {
        try {
            nProgress.start();
            updateProductForm.post('/update-product', {
                onSuccess: () => {
                    alert('Product added successfully');
                    getProducts();
                    toggleEditProductModal();
                    resetForm();
                }
            });
            nProgress.done();
        } catch (error) {
            alert('An error occurred while adding the product');
        }
    }
}

// Delete product
async function deleteProduct() {

    nProgress.start();

    const res = await axios.post('/delete-product', { id: deleteProductForm.id, img_url: deleteProductForm.img_url });
    if (res.data === 1) {
        alert('Product deleted successfully');
        getProducts();
    } else {
        alert('Something went wrong');
    }

    nProgress.done();

}

// Modals
function toggleAddProductModal() {
    resetForm();
    state.addProduct = !state.addProduct;
}

function toggleEditProductModal(product) {
    if (product) {
        updateProductForm.id = product.id;
        updateProductForm.name = product.name;
        updateProductForm.price = product.price;
        updateProductForm.unit = product.unit;
        updateProductForm.category_id = product.category_id;
        updateProductForm.img_url = product.img_url;
    } else {
        resetForm();
    }
    state.editProduct = !state.editProduct;
}

// Initialize data
getCategories();
getProducts();
</script>




<template>


    <!-- Main Content -->
    <template v-if="!state.addProduct && !state.editProduct">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10">
            <div class="w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="pl-4 flex flex-row pb-10">
                    <h1 class="text-2xl font-semibold text-purple-500 flex-1">Product</h1>
                    <button @click="toggleAddProductModal"
                        class="py-2 px-4 bg-red-300 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Add
                        Product</button>
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="bg-pink-300/50">
                            <th class="py-4">No</th>
                            <th class="py-4">Name</th>
                            <th class="py-4">Price</th>
                            <th class="py-4">Unit</th>
                            <th class="py-4">Image</th>
                            <th class="py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in state.products" :key="product.id">
                            <td class="py-4 text-center">{{ index + 1 }}</td>
                            <td class="py-4 text-center">{{ product.name }}</td>
                            <td class="py-4 text-center">{{ product.price }}</td>
                            <td class="py-4 text-center">{{ product.unit }}</td>
                            <td class="py-4 text-center">
                                <div class="flex justify-center items-center">
                                    <img :src="`/storage/${product.img_url}`" alt="Product Image"
                                        class="w-16 h-16 object-cover rounded-lg" />
                                </div>
                            </td>
                            <td class="py-4 text-center">
                                <button
                                    @click="updateProductForm.file_path = product.img_url; toggleEditProductModal(product)"
                                    class="bg-red-300 py-2 px-4 mr-4 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Edit</button>
                                <button
                                    @click="deleteProductForm.id = product.id; deleteProductForm.img_url = product.img_url; deleteProduct()"
                                    class="bg-red-300 py-2 px-4 text-purple-500 rounded-xl text-base font-semibold cursor-pointer transition transform hover:-translate-y-1 hover:shadow-lg">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>

    <!-- Add Product Modal -->
    <template v-if="state.addProduct">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10 flex justify-center items-center">
            <div
                class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="text-center mb-12 px-24">
                    <h1 class="text-3xl font-extrabold text-purple-500">Add a New Product</h1>
                </div>
                <i class="fa fa-close absolute top-4 right-4 text-2xl cursor-pointer"
                    @click="toggleAddProductModal"></i>
                <form action="" enctype="multipart/form-data" class="space-y-6">
                    <!-- Category Select -->
                    <div class="relative">
                        <select v-model="createProductForm.category_id"
                            class="w-full py-3 pl-12 pr-4 bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="" disabled selected>Select Category</option>
                            <option v-for="category in state.categories" :value="category.id" :key="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 fas fa-tags"></i>
                    </div>

                    <!-- Product Name -->
                    <div class="relative">
                        <input v-model="createProductForm.name" type="text"
                            class="w-full py-3 pl-12 pr-4 bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Product Name" />
                        <i
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 fas fa-pencil-alt"></i>
                    </div>

                    <!-- Product Price -->
                    <div class="relative">
                        <input v-model="createProductForm.price" type="number"
                            class="w-full py-3 pl-12 pr-4 bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Product Price" />
                        <i
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 fas fa-dollar-sign"></i>
                    </div>

                    <!-- Product Unit -->
                    <div class="relative">
                        <input v-model="createProductForm.unit" type="text"
                            class="w-full py-3 pl-12 pr-4 bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Product Unit" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 fas fa-box"></i>
                    </div>

                    <!-- Preview Image -->
                    <div v-if="url && createProductForm.img_url !== null" class="mt-4 flex justify-center">
                        <img v-if="url" :src="url" class="w-40 mt-4 items-center" />
                    </div>

                    <!-- File Upload -->
                    <div class="relative">
                        <input type="file" id="file-upload" @input="createProductForm.img_url = $event.target.files[0]"
                            @change="previewImage" ref="photo" class="hidden" />
                        <label for="file-upload"
                            class="w-full py-3 pl-12 text-center bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base flex items-center cursor-pointer hover:bg-gray-500 transition">
                            <i class="fas fa-image text-gray-500 mr-4"></i>
                            <span v-if="createProductForm.img_url === null">Upload Product Image</span>
                            <span v-else>Change Image</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button @click.prevent="addProduct()" type="submit"
                        class="w-full py-3 bg-blue-500 text-white rounded-lg text-base font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                        Add Product
                    </button>
                </form>

            </div>
        </div>
    </template>

    <!-- Edit Product Modal -->
    <template v-if="state.editProduct">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10 flex justify-center items-center">
            <div
                class="max-w-[600px] mx-auto bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="text-center mb-12 px-24">
                    <h1 class="text-3xl font-extrabold text-purple-500">Change Product Details</h1>
                </div>
                <i class="fa fa-close absolute top-4 right-4 text-2xl cursor-pointer"
                    @click="toggleEditProductModal"></i>
                <form action="" enctype="multipart/form-data" class="space-y-6">
                    <!-- Category Select -->
                    <div class="relative">
                        <select v-model="updateProductForm.category_id"
                            class="w-full py-3 pl-12 pr-4 bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="" disabled selected>Select Category</option>
                            <option v-for="category in state.categories" :value="category.id" :key="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 fas fa-tags"></i>
                    </div>

                    <!-- Product Name -->
                    <div class="relative">
                        <input v-model="updateProductForm.name" type="text"
                            class="w-full py-3 pl-12 pr-4 bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Product Name" />
                        <i
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 fas fa-pencil-alt"></i>
                    </div>

                    <!-- Product Price -->
                    <div class="relative">
                        <input v-model="updateProductForm.price" type="number"
                            class="w-full py-3 pl-12 pr-4 bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Product Price" />
                        <i
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 fas fa-dollar-sign"></i>
                    </div>

                    <!-- Product Unit -->
                    <div class="relative">
                        <input v-model="updateProductForm.unit" type="text"
                            class="w-full py-3 pl-12 pr-4 bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Product Unit" />
                        <i class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 fas fa-box"></i>
                    </div>

                    <!-- Preview Image -->
                    <div v-if="url" class="mt-4 flex justify-center">
                        <img v-if="url" :src="url" class="w-40 mt-4 items-center" />
                    </div>

                    <div v-else class="mt-4 flex justify-center">
                        <img :src="`/storage/${updateProductForm.img_url}`" class="w-40 mt-4 items-center" />
                    </div>

                    <!-- File Upload -->
                    <div class="relative">
                        <input type="file" id="file-upload" @input="updateProductForm.img_url = $event.target.files[0]"
                            @change="previewImage" ref="photo" class="hidden" />
                        <label for="file-upload"
                            class="w-full py-3 pl-12 text-center bg-gray-700/5 border border-gray-300 rounded-lg text-gray-700 text-base flex items-center cursor-pointer hover:bg-gray-500 transition">
                            <i class="fas fa-image text-gray-500 mr-4"></i>
                            <span v-if="updateProductForm.img_url === null">Upload Product Image</span>
                            <span v-else>Change Image</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button @click.prevent="updateProduct()" type="submit"
                        class="w-full py-3 bg-blue-500 text-white rounded-lg text-base font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                        Update Product
                    </button>
                </form>
            </div>
        </div>
    </template>
</template>


<style scoped></style>
