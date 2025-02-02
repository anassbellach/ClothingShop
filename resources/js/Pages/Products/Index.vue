<template>
    <div class="">
        <h1 class="text-2xl font-bold my-4">{{ category.name }} Collection</h1>
        <div class="grid grid-cols-1 md:grid-cols-4">
            <Link
                v-for="product in products"
                :key="product.id"
                :href="route('products.show', { category: category.slug, product: product.sku })"
                class="block"
            >
                <!-- Image Container -->
                <div class="relative group cursor-pointer">
                    <img
                        :src="product.images.find(img => img.is_default)?.image_url || 'https://via.placeholder.com/300'"
                        :alt="product.name"
                        class="w-full"
                    />

                    <!-- Heart Icon -->
                    <div class="hidden group-hover:flex absolute bottom-4 right-4">
                        <i class="fa-regular fa-heart text-gray-600"></i>
                    </div>
                </div>

                <div class="flex items-center justify-between align-center h-12 px-6 text-[0.5625rem]">

                    <h2 class="font-supreme text-gray-600 uppercase">{{ product.name }}</h2>

                    <div class="flex gap-2">
                        <span v-if="product.sale_price" class="font-supreme">{{ product.sale_price }} €</span>
                        <span v-if="product.sale_price" class="font-supreme text-gray-400 line-through">{{ product.price }} €</span>
                        <span v-if="product.sale_price" class="font-supreme text-[#FF0000]">
                            -{{ Math.round(((product.price - product.sale_price) / product.price) * 100) }}%
                        </span>
                        <span v-else class="font-supreme">{{ product.price }} €</span>
                    </div>

                </div>

            </Link>
        </div>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    products: Array,
    category: Object,
});
</script>

<script>
    export default {
        layout: null,
    }
</script>
