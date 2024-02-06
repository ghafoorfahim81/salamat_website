<template>
    <li class="m-1 sm:py-4 bg-white border-2 rounded-md custom-width mb-2 list-none hover:border-blue-500">
        <div class="flex items-center">
            <div class="flex-1 min-w-0 ms-4">
                <p class="text-xs font-medium text-gray-900 truncate dark:text-white hover:cursor-pointer" @click="$emit('click')">
                    {{ label }}
                </p>
            </div>
            <div class="p-1 inline-flex items-center text-sm font-semibold text-gray-900 dark:text-white">
                {{ value }}
            </div>
        </div>
    </li>
</template>

<script>
export default {
    props:['label','value'],
    methods: {
        search() {
            // alert('Searching');
        },
    },
};
</script>

<style scoped>
.custom-width {
    min-width: 300px; /* Adjust the width as needed */

}

</style>

