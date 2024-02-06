<template>
    <div class="inline-flex rounded-lg" role="group">
        <button
            @click="$emit('info')"
            v-show="showInfo && permissions.view"
            type="button" class="text-gray-500 bg-white-200 hover:bg-sky-800 hover:text-white border-sm ring-1 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium
        rounded-full text-sm p-1 text-center inline-flex items-center mr-1 dark:emerald-200 dark:hover:emerald-400 dark:focus:ring-blue-800">
            <template>
                    <i class="material-icons">visibility</i>
            </template>
        </button>
        <button type="button"
                @click="$emit('edit')"
                v-show="permissions.edit"
                class="text-gray-500 bg-white-200 hover:bg-blue-800 focus:ring-4 hover:text-white border-sm ring-1
                focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-1 text-center inline-flex items-center mr-1 dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <template>
                <i class="material-icons">edit_note</i>
            </template>
        </button>
        <button type="button"
                @click="$emit('delete')"
                v-show="permissions.delete"
                class="text-gray-500 bg-white-200 hover:bg-rose-600 hover:ring-rose-600 hover:text-white border-sm ring-1 focus:ring-4 focus:outline-none focus:ring-rose-600 font-medium rounded-full text-sm p-1 text-center inline-flex items-center mr-1 dark:red-500 dark:hover:bg-red-800 dark:focus:ring-blue-800">
            <template>
                <i class="material-icons">delete</i>
            </template>
        </button>
<!--        <button type="button"-->
<!--                v-show="showAddTracker"-->
<!--                @click="$emit('tracker')"-->
<!--                class="text-white bg-emerald-400 hover:bg-emerald-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-1 text-center inline-flex items-center mr-1 dark:bg-emerald-600 dark:hover:bg-emerald-600 dark:focus:ring-blue-800">-->
<!--            <template>-->
<!--                <i class="material-icons">create_new_folder</i>-->
<!--            </template>-->
<!--        </button>-->

    </div>

</template>

<script>

export default {
    props: ['recordId','showAddTracker','showInfo','permissions'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>
