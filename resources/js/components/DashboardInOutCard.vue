<template>
        <div class="max-w-xs hover:bg-blue-200 hover:shadow-xl basis-1/4 mx-1 mt-2 bg-blue-300 rounded overflow-hidden shadow-lg">
            <div class="px-4 py-2">
                <div class="text-lg font-bold font-semibold text-gray-600 mb-1">{{ title }}</div>
                <div class="flex" v-for="(label, index) in labels" :key="index">
                    <div class="w-1/2">
                        <p class="text-gray-700 font-bold text-base">{{ label }}</p>
                    </div>
                    <div class="w-1/2 mx-1">
                        <p class="text-gray-700 text-base rtl:text-left text-right">{{ data[index] }}</p>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        labels: {
            type: Array,
            required: true
        },
        data: {
            type: Array,
            required: true
        }
    }
}
</script>

<style scoped>
/* Add your custom styles here if needed */
</style>
