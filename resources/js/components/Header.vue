<template>
    <nav
        class="flex px-3 py-2 text-white w-full border border-gray-200 rounded-lg bg-sky-600 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3" >
            <li class="inline-flex items-center">
                <div
                   class="inline-flex items-center text-xs font-bold text-white dark:text-gray-400 dark:hover:text-white">
                    <a :href="url" class="mt-2 px-0" v-show="showIcon">
                        <i class="material-icons mr-1 text-xs " v-show="dir=='ltr'">arrow_back</i>
                        <i class="material-icons mr-1 text-xs " v-show="dir=='rtl'">arrow_forward</i>
                    </a>
                      {{ title }}
                </div>
            </li>

        </ol>
    </nav>

</template>

<script>
export default {
    props: ["title",'showIcon','url'],
    data() {
        return {
            dir:localStorage.getItem('dir'),
        }
    }
}
</script>

<style>

</style>

