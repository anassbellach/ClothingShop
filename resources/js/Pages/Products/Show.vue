<template>
    <div class="flex">

        <div class="w-1/2">
            <img
                :src="product.images.find(img => img.is_default)?.image_url || 'https://via.placeholder.com/300'"
                :alt="product.name"
                class="w-full h-auto"
            />
        </div>

        <div class="w-1/2">

        </div>

    </div>
</template>

<script setup>
defineProps({
    product: Object,
    category: Object,
});
</script>
