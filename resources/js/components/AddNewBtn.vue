<template>
    <a
       @click="$emit('click')"
       :href="href ? href : null"
       class="px-2 py-1 text-xs font-medium text-center inline-flex items-center text-white
        bg-sky-600 rounded-lg hover:bg-emerald-600 focus:ring-4 focus:outline-none
         focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 m-2">
        <template>
            <i class="material-icons m-1">add_circle</i>
            {{btn_name??'Add new'}}
        </template>
    </a>

</template>

<script>
export default {
    props: ['href','btn_name'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>

<style>

</style>

