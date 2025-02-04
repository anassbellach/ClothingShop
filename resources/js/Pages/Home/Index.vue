<template>
    <div>
        <!--Dames and Heren-->
        <div>
            <div class="flex justify-between">

                <!-- Women's Section -->
                <div class="relative w-1/2">
                    <img
                        class="w-full h-auto"
                        src="https://edge.disstg.commercecloud.salesforce.com/dw/image/v2/BCMW_STG/on/demandware.static/-/Library-Sites-Sandro-Shared/default/dw6e1b992b/Homepage/2024/Soldes%203DEM/DEM3_NORD_SLIDER_F_DESK.jpg"
                        alt="image women"
                    >
                    <Link
                        href="/women"
                        class="absolute font-semibold left-5 top-[60%] translate-y-1/2 border border-white text-white px-6 py-1.5 uppercase text-sm tracking-wide hover:bg-white hover:text-black transition"
                    >
                        Dames
                    </Link>
                </div>

                <!-- Men's Section -->
                <div class="relative w-1/2">
                    <img
                        class="w-full h-auto"
                        src="https://edge.disstg.commercecloud.salesforce.com/dw/image/v2/BCMW_STG/on/demandware.static/-/Library-Sites-Sandro-Shared/default/dw5c69698d/Homepage/2024/Soldes%203DEM/DEM3_NORD_SLIDER_H_DESK.jpg"
                        alt="image men"
                    >
                    <Link
                        href="/men"
                        class="absolute font-semibold left-5 top-[60%] translate-y-1/2 border border-white text-white px-6 py-1.5 uppercase text-sm tracking-wide hover:bg-white hover:text-black transition"
                    >
                        Heren
                    </Link>
                </div>

            </div>
        </div>

        <!-- Accessoires -->
        <div class="relative">
            <img
                class="w-full"
                src="https://edge.disstg.commercecloud.salesforce.com/dw/image/v2/BCMW_STG/on/demandware.static/-/Library-Sites-Sandro-Shared/default/dw9246f78a/Homepage/2024/Soldes%203DEM/DEM3_NORD_BLOC_ACCESS_F_DESK_V2%20(1).jpg"
                alt="image women"
            >

            <!-- Button Container (Vertically Centered, Left-Aligned) -->
            <div class="absolute flex flex-col space-y-4 top-1/2 left-5 w-24">

                <div class="font-bold text-2xl text-white uppercase">
                    Accessoires tot -50%
                </div>

                <!-- Adjusted Buttons -->
                <Link
                    href=""
                    class="font-semibold border border-white text-white px-6 py-2 uppercase text-sm tracking-wide hover:bg-white hover:text-black transition"
                >
                    Dames
                </Link>

                <Link
                    href=""
                    class="font-semibold border border-white text-white px-6 py-2 uppercase text-sm tracking-wide hover:bg-white hover:text-black transition"
                >
                    Heren
                </Link>
            </div>
        </div>


        <!--Nieuwe collectie-->
        <div class="relative">
            <img
                class=""
                src="https://edge.disstg.commercecloud.salesforce.com/dw/image/v2/BCMW_STG/on/demandware.static/-/Library-Sites-Sandro-Shared/default/dwea152b87/Homepage/2024/SOLDES%201DEM%20FW24/DEM1_SUD_COLLECTION_ETE_BLOC_DESK.jpg"
                alt="image men">

            <!-- Button Container (Vertically Centered, Left-Aligned) -->
            <div class="absolute flex flex-col space-y-4 top-1/2 left-5 w-24">

                <div class="font-bold text-2xl text-white uppercase">
                    Nieuwe collectie
                </div>

                <!-- Adjusted Buttons -->
                <Link
                    href=""
                    class="font-semibold border border-white text-white px-6 py-2 uppercase text-sm tracking-wide hover:bg-white hover:text-black transition"
                >
                    Dames
                </Link>

                <Link
                    href=""
                    class="font-semibold border border-white text-white px-6 py-2 uppercase text-sm tracking-wide hover:bg-white hover:text-black transition"
                >
                    Heren
                </Link>
            </div>

        </div>

    </div>
</template>

<script setup>
import {Link, router, usePage} from "@inertiajs/vue3";
</script>
