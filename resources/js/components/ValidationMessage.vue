<template>
    <div>
        <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400"><span
            class="font-medium">{{ message }}</span></p>
    </div>
</template>

<script>
export default {
    props: ['message'],
    computed: {}
};
</script>

<style>
/* Add any styling as needed */
</style>
