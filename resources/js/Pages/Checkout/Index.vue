<template>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Checkout</h1>
        <form @submit.prevent="submitCheckout">
            <div class="mb-4">
                <label class="block">Shipping Address</label>
                <input v-model="form.shipping_address" type="text" required class="w-full border p-2" />
            </div>
            <div class="mb-4">
                <label class="block">Billing Address</label>
                <input v-model="form.billing_address" type="text" required class="w-full border p-2" />
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Proceed to Payment</button>
        </form>
    </div>
</template>

<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const form = reactive({
    shipping_address: "",
    billing_address: "",
});

const submitCheckout = async () => {
    try {
        // Create Order
        const response = await axios.post("/checkout", form);
        const orderId = response.data.order_id;

        // Redirect to Stripe Checkout
        const stripeResponse = await axios.post("/stripe/checkout", { order_id: orderId });
        window.location.href = stripeResponse.data.url;
    } catch (error) {
        alert("Error processing checkout");
    }
};
</script>
