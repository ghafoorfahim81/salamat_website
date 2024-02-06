<template>
        <div role="status" class="animate-pulse" v-show="show" >
            <div class="h-6 rounded-[8px] bg-gray-300 dark:bg-gray-700 max-w-[640px] mb-2.5 mx-auto"></div>
        </div>

<!--    <div role="status" class="max-w-sm animate-pulse" v-show="show">-->
<!--        <div class="h-6 bg-gray-200 rounded-full dark:bg-gray-700 w-48 mb-4"></div>-->
<!--    </div>-->
</template>

<script>
export default {
    props: ["show"],
    data () {
        return {
        }
    }
}
</script>
