<template>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Guest Checkout</h1>
        <form @submit.prevent="submitGuestCheckout">
            <div class="mb-4">
                <label class="block">Email Address</label>
                <input v-model="form.email" type="email" required class="w-full border p-2" />
            </div>
            <div class="mb-4">
                <label class="block">Shipping Address</label>
                <input v-model="form.shipping_address" type="text" required class="w-full border p-2" />
            </div>
            <div class="mb-4">
                <label class="block">Billing Address</label>
                <input v-model="form.billing_address" type="text" required class="w-full border p-2" />
            </div>
            <button type="submit" class="bg-black text-white px-4 py-2">Proceed to Payment</button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3"; // Import useForm from Inertia
import { ref } from "vue";

// Initialize form with Inertia's useForm hook
const form = useForm({
    email: '',
    shipping_address: '',
    billing_address: '',
});

// Submit function to send the data to the backend
const submitGuestCheckout = () => {
    form.post(route('checkout.store'), {
        onFinish: () => {
            // Handle the completion of the post request
            if (form.errors) {
                console.error("Form errors", form.errors);
            } else {
                window.location.href = form.data.checkout_url; // You can replace this with the actual checkout URL
            }
        },
    });
};
</script>

<script>
export default {
    layout: null,
};
</script>
