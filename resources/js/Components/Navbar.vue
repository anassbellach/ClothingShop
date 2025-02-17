<template>
    <div class="p-3 flex justify-between">

        <!-- Logo -->
        <img class="filter invert" src="https://nld.sandro-paris.com/on/demandware.static/Sites-Sandro-NL-Site/-/default/dw8ea9ecc4/images/brand-logo-nofill.svg#Calque_1" alt="Logo">

        <!-- Navigation -->
        <div class="flex justify-between">

            <!-- Main nav buttons -->
            <div class="flex space-x-14 w-96 px-8 text-white font-bold">
                <Link href="/women">DAMES</Link>
                <Link href="/men">HEREN</Link>
                <div>ABOUT US</div>
            </div>

            <!-- User nav buttons -->
            <div class="flex space-x-6 w-60 px-8 text-white">
                <!-- User Icon (Click to Open Sidebar) -->
                <div @click="toggleSidebar" class="cursor-pointer">
                    <i class="fa-regular fa-user"></i>
                </div>

                <div>
                    <i class="fa-regular fa-heart"></i>
                </div>

                <a :href="route('cart.index')" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 6h15l-1.68 8.4a2 2 0 0 1-2 1.6H8.5"/>
                        <circle cx="9" cy="19" r="1"/>
                        <circle cx="17" cy="19" r="1"/>
                        <path d="M6 6l-2-2"/>
                    </svg>
                </a>
            </div>

        </div>

        <!-- Auth Sidebar -->
        <AuthSidebar ref="authSidebar" />
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import AuthSidebar from "@/Components/AuthSidebar.vue";

const authSidebar = ref(null);

const toggleSidebar = () => {
    if (authSidebar.value) {
        authSidebar.value.openSidebar();
    }
};
</script>
