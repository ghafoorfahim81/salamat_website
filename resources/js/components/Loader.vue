<template>
    <div class="spinner-border text-info" v-show="loading" style="z-index:999999999; position: absolute; left: 50%;
                                        top: 35%; width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden"> </span>
    </div>
</template>

<script>
export default {
    props: ["loading", "label"],
    data () {
        return {
        }
    }
}
</script>
