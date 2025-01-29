<script setup>
import { reactive } from 'vue';
import axios from 'axios';
import nProgress from 'nprogress';

// Utility function for date formatting
function formatDate(dateString) {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    }).format(date);
}

const state = reactive({
    selectedInvoiceIndex: null,
    invoices: [],
    invoiceProducts: [],
    isInvoiceDetailsVisible: false,
});

async function getInvoices() {
    try {
        nProgress.start();
        const res = await axios.get('/invoice-select');
        state.invoices = res.data;
        nProgress.done();
    } catch (error) {
        console.error('Error fetching invoices:', error);
        nProgress.done();
    }
}

async function loadInvoiceDetails(index) {
    try {
        state.selectedInvoiceIndex = index;
        state.isInvoiceDetailsVisible = true;
        nProgress.start();
        const selectedInvoice = state.invoices[index];
        const res = await axios.post('/invoice-details', {
            cus_id: selectedInvoice.customer_id,
            inv_id: selectedInvoice.id,
        });
        state.invoiceProducts = res.data;
        nProgress.done();
    } catch (error) {
        console.error('Error fetching invoice details:', error);
        nProgress.done();
    }
}

async function invoiceDelete(index) {
    try {
        state.selectedInvoiceIndex = index;
        nProgress.start();
        const selectedInvoice = state.invoices[index];
        const res = await axios.post('/invoice-delete', {
            inv_id: selectedInvoice.id,
        });
        nProgress.done();
        if (res.data === 1) {
            alert("Request completed")
            getInvoices();
        }
        else {
            alert("Request fail!")
        }
    } catch (error) {
        console.error('Error fetching invoice details:', error);
        nProgress.done();
    }
}

function hideInvoiceDetails() {
    state.isInvoiceDetailsVisible = false;
    state.selectedInvoiceIndex = null;
    state.invoiceProducts = [];
}

