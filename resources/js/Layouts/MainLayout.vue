<template>
    <div class="bg-[#FCFCFC] flex flex-col min-h-screen relative overflow-hidden">

        <navbar class="flex fixed h-24 w-full z-50"></navbar>

        <!--Content-->
        <div class="flex-grow relative">
            <slot></slot>
        </div>

        <!-- Footer -->
        <footer class="pb-2">
            <p class="text-center">© ClothingShop B.V. 2025</p>
        </footer>
    </div>
</template>

<script setup>
import Navbar from "@/Components/Navbar.vue";

</script>
