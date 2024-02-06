<template>
    <div
        id="large-modal"
        class="flex items-start bg-gray-600 overflow-x-hidden bg-opacity-25 justify-center fixed top-0 left-200 right-50
        z-50 w-full p-2  md:inset-0 h-[calc(100%-1rem)] max-h-full
        overflow-y-auto left-0  items-center max-h-full"
    >
        <div class="relative p-4 w-full max-w-2xl max-h-full" :class="size === 'large' ? 'max-w-6xl' : 'max-w-2xl'">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ title }}
                    </h3>
                    <button type="button" @click="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900
                     rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <slot></slot> <!-- Content from parent component goes here -->
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600" v-if="showSubmit">
                       <save-btn :loading="loading" @click="submit" :disable="isDisable" :icon="btn_icon"
                                 :btn_name="btn_name" :loading_text="loading_text"/>
                    <button
                        type="button"
                        class=" text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300
                        rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900
                         focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white
                          dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                        @click="closeModal"
                    >
                        {{ cancel_text }}
                    </button>
                </div>
<!--                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">-->
<!--                    <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>-->
<!--                    <button data-modal-hide="default-modal" type="button" class="ms-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        loading:false,
        isDisable:false,
        loading_text:'',
        btn_name:'',
        cancel_text:'',
        size:'',
        showSubmit:Boolean,
        btn_icon:''
    },
    methods: {
        closeModal() {
            // Implement the logic to close the modal (e.g., set a data property to false)
            this.$emit("close-modal");
            this.decline();
        },
        submit() {
            // Implement the logic for accepting (e.g., handle the accept action)
            // You can emit an event to notify the parent component
            this.$emit("submit");
        },
        decline() {
            // Implement the logic for declining (e.g., handle the decline action)
            // You can emit an event to notify the parent component
            this.$emit("decline");
        },
    },
};
</script>

<style scoped>
/* Add your modal styles here */
</style>
