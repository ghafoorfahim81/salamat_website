<template>
    <div id="toast-interactive" class=" transition-colors shadow-md duration-500 ease-out w-full max-w-xs p-4 z-50 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400" role="alert">
        <div class="flex">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:text-blue-300 dark:bg-blue-900">
                <i class="material-icons px-3 text-gray-400 hover:cursor-pointer"
                  >check_circle</i>
                <span class="sr-only">Refresh icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">{{ physicallyReceiveText }}</span>
                <div class="mb-2 text-sm font-normal">{{sureText}}</div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <a href="#" @click="$emit('complete')" class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">{{ receivedText }}</a>
                    </div>
                    <div>
                        <a href="#" @click="$emit('cancel')" class="inline-flex justify-center w-full px-2 py-1.5 text-xs font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">{{cancelledText}}</a>
                    </div>
                </div>
            </div>
            <button type="button" @click="$emit('cancel')" class="ms-auto -mx-1.5 -my-1.5 bg-white items-center justify-center flex-shrink-0 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-interactive" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    </div>


</template>

<script>
export default {
    props: ['user', 'physicallyReceiveText','sureText','cancelledText','receivedText'],
    computed: {
        firstCharacter() {
            // Extract and return the first character of the user's name
            return this.user.charAt(0).toUpperCase();
        }
    }
};
</script>

<style>
/* Add any styling as needed */
</style>
