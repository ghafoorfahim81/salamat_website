<modal
    v-if="isTrackerShowModalOpen"
    @close-modal="closeModal"
    :title="`{{ __('document.tracker_show') }}`"
    :disabled="true"
    :show-submit="false"
    :loading_text="`{{ __('document.tracker_show') }}`"
    :btn_name="'Save tracker'"
    :size="'large'"

>
    <!-- Content to display in the modal -->

    <div class="w-full mx-2">
        <div class="bg-white p-3 shadow-sm rounded-sm">
            <div class="text-gray-700">
                <div class="flex mt-2 p-1">

                    <div class="basis-1/2">

                        <card-content :label="`{{ __('document.sender') }}`"
                                      :content="tracker?.sender?.name_en"></card-content>
                        <card-content :label="`{{ __('document.receiver') }}`"
                                      :content="tracker?.receiver?.name_en"></card-content>
                        <card-content :label="`{{ __('document.in_number') }}`"
                                      :content="tracker?.in_num"></card-content>
                        <card-content :label="`{{ __('document.out_number') }}`"
                                      :content="tracker?.out_num"></card-content>
                        <card-content :label="`{{ __('document.in_date') }}`"
                                      :content="tracker?.in_date"></card-content>
                        <card-content :label="`{{ __('document.out_date') }}`"
                                      :content="tracker?.out_date"></card-content>
                        <card-content :label="`{{ __('document.request_deadline') }}`"
                                      :content="tracker?.request_deadline"></card-content>
                        <card-content :label="`{{ __('document.total_attachments') }}`"
                                      :content="tracker?.attachment_count"></card-content>
                        <card-content :label="`{{ __('document.document_type') }}`"
                                      :content="tracker?.doc_type?.name"></card-content>
                        <card-content :label="`{{ __('document.deadline') }}`"
                                      :content="tracker?.deadline?.days"></card-content>
                        <card-content :label="`{{ __('document.deadline_type') }}`"
                                      :content="tracker?.deadlineType?.name"></card-content>
                        <card-content :label="`{{ __('document.security_level') }}`"
                                      :content="tracker?.security_level?.name"></card-content>
                        <card-content :label="`{{ __('document.followup_type') }}`"
                                      :content="tracker?.followup_type?.name"></card-content>
                        <card-content :label="`{{ __('document.remark') }}`" :content="tracker?.remark"></card-content>

                    </div>
                </div>
            </div>
        </div>
    </div>

</modal>
