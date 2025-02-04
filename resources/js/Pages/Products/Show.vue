<template>
    <div class="flex">
        <div class="w-1/2">
            <img
                :src="product.images.find(img => img.is_default)?.image_url || 'https://via.placeholder.com/300'"
                :alt="product.name"
                class="w-full h-auto"
            />
        </div>

        <!-- Right: Product Details -->
        <div class="w-1/2 flex flex-col items-start text-left mt-32">
            <div class="w-3/4 mx-auto">
                <!-- Product Title & Wishlist -->
                <div class="flex justify-between items-center w-full">
                    <h1 class="font-supreme text-xl text-gray-600 font-bold uppercase">{{ product.name }}</h1>
                    <i class="fa-regular fa-heart text-xl cursor-pointer"></i>
                </div>

                <!-- Pricing Section -->
                <div class="flex gap-3 items-center mt-3">
                    <span v-if="product.sale_price" class="font-supreme">{{ product.sale_price }} €</span>
                    <span v-if="product.sale_price" class="font-supreme text-gray-400 line-through">{{ product.price }} €</span>
                    <span v-if="product.sale_price" class="font-supreme text-[#FF0000]">
                        -{{ Math.round(((product.price - product.sale_price) / product.price) * 100) }}%
                    </span>
                    <span v-else class="font-supreme">{{ product.price }} €</span>
                </div>

                <!-- Size Dropdown & Add to Cart -->
                <form @submit.prevent="addToCart" class="mt-6 w-full">
                    <div class="mb-4">
                        <label for="size" class="block text-sm font-medium text-gray-700">Maat</label>

                        <!-- Custom Dropdown -->
                        <div class="relative w-full">
                            <div
                                class="mt-1 w-full p-3 border border-black flex justify-between items-center cursor-pointer"
                                @click="toggleDropdown"
                            >
                                <span v-if="selectedSize">{{ selectedSize }}</span>
                                <span v-else class="uppercase">Maat</span>
                                <span class="text-sm">{{ dropdownOpen ? '▲' : '▼' }}</span>
                            </div>

                            <!-- Dropdown options -->
                            <div v-if="dropdownOpen" class="absolute w-full bg-white border border-black shadow-lg z-10">
                                <div
                                    v-for="size in sizes"
                                    :key="size"
                                    class="p-2 hover:bg-gray-100 cursor-pointer"
                                    @click="selectSize(size)"
                                >
                                    {{ size }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="submit" class="w-full bg-black text-white px-4 py-3 uppercase font-medium">
                        Toevoegen
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

// Define the props to receive product and category
const props = defineProps({
    product: Object,
    category: Object,
});

const sizes = ["S", "M", "L", "XL"]; // Example sizes
const selectedSize = ref("");
const dropdownOpen = ref(false);

// Method to toggle the size dropdown
const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

// Method to select the size
const selectSize = (size) => {
    selectedSize.value = size;
    dropdownOpen.value = false;
};

// Initialize the form for Inertia.js
const form = useForm({
    product_id: props.product.id, // Pre-set product_id
    quantity: 1,                  // Default quantity
    size: "",                     // Size will be selected by the user
});

// Method to add product to the cart
const addToCart = () => {
    // Validate if size is selected
    if (!selectedSize.value) {
        alert("Selecteer een maat voordat je toevoegt aan de winkelwagen.");
        return;
    }

    form.size = selectedSize.value;  // Set the selected size
    form.post(route("cart.store"));   // Submit the form
};
</script>


