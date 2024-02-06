<modal
    v-if="isReceiverListModalOpen"
    @close-modal="closeReceiverListModal"
    :title="'{{__('document.receivers')}}'"
    :loading="save_tracker_loader"
    :disabled="false"
    :loading_text="'Tracker is Saving'"
    :btn_name="'{{__('general_words.close')}}'"
    :show-submit="true"
    @submit="closeReceiverListModal"
    :cancel_text="'{{__('general_words.cancel')}}'"
    >
    <!-- Content to display in the modal -->

    <form>
        <div class="grid gap-6 mb-6">
            <div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">
                                {{__('document.employee')}}
                            </th>
                            <th scope="col" class="px-4 py-3">
                                {{__('general_words.directorate')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(receiver, index) in receivers" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-1 py-1 px-2 text-lg">
                                @{{ receiver.employee_name }}
                            </td>
                            <td class="px-1 py-1 px-2 text-lg">
                                @{{ receiver.directorate_name }}
                            </td>
                        </tr>
                        <tr v-if="receivers.length < 1" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="2" class="text-center py-4">
                                {{__('general_words.no_record_found')}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </form>

</modal>
