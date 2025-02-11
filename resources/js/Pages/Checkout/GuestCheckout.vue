<template>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Guest Checkout</h1>

        <!-- Display error if it exists -->
        <div v-if="error" class="text-red-500 mb-4">
            {{ error }}
        </div>

        <form @submit.prevent="submitCheckout">
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
import { reactive, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";

const form = reactive({
    email: "",
    shipping_address: "",
    billing_address: "",
});

const error = ref("");

const submitCheckout = async () => {
    try {
        console.log("Sending checkout data:", form);

        const response = await axios.post("/checkout", form, {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            }
        });

        console.log("Response:", response.data);

        if (response.data.checkout_url) {
            window.location.href = response.data.checkout_url;
        } else {
            error.value = "Something went wrong. Please try again.";
        }
    } catch (err) {
        console.error("Checkout error:", err.response ? err.response.data : err);
        error.value = err.response?.data?.error || "Error processing checkout. Please try again.";
    }
};

</script>
