<modal
    v-if="isAttachmentModalOpen"
    @close-modal="closeAttachmentModal"
    :title="'{{__('document.add_attachment')}}'"
    :loading="save_tracker_loader"
    :disabled="false"
    :loading_text="'Tracker is Saving'"
    :btn_name="'{{__('document.add_attachments')}}'"
    :show-submit="true"
    :btn_icon="'cloud_upload'"
    @submit="closeAttachmentModal"
    :cancel_text="'{{__('general_words.cancel')}}'"
    >
    <!-- Content to display in the modal -->

    <form>
        <div class="grid gap-6 mb-6">
            <div>
                <input type="file" @change="onFileSelect" />
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">
                                {{__('document.attachment_name')}}
                            </th>
                            <th scope="col" class="px-4 py-3">
                                {{__('general_words.action')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            v-for="(attachment, index) in attachmentList">
                            <td class="px-1 py-1 px-2">
                                @{{ attachment.name }}
                            </td>
                            <td class="flex items-center px-4 py-4">
                                <a @click="deleteFromAttachmentArray(index)" class="hover:cursor-pointer">
                                    <i class="material-icons text-red-600 dark:text-red-500">
                                        delete
                                    </i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </form>

</modal>
