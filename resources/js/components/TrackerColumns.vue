<template>
    <div class="row-start-2">
        <span class="mb-1 text-gray-500 font-semibold md:text-lg dark:text-gray-400">{{ label }}</span><br>
        <span class="text-sm font-small">{{value}}</span>
    </div>
</template>

<script>
export default {
    props: ["value", "label"],
    data () {
        return {
        }
    }
}
</script>
