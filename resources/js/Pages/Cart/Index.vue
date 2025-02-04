<template>
    <div class="container mx-auto ">
        <h1 class="text-2xl font-bold mt-20">Shopping Cart</h1>
        <div class="flex">
            <!-- Left: Cart Items -->
            <div class="w-1/2">
                <div v-if="cart && cart.items && cart.items.length > 0">
                    <div v-for="item in cart.items" :key="item.id" class="border p-4 mb-4">
                        <div class="flex items-center">
                            <img
                                v-if="item.product && item.product.images && item.product.images.length > 0"
                                :src="item.product.images.find(img => img.is_default)?.image_url || 'https://via.placeholder.com/300'"
                                :alt="item.product.name"
                                class="w-24 h-24 object-cover"
                            />
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold">{{ item.product.name }}</h2>
                                <p class="text-gray-600">Size: {{ item.size }}</p>
                                <p class="text-gray-600">€{{ item.product.price }} x {{ item.quantity }}</p>
                                <p class="text-gray-600">Subtotal: €{{ item.product.price * item.quantity }}</p>
                            </div>
                        </div>
                        <div class="mt-4 flex space-x-4">
                            <input type="number" v-model="item.quantity" min="1" @change="updateQuantity(item)" class="p-2 border rounded" />
                            <button @click="removeItem(item)" class="text-red-500 hover:text-red-700">Remove</button>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-gray-600">Your cart is empty.</p>
                </div>
            </div>

            <!-- Right: Cart Summary -->
            <div class="w-1/2 border-2 border-l-indigo-500">
                <div v-if="cart && cart.items && cart.items.length > 0" class="border p-4">
                    <h2 class="text-xl font-bold">Cart Summary</h2>
                    <p class="text-gray-600">Total Items: {{ cart.items.length }}</p>
                    <p class="text-gray-600">Subtotal: €{{ subtotal }}</p>
                    <p class="text-gray-600">Shipping: €{{ shipping }}</p>
                    <p class="text-gray-600">Total: €{{ total }}</p>
                    <button @click="proceedToCheckout" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    cart: Object,
});

// Ensure cart is defined before calculating subtotal
const subtotal = computed(() => {
    if (!props.cart || !props.cart.items) return 0;
    return props.cart.items.reduce((sum, item) => sum + item.product.price * item.quantity, 0);
});

const shipping = computed(() => {
    return 5.99; // Example shipping cost
});

const total = computed(() => {
    return subtotal.value + shipping.value;
});

const updateQuantity = (item) => {
    router.put(`/cart/update/${item.id}`, {
        quantity: item.quantity,
    });
};

const removeItem = (item) => {
    router.delete(`/cart/remove/${item.id}`);
};

const proceedToCheckout = () => {
    router.visit('/checkout');
};
</script>
