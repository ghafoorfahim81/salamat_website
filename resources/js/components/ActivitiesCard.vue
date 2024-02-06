<template>
    <div class="flex relative">
        <div
            class="w-full relative shadow-shadow-2xl max-w-md bg-gray-50 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            :class="exClass??null"
        >


<!--            <div id="toast-warning" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">-->
<!--                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">-->
<!--                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">-->
<!--                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>-->
<!--                    </svg>-->
<!--                    <span class="sr-only">Warning icon</span>-->
<!--                </div>-->
<!--                <div class="ms-3 text-sm font-normal">Improve password difficulty.</div>-->
<!--                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-warning" aria-label="Close">-->
<!--                    <span class="sr-only">Close</span>-->
<!--                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">-->
<!--                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>-->
<!--                    </svg>-->
<!--                </button>-->
<!--            </div>-->
            <div class="flex relative items-center justify-between mb-4">
                <h5 class="text-xs font-bold leading-none p-4 m-2 text-gray-900 dark:text-white">{{ from }} >
                    {{ to }}</h5>
                <dropdown @click="shwActionBtn"></dropdown>
                <div id="dropdown" v-show="show_action_btn"
                     class="absolute rtl:left-4 top-14 rtl:top-10 right-2 rtl:right-auto top-5 z-10 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2" aria-labelledby="dropdownButton">
                        <li class="hover:cursor-pointer hover:bg-gray-100 hover:m-1"
                            @click="showPhysicallyReceivePopup">
                            <div class="flex items-center">
                                <i class="material-icons px-3 text-gray-400 hover:cursor-pointer"
                                   @click="showPhysicallyReceivePopup">check_circle</i>
                                <a href="#" @click="showPhysicallyReceivePopup"
                                   class="block py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{receivedText}}</a>
                            </div>
                        </li>
                    </ul>
                    <ul class="py-2" aria-labelledby="dropdownButton" v-show="canEdit">
                        <li class="hover:cursor-pointer hover:bg-gray-100 hover:m-1 " @click="$emit('edittracker')">
                            <div class="flex items-center">
                                <i class="material-icons px-3 text-gray-400 hover:cursor-pointer"
                                   @click="$emit('edittracker')">edit</i>
                                <a href="#" @click="$emit('edittracker')"
                                   class="block py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ editText }}</a>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="flow-root">
                <slot></slot>
            </div>
        </div>
        <div v-show="show_physically_popup" class="bg-red-400 absolute top-14 ">
            <toast v-show="true" @complete="PhysicallyReceive" @cancel="cancelReceive" :received-text="receivedText" :cancelled-text="cancelledText" :physically-receive-text="physicallyReceiveText" :sure-text="sureText"></toast>
        </div>
    </div>
</template>

<script>
export default {
    props: ['from', 'to', 'user', 'exClass','trackerId','trackerStatus','physicallyReceiveText','sureText','cancelledText','receivedText','editText','isChecked','canEdit'],
    data() {
        return {
            show_action_btn: false,
            show_physically_popup: false,
            statusClass:this.exClass
        };
    },
    methods: {
        shwActionBtn() {
            this.show_action_btn = !this.show_action_btn;
        },
        showPhysicallyReceivePopup() {
            if(this.isChecked){
                return;
            }
            this.show_action_btn= false;
            this.show_physically_popup = true;
        },
        PhysicallyReceive() {
            axios.patch(`/tracker/updateIsChecked/${this.trackerId}`)
                .then(response => {
                    if (response.data.status === 200) {
                        this.show_physically_popup = false;
                        this.$emit('complete');
                        this.trackerStatus=4
                    }
                    // console.log('hhere', updatedRecord);
                })
                .catch(error => {
                    // Handle the error
                    console.error('Error updating checkbox status:', error);
                });
        },
        cancelReceive() {
            this.show_physically_popup = false;
        },
    },
};
</script>

<style>
/* Add any styling as needed */
</style>
