<template>
    <button @click="$emit('click')" type="button"
            class="text-white bg-teal-500 hover:bg-teal-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6M3 9a9 9 0 1118 0 9 9 0 01-18 0z"></path>
        </svg>
        {{ btn_name }}
    </button>
</template>

<script>
export default {
    props:['btn_name'],
    methods: {
        search() {
            // alert('Searching');
        },
    },
};
</script>

<style scoped>
/* Add any custom styles for your button here */
</style>
