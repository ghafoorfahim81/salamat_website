<modal
    v-if="isInfoModalOpen"
    @close-modal="closeModal"
    :title="'Tracker Info'"
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
                <div class="grid md:grid-cols-2 text-sm">
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">ارسال کننده</div>
                        <div class="px-4 py-2">@{{ selected_sender_employee?selected_sender_employee.name:'' }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">دریافت کننده</div>
                        <div class="px-4 py-2">@{{ selected_receiver_employee?selected_receiver_employee.name:'' }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">نمبر وارده</div>
                        <div class="px-4 py-2">@{{ trackerForm.in_num }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">نمبر صادره</div>
                        <div class="px-4 py-2">@{{ trackerForm.out_num }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">تاریخ وارده</div>
                        <div class="px-4 py-2">@{{ trackerForm.in_date }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">تاریخ صادره</div>
                        <div class="px-4 py-2">@{{ trackerForm.out_date }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">مهلت درخواست</div>
                        <div class="px-4 py-2">@{{ trackerForm.request_deadline }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">تعداد ضمایم</div>
                        <div class="px-4 py-2">@{{ trackerForm.attachment_count }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">نوع سند</div>
                        <div class="px-4 py-2">@{{ selected_doc_type?selected_doc_type.name:'' }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">مهلت</div>
                        <div class="px-4 py-2">@{{ selected_deadline?selected_deadline.name:'' }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">نوع مهلت</div>
                        <div class="px-4 py-2">@{{ selected_deadline_type?selected_deadline_type.name:'' }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">سطح امنیتی</div>
                        <div class="px-4 py-2">@{{ selected_security_level?selected_security_level.name:'' }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">نوع تعقیب</div>
                        <div class="px-4 py-2">@{{ selected_followup_type?selected_followup_type.name:'' }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">توضیحات</div>
                        <div class="px-4 py-2">@{{ trackerForm.remark }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</modal>
