<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100 p-6">
        <div class="bg-white shadow-lg rounded-2xl p-8 max-w-lg text-center">
            <h1 class="text-2xl font-bold text-green-600 mb-4">Payment Successful! 🎉</h1>
            <p class="text-gray-700 mb-4">
                Thank you for your purchase! Your order has been placed successfully.
            </p>

            <div v-if="order" class="bg-gray-50 p-4 rounded-lg border mb-4">
                <p class="text-lg font-semibold">Order Details:</p>
                <p><span class="font-medium">Order ID:</span> {{ order.id }}</p>
                <p><span class="font-medium">Total Amount:</span> €{{ order.total_amount }}</p>
            </div>

            <Link href="/" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                Go to Homepage
            </Link>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

// Get order details from the backend
const page = usePage();
const order = computed(() => page.props.order);
</script>
