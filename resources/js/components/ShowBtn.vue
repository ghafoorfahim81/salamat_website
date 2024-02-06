<template>
    <a
       class="btn drp-icon btn-rounded btn-info dropdown-toggle"
       @click="$emit('click')">
        <i
        class="feather icon-info"></i></a>

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
