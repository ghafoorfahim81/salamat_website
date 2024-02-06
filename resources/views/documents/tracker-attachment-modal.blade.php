<modal
    v-if="isAttachmentListModalOpen"
    @close-modal="closeAttachmentListModal"
    :title="`{{ __('document.tracker_attachments') }}`"
    :loading="save_tracker_loader"
    :disabled="true"
    :show-submit="false"
    :loading_text="'Tracker is Saving'"
    :btn_name="'Save tracker'"
    :size="'large'"

>
    <!-- Content to display in the modal -->

    <div class="w-full md:w-9/12 mx-2">
        <div class="bg-white p-3 shadow-sm rounded-sm">
            <div class="text-gray-700">
                <div class="grid text-sm" v-for="attachment in attachments">
                    <div v-if="isImage(attachment?.file)">
                        <!-- Render image -->
                        <img :src="getAttachmentPath(attachment?.file)" alt="Comment Attachment">
                    </div>
                    <div v-else>
                        <a :href="`{{url('/download')}}/${attachment?.id}`"
                           class="btn btn-outline-light text-blue-500">
                            @{{attachment?.file }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</modal>
