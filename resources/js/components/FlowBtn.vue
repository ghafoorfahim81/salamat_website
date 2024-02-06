<template>
    <div class="relative inline-block">
        <button @click="$emit('click')" class="px-4 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <i class="material-icons">{{icon}}</i>
        </button>
        <div class="tooltip hidden bg-gray-800 text-white text-sm text-center p-2 rounded-md w-48 absolute bottom-full left-1/2 transform -translate-x-1/2 -mb-3">
            {{tooltip_text}}
        </div>
    </div>


</template>

<script>
export default {
    props: ["label", "icon", 'tooltip_text', 'href','btn_class','target','tooltip_class','loading'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>

<style>

</style>

