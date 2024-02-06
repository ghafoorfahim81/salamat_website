<template>
    <div id="accordion-collapse" data-accordion="collapse" class="mt-2">
        <h2 id="accordion-collapse-heading-1">
            <button type="button" @click="show_search =!show_search" class="flex items-center justify-between w-full p-3 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
                <span>{{search_text}}</span>
                <i class="material-icons" v-show="!show_search">expand_more</i>
                <i class="material-icons" v-show="show_search">expand_less</i>
            </button>
        </h2>
        <div v-show="show_search" class="" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
            <slot>

            </slot>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        headingText: String,
        search_text: String,
    },
    data() {
        return {
            isExpanded: false,
            show_search:false,
        };
    },
    methods: {

    },
};
</script>

<style>
/* Add your styles here if needed */
</style>
