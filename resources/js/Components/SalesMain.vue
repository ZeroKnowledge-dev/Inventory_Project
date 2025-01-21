<script setup>
import { reactive, watch } from 'vue';
import axios from 'axios';

// Reactive state for the application
const state = reactive({
    id: '',
    name: '',
    email: '',
    mobile: '',
    customer_id: '',
    customer_name: '',
    customer_email: '',
    currentDate: new Date().toISOString().split('T')[0],
    products: [],
    customers: [],
    invoiceItems: [],
    productFormWindow: false,
});

const calculation = reactive({
    total: 0,
    payable: 0,
    vat: 0,
    discount: 0,
});

const productForm = reactive({
    id: '',
    name: '',
    price: 0,
    unit: 1, // Default to 1 for valid multiplication
});

// Fetch customers from the server
async function getCustomers() {
    try {
        const res = await axios.get('/list-customer');
        state.customers = res.data;
    } catch (error) {
        console.error('Error fetching customers:', error);
    }
}

// Fetch products from the server
async function getProducts() {
    try {
        const res = await axios.get('/list-product');
        state.products = res.data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }
}

// Toggle the Add Product Modal
function toggleAddProductModal(product = {}) {
    state.productFormWindow = !state.productFormWindow;
    productForm.id = product.id || '';
    productForm.name = product.name || '';
    productForm.price = product.price || 0;
    productForm.unit = 1; // Reset unit on modal toggle
}

// Select a customer
function selectCustomer(customer) {
    state.customer_id = customer.id;
    state.customer_name = customer.name;
    state.customer_email = customer.email;
}

// Add a product to the invoice
function addProduct() {
    if (!productForm.name || productForm.price <= 0 || productForm.unit <= 0) {
        alert('Please provide valid product details.');
        return;
    }

    state.invoiceItems.push({
        product_id: productForm.id,
        product_name: productForm.name,
        qty: parseInt(productForm.unit, 10),
        sale_price: parseFloat(productForm.price),
    });

    state.productFormWindow = false;
    calculateTotal();
}

// Calculate the totals for the invoice
function calculateTotal() {
    calculation.total = state.invoiceItems.reduce(
        (sum, item) => sum + item.qty * item.sale_price,
        0
    );
    calculation.vat = calculation.total * 0.15; // Example VAT rate (15%)
    calculation.payable = calculation.total + calculation.vat - calculation.discount;
}

// Remove a product from the invoice
function removeProduct(index) {
    state.invoiceItems.splice(index, 1);
    calculateTotal();
}

// Create an invoice
async function createInvoice() {
    if (!state.customer_id) {
        alert('Customer Required!');
        return;
    }

    if (!state.invoiceItems.length) {
        alert('Product Required!');
        return;
    }

    const invoiceData = {
        total: calculation.total,
        discount: calculation.discount,
        vat: calculation.vat,
        payable: calculation.payable,
        customer_id: state.customer_id,
        products: state.invoiceItems,
    };

    try {
        const res = await axios.post('/invoice-create', invoiceData);
        alert(res.data === 1 ? 'Invoice Created' : 'Something Went Wrong');
        state.customer_id = '';
        state.customer_name = '';
        state.customer_email = '';
        state.invoiceItems = [];
        calculateTotal();
    } catch (error) {
        console.error('Error creating invoice:', error);
        alert('Something Went Wrong');
    }
}

// Watch for changes in invoice items and recalculate totals
watch(() => state.invoiceItems, calculateTotal, { deep: true });

// Initialize data on component load
getCustomers();
getProducts();
</script>

