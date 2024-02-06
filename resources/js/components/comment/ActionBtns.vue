<template>
    <div
        class="z-10 bg-white w-fit absolute right-5 rtl:right-auto rtl:left-5 rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
        <ul class="text-sm text-gray-700 dark:text-gray-200"
            aria-labelledby="dropdownMenuIconHorizontalButton">
            <li>
                <a href="#"
                   @click="$emit('edit')"
                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    <div class="flex">
                        <span class="material-icons text-xs">edit</span>
                        <span>{{ editLabel }}</span>
                    </div>
                </a>
            </li>
            <li class="w-fit">
                <a href="#"
                   @click="$emit('delete')"
                   class="block px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    <div class="flex">
                        <span class="material-icons text-xs">delete</span>
                        <span>{{ deleteLabel }}</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>

export default {
    props: ['editLabel', 'deleteLabel'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>
