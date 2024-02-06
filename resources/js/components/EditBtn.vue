<template>
<!--    <a-->
<!--       class="btn drp-icon btn-rounded btn-primary dropdown-toggle"-->
<!--       @click="$emit('click')"><i-->
<!--        class="feather icon-edit-2"></i></a>-->

    <a @click="$emit('click')" class="text-white bg-red-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        <span class="sr-only">Icon description</span>
    </a>
</template>

<script>
export default {
    props: ['tooltip_text'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>
