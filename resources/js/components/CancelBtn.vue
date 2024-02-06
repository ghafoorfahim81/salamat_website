<template>
    <button @click="$emit('click')" type="button"
            class="text-white px-5  bg-gray-400 hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
        <svg class="w-4 h-4 " fill="none" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        <!--&lt;!&ndash;        <i class="material-icons" >close</i>&ndash;&gt;-->

       <span class="mr-2">{{ btn_name }}</span>
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