<template>
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Invoice Section -->
            <div class="bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-6 shadow-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-semibold text-purple-500">BILLED TO</h2>
                        <p class="text-sm">Name: <span>{{ state.customer_name }}</span></p>
                        <p class="text-sm">Email: <span>{{ state.customer_email }}</span></p>
                        <p class="text-sm">User ID: <span>{{ state.customer_id }}</span></p>
                    </div>
                    <div>
                        <img src="@/Logo/41929037.jpg" alt="Logo" class="w-16">
                        <p class="text-md font-semibold text-purple-500">Invoice</p>
                        <p class="text-sm">Date: {{ state.currentDate }}</p>
                    </div>
                </div>
                <hr class="my-4 border-pink-300/30">
                <table class="w-full text-sm text-center">
                    <thead class="bg-pink-300/50">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in state.invoiceItems" :key="index">
                            <td>{{ item.product_name }}</td>
                            <td>{{ item.sale_price }}</td>
                            <td>{{ item.qty }}</td>
                            <td>{{ (item.sale_price * item.qty).toFixed(2) }}</td>
                            <td><button @click="removeProduct(index)" class="text-red-500">X</button></td>
                        </tr>
                    </tbody>
                </table>
                <hr class="my-4 border-pink-300/30">
                <div>
                    <p class="font-semibold text-purple-500">TOTAL: ${{ calculation.total.toFixed(2) }}</p>
                    <p class="font-semibold text-purple-500">PAYABLE: ${{ calculation.payable.toFixed(2) }}</p>
                    <p class="font-semibold text-purple-500">VAT: ${{ calculation.vat.toFixed(2) }}</p>
                    <p class="font-semibold text-purple-500">Discount: ${{ calculation.discount.toFixed(2) }}</p>
                    <div class="mt-2">
                        <label for="discountP" class="text-xs">Discount(%):</label>
                        <input v-model.number="calculation.discount" @change="calculateTotal" name="discountP"
                            class="w-24 p-1 border border-gray-300 rounded-md" type="number" min="0" />
                    </div>
                    <button @click="createInvoice"
                        class="mt-4 w-full py-2 bg-red-300 text-purple-500 rounded-xl hover:-translate-y-1 hover:shadow-lg">
                        Confirm
                    </button>
                </div>
            </div>

            <!-- Product Section -->
            <div class="bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-6 shadow-xl">
                <h2 class="text-lg font-semibold text-purple-500 mb-4">Products</h2>
                <table class="w-full text-sm text-center">
                    <thead class="bg-pink-300/50">
                        <tr>
                            <th>Product</th>
                            <th>Pick</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in state.products" :key="index">
                            <td>{{ product.name }}</td>
                            <td>
                                <button @click="toggleAddProductModal(product)" class="text-green-500">
                                    Add
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Add Product Modal -->
            <template v-if="state.productFormWindow">
                <div class="flex justify-center items-center fixed inset-0 bg-black/50 z-10">
                    <div class="max-w-md w-full bg-pink-300/50 p-6 rounded-xl shadow-xl">
                        <h3 class="text-xl font-bold text-purple-500 mb-4">Add Product</h3>
                        <form @submit.prevent="addProduct">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input disabled v-model="productForm.name"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-purple-500"
                                    type="text" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Price</label>
                                <input disabled v-model="productForm.price"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-purple-500"
                                    type="number" />
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input v-model.number="productForm.unit"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-purple-500"
                                    type="number" min="1" />
                            </div>
                            <button class="w-full bg-red-300 text-purple-500 py-2 rounded-md hover:shadow-lg">
                                Add Product
                            </button>
                        </form>
                        <button @click="toggleAddProductModal"
                            class="mt-4 w-full py-2 bg-gray-300 text-gray-700 rounded-md hover:shadow-lg">
                            Cancel
                        </button>
                    </div>
                </div>
            </template>

            <!-- Customer Section -->
            <div class="bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-6 shadow-xl">
                <h2 class="text-lg font-semibold text-purple-500 mb-4">Customers</h2>
                <table class="w-full text-sm text-center">
                    <thead class="bg-pink-300/50">
                        <tr>
                            <th>Customer</th>
                            <th>Pick</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in state.customers" :key="customer.id">
                            <td>{{ customer.name }}</td>
                            <td>
                                <button @click="selectCustomer(customer)" class="text-green-500">
                                    Select
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Optional: Add scoped styles for customizations */
</style>
