<template>
    <a
       class="ms-1 btn-edit hover-text:hover tooltip-text3"
       @click="$emit('click')">
        <span id="top" class="tooltip-text tooltip-text3"
        style="right: -30px;">{{ tooltip_text }}</span><i
        class="fadeIn animated bx bx-history"></i></a>

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
