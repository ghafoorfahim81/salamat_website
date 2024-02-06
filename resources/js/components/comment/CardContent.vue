<template>
<div>
    <div class="max-w-lg w-full bg-blue-100 rounded bg-blue-300 hover:bg-blue-400  overflow-hidden py-4 mt-1 px-4 shadow-lg ">
        <div class="flex justify-between dark:border-opacity-50">
            <p class="text-gray-700 font-bold">{{ label }}</p>
            <p class="text-white z-10 font-bold">{{content}}</p>
        </div>
    </div>
</div>
</template>

<script>

export default {
    props: ['label','content'],
    data() {
        return {
            methods: {
            //    create a new function that takes two arguments and returns the sum of the two arguments

            }
        }
    }
}
</script>
