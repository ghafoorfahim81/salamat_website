<template>
    <div>
        <button @click="$emit('download')" class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-md group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
        <span class="relative flex items-center px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0" style="font-size: 1rem; /* Adjust font-size as needed */">
            <span class="flex items-center space-x-2">
                <template v-if="!loading">
                    <i class="material-icons" style="font-size: inherit;">file_save</i>
                    <span>{{ label }}</span>
                </template>
                <template v-else>
                    <i class="animate-spin material-icons" style="font-size: inherit;">autorenew</i>
                    <span>Loading...</span> <!-- You can replace "Loading..." with your loading text -->
                </template>
            </span>
        </span>
        </button>
    </div>

</template>

<script>
export default {
    props: ["label", "icon", 'loading'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>

<style>

</style>