function printInvoice() {
    const printContent = document.querySelector('.invoice'); // Target the invoice section

    if (printContent) {
        const printWindow = window.open('', '_blank'); // Open a new blank window
        if (printWindow) {
            printWindow.document.write(`
                <html>
                <head>
                    <title>Invoice</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-bottom: 20px;
                        }
                        th, td {
                            padding: 8px 12px;
                            border: 1px solid #ddd;
                            text-align: left;
                        }
                        th {
                            background-color: #f4f4f4;
                        }
                        .text-right {
                            text-align: right;
                        }
                        .invoice-header {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 20px;
                        }
                        .logo {
                            width: 40px;
                        }
                        .invoice-header h1 {
                            margin: 0;
                        }
                        .invoice-summary {
                            display: flex;
                            justify-content: flex-end;
                            margin-top: 20px;
                        }
                        .invoice-summary div {
                            text-align: right;
                            margin-left: 20px;
                        }

                        hr {
                            border: none;
                            border-top: 1px solid #ddd;
                            margin: 20px 0;
                        }
                    </style>
                </head>
                <body>
                    ${printContent.outerHTML} <!-- Copy the invoice content -->
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        } else {
            console.error('Failed to open the print window.');
        }
    } else {
        console.error('No content found to print.');
    }
}



// Initialize data
getInvoices();
</script>

<template>
    <!-- Main Content -->
    <template v-if="!state.isInvoiceDetailsVisible">
        <div class="flex-1 p-8 bg-transparent overflow-hidden backdrop-blur-xl z-10">
            <div class="w-full bg-pink-300/50 backdrop-blur-xl border border-pink-300/10 rounded-3xl p-8 shadow-xl">
                <div class="pl-4 flex flex-row pb-10">
                    <h1 class="text-2xl font-semibold text-purple-500 flex-1">Invoices</h1>
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="bg-pink-300/50">
                            <th class="py-4">No</th>
                            <th class="py-4">Name</th>
                            <th class="py-4">Phone</th>
                            <th class="py-4">Total</th>
                            <th class="py-4">Vat</th>
                            <th class="py-4">Discount</th>
                            <th class="py-4">Payable</th>
                            <th class="py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(invoice, index) in state.invoices" :key="index">
                            <td class="py-4 text-center">{{ index + 1 }}</td>
                            <td class="py-4 text-center">{{ invoice.customer.name }}</td>
                            <td class="py-4 text-center">{{ invoice.customer.mobile }}</td>
                            <td class="py-4 text-center">{{ invoice.total }}</td>
                            <td class="py-4 text-center">{{ invoice.vat }}</td>
                            <td class="py-4 text-center">{{ invoice.discount }}</td>
                            <td class="py-4 text-center">{{ invoice.payable }}</td>
                            <td class="py-4 text-center">
                                <button @click="loadInvoiceDetails(index)" class="action-btn">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button @click="invoiceDelete(index)" class="action-btn">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>

    <template v-else>
        <div class="flex-1 p-8 bg-transparent flex justify-center items-center relative">
            <!-- Close Icon -->
            <div class="absolute top-6 right-16 flex justify-end z-10">
                <button @click="printInvoice"
                    class="bg-purple-600 text-white items-center mr-4 py-2 px-6 rounded-lg font-semibold shadow-lg hover:bg-purple-700 hover:shadow-xl transition-all duration-300">
                    <i class="fa fa-print mr-2"></i> Print
                </button>
                <p @click="hideInvoiceDetails" class=" bg-purple-600 text-white items-center py-2 px-6 rounded-lg font-semibold shadow-lg
                    hover:bg-purple-700 hover:shadow-xl hover:cursor-pointer transition-all duration-300">
                    <i class="fa fa-close mr-2"></i>Close
                </p>
            </div>

            <!-- Invoice Details Section -->
            <div
                class="bg-white/70 backdrop-blur-xl shadow-2xl border border-gray-200 rounded-3xl p-8 w-full max-w-4xl invoice">

                <!-- Header Section -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-3">Billed To</h2>
                        <p class="text-sm text-gray-600">Name: <span class="font-medium">{{
                            state.invoices[state.selectedInvoiceIndex].customer.name }}</span></p>
                        <p class="text-sm text-gray-600">Email: <span class="font-medium">{{
                            state.invoices[state.selectedInvoiceIndex].customer.email }}</span></p>
                        <p class="text-sm text-gray-600">User ID: <span class="font-medium">{{
                            state.invoices[state.selectedInvoiceIndex].customer.id }}</span></p>
                    </div>
                    <div class="text-right">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f1/Vue.png" alt="Logo"
                            class="w-24 mb-2 logo">
                        <p class="text-sm text-gray-600">Date: {{
                            formatDate(state.invoices[state.selectedInvoiceIndex].customer.updated_at) }}</p>
                    </div>
                </div>

                <!-- Separator -->
                <hr class="border-gray-300 my-6">

                <!-- Products Table -->
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-purple-100 text-gray-700">
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Price</th>
                            <th class="py-3 px-4">Quantity</th>
                            <th class="py-3 px-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in state.invoiceProducts.product" :key="index"
                            class="hover:bg-purple-50 transition">
                            <td class="py-3 px-4">{{ item.product.name }}</td>
                            <td class="py-3 px-4">${{ item.product.price }}</td>
                            <td class="py-3 px-4">{{ item.qty }}</td>
                            <td class="py-3 px-4">${{ (item.product.price * item.qty) }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Separator -->
                <hr class="border-gray-300 my-6">

                <!-- Summary Section -->
                <div class="flex justify-end flex-col space-x-12 text-right">

                    <p class="text-gray-600 font-medium">Subtotal: ${{ state.invoices[state.selectedInvoiceIndex].total
                        }}</p>
                    <p class="text-gray-600 font-medium">VAT: ${{ state.invoices[state.selectedInvoiceIndex].vat }}</p>
                    <p class="text-gray-600 font-medium">Discount: -${{
                        state.invoices[state.selectedInvoiceIndex].discount }}</p>
                    <p class="text-gray-600 font-medium">Total: ${{
                        state.invoices[state.selectedInvoiceIndex].payable }}</p>

                </div>
            </div>
        </div>
    </template>


</template>

<style scoped>
.action-btn {
    background: #f3c5d6;
    padding: 0.5rem 1rem;
    margin-right: 0.5rem;
    color: #6b21a8;
    border-radius: 0.75rem;
    font-weight: 600;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.action-btn:hover {
    transform: translateY(-0.25rem);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}
</style>
