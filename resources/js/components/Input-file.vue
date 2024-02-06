<template>
    <div class="relative">
        <label for="d-input" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">{{
                label
            }}</label>
        <input
            type="file"
            @change="onFileChange"
            id="d-input"
            :readonly="readonly ?? false"
            class="bg-white text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
    </div>
</template>

<script>
export default {
    props: ["label", "readonly"],
    methods: {
        onFileChange(event) {
            if (event.target.files.length > 0) {
                this.$emit('change', event.target.files[0]);
            }
        }
    }
}
</script>
