<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';

defineProps({
    paginator: Object
});


</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div v-for="product in paginator.data">
                            <div class="flex flex-wrap items-center mt-6">
                                <div class="flex-1 font-medium">{{ product.title }}</div>
                                <div>{{ product.price }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
