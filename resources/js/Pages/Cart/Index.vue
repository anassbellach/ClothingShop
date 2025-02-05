<template>
    <div class="container mx-auto mt-24">
        <h1 class="text-3xl font-bold mt-10 mb-4 uppercase">Uw Winkelwagen ({{ cart.items.length }} items)</h1>

        <div class="flex h-screen max-h-screen">
            <!-- Left: Cart Items -->
            <div class="w-1/2 overflow-auto">
                <div v-if="cart.items.length > 0">
                    <div v-for="item in cart.items" :key="item.id" class="flex items-start border-b">
                        <img
                            v-if="item.product.images && item.product.images.length > 0"
                            :src="item.product.images.find(img => img.is_default)?.image_url || 'https://via.placeholder.com/300'"
                            :alt="item.product.name"
                            class="w-1/3"
                        />
                        <!-- Product Details -->
                        <div class="p-4 flex-1 flex flex-col justify-center">
                            <h2 class="text-lg font-semibold uppercase">{{ item.product.name }}</h2>

                            <!-- Pricing -->
                            <div class="mt-1 text-lg">
                                <!--                                <span class="font-bold">€{{ item.product.price.toFixed(2) }}</span>-->
                                <span v-if="item.product.original_price" class="line-through text-gray-400 ml-2">
                                    €{{ item.product.original_price.toFixed(2) }}
                                </span>
                                <span v-if="item.product.original_price" class="text-red-500 ml-2">
                                    -{{ Math.round((1 - (item.product.price / item.product.original_price)) * 100) }}%
                                </span>
                            </div>

                            <p class="text-gray-600 mt-2">KLEUR: {{ item.product.color || 'Onbekend' }}</p>
                            <p class="text-gray-600">MAAT: {{ item.size }}</p>
                            <p class="text-gray-600">AANTAL: {{ item.quantity }}</p>

                            <div class="flex justify-between">

                                <button @click="editItem(item)" class="mt-2 text-sm uppercase underline">
                                    Bewerken
                                </button>

                                <Link
                                    :href="route('cart.destroy', { item: item.id })"
                                    method="delete"
                                    as="button"
                                    class="cursor-pointer"
                                >
                                    <i class="fa-solid fa-x"></i>
                                </Link>


                            </div>

                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-gray-600">Uw winkelwagen is leeg.</p>
                </div>
            </div>

            <!-- Right: Cart Summary -->
            <div class="w-1/2 border-l pl-6 bg-gray-100 p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold mb-4">Overzicht</h2>

                    <div class="flex justify-between text-gray-600 text-lg">
                        <span>Subtotaal ({{ cart.items.length }} items)</span>
                        <span>€{{ subtotal }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 text-lg mt-2">
                        <span>Standaard Levering</span>
                        <span class="text-green-500">Gratis</span>
                    </div>

                    <div class="flex justify-between text-black font-bold text-xl mt-4">
                        <span>Totaal van de bestelling</span>
                        <span>€{{ total }}</span>
                    </div>
                </div>

                <button @click="proceedToCheckout"
                        class="w-full bg-black text-white text-lg font-semibold py-3 uppercase">
                    De Bestelling Voltooien
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed} from 'vue';
import {router, Link} from '@inertiajs/vue3';

const props = defineProps({
    cart: Object,
});

const subtotal = computed(() => {
    return props.cart.items.reduce((sum, item) => sum + item.product.price * item.quantity, 0);
});

const shipping = computed(() => 0); // Free shipping

const total = computed(() => {
    return subtotal.value + shipping.value;
});

const updateQuantity = (item) => {
    router.put(`/cart/update/${item.id}`, {quantity: item.quantity});
};

const removeItem = (item) => {
    router.delete(`/cart/remove/${item.id}`);
};

const proceedToCheckout = () => {
    router.post('/checkout/start', {}, {
        onSuccess: (response) => {
            if (response.props.checkout_url) {
                window.location.href = response.props.checkout_url;
            } else {
                router.visit('/checkout');
            }
        }
    });
};

</script>
