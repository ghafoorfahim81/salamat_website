<modal
    v-if="isModalOpen"
    @close-modal="closeModal"
    @decline="decline"
    :title="isEdit ? `{{__('document.tracker_edit')}}` : `{{__('document.tracker_create')}}`"
    :loading="save_tracker_loader"
    :disable="false"
    :loading_text="`{{__('document.tracker_is_saving')}}`"
    :btn_name="`{{__('document.tracker_save')}}`"
    :show-submit="true"
    :btn_icon="'save'"
    @submit="handleSubmit"
    :size="'large'"
    :cancel_text="`{{__('general_words.cancel')}}`"
>
    <!-- Content to display in the modal -->

    <form enctype="multipart/form-data">
        <div class="">
            <div class="grid gap-4 md:grid-cols-4">
                <div v-show="showDocTtitle" class="relative z-100 w-full group dark:bg-slate-50 dark:text-slate-500">
                    <div>
                    <d-input :label="`{{__('document.title')}}`" :name.sync="trackerForm.title"/>
                    </div>
                    <div class="text-sm text-red-600 dark:text-red-500 mt-2">
                            <span class="font-medium">@{{ errors.title }}</span>
                        </div>
                </div>
                <div class="relative z-100 w-full group dark:bg-slate-50 dark:text-slate-500">
                    <div>
                        <v-select class="" :options="docTypes" @input="fetchDaysData" id="" v-model="selected_type" label="name"
                        ></v-select>
                        <floating-label :id="'type'" :label="`{{__('document.in_out')}}`"/>
                    </div>
                    <div class="text-sm text-red-600 dark:text-red-500 mt-2">
                        <span class="font-medium" v-show="!selected_type">@{{ errors.doc_type }}</span>
                    </div>
                </div>

                <div class="relative z-100 w-full group"
                     v-show="(selected_type && selected_type.label)==='external'">
                    <div>
                        <v-select :options="inOutDocument" id="" v-model="selected_in_out" label="name"
                        ></v-select>
                        <floating-label :id="''" :label="`{{__('document.ext_in_out')}}`"/>
                    </div>
                    <div class="text-sm text-red-600 dark:text-red-500 mt-2">
                        <span class="font-medium" v-show="!selected_in_out">@{{ errors.in_out }}</span>
                    </div>
                </div>
                <div class="relative z-100 w-full group"
                     v-show="(selected_type && selected_type.label)==='external'">
                    <div>
                        <v-select :options="externalDirectorates" class="text-sm" id="" label="name"
                                  @search="searchExternalDirectorate"
                                  v-model="selected_external_directorate"></v-select>

                        <floating-label :id="''" :label="`{{__('document.external_directorates')}}`"/>
                    </div>
                    <div class="text-sm text-red-600 dark:text-red-500 mt-2">
                        <span class="font-medium" v-show="!selected_external_directorate">@{{ errors.external_directorate }}</span>
                    </div>
                </div>

                <div class="relative z-100 w-full group">
                    <div>
                        <v-select :options="documentTypes" class="text-sm" id="" label="name"
                                  v-model="selected_doc_type"></v-select>
                        <floating-label :id="''" :label="`{{__('document.document_type')}}`"/>
                        <skeleton :show="showSkeleton"></skeleton>
                    </div>
                    <div class="text-sm text-red-600 dark:text-red-500 mt-2">
                        <span class="font-medium" v-show="!selected_doc_type">@{{ errors.document_type }}</span>
                    </div>
                </div>
                <div class="relative"
                     v-show="((selected_in_out && selected_in_out.label) === 'in') || ((selected_in_out && selected_in_out.label) === 'out') || ((selected_type && selected_type.label) === 'internal')">
                    <v-select :options="deputies" class="text-sm" id="deputy" label="name"
                              @input="getDeputyDirectorates(selected_deputy?.id)"
                              v-model="selected_deputy"></v-select>
                    <floating-label :id="'deputy'" :label="`{{__('document.deputy')}}`"/>
                </div>
                <skeleton :show="showSkeleton"></skeleton>
                <div class="relative"
                     v-show="((selected_in_out && selected_in_out.label) === 'in') || ((selected_in_out && selected_in_out.label) === 'out') || ((selected_type && selected_type.label) === 'internal')">
                    <v-select :options="generalDirectorates" class="text-sm" id="receiver" label="name"
                              @input="getGeneralDirDirectorates(selected_general_directorate?.id)"
                              v-model="selected_general_directorate"></v-select>
                    <floating-label :id="'selected_directorate'" :label="`{{__('document.general_directorate')}}`"/>
                </div>
{{--                <skeleton :show="showGdSkeleton"></skeleton>--}}
                <div class="relative"
                     v-show="((selected_in_out && selected_in_out.label) === 'in') || ((selected_in_out && selected_in_out.label) === 'out') || ((selected_type && selected_type.label) === 'internal')">
                    <v-select :options="directorates" class="text-sm" id="receiver" label="name"
                              @input="getDirectorateEmployees(selected_directorate?.id)"
                              v-model="selected_directorate"></v-select>
                    <floating-label :id="'selected_directorate'" :label="`{{__('document.directorate')}}`"/>
                </div>
{{--                <skeleton :show="showDSkeleton"></skeleton>--}}
                <div class="relative"
                     v-show="((selected_in_out && selected_in_out.label) === 'in') || ((selected_in_out && selected_in_out.label) === 'out') || ((selected_type && selected_type.label) === 'internal')">
                    <div>
                        <v-select :options="employees" class="text-sm" id="employee" label="name"
                                  v-model="selected_receiver_employee">
                            <template #list-footer>
                                <li style="text-align: center" class="w-full pt-2">
                                    <button type="button"
                                            @click="openFilterModal"
                                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                        {{__('document.add_copies')}}
                                    </button>

                                </li>
                            </template>
                        </v-select>
                        <floating-label :id="'employee'" :label="`{{__('general_words.employee')}}`"/>
                    </div>
                    <div class="text-sm text-red-600 dark:text-red-500 mt-2">
                        <span class="font-medium"
                              v-show="!selected_receiver_employee">@{{ errors.receiver_employee }}</span>
                    </div>
                </div>
{{--                <skeleton :show="showEmpSkeleton"></skeleton>--}}
            </div>

            <div class="grid gap-4 md:grid-cols-4" v-show="(selected_in_out && selected_in_out.label)==='in'">
                <div>
                    <d-input type="number" :readonly="isEdit" :label="`{{__('document.in_number')}}`" :name.sync="trackerForm.in_num"/>
                </div>

                <div class="relative">
                    <date-picker :disabled="isEdit" :column="1" mode="single" v-model="trackerForm.in_date" clearable locale="da" :locale-config="localeConfigs">
                        <template #icon>

                        </template>
                    </date-picker>
                    <floating-label :id="'selected_directorate'" :label="`{{__('document.in_date')}}`"/>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-4">
                <div>
                    <d-input type="number" :readonly="isEdit" :label="`{{__('document.out_number')}}`" :name.sync="trackerForm.out_num"/>
                </div>
                <div class="relative">
                    <date-picker :disabled="isEdit" :column="1" mode="single" v-model="trackerForm.out_date" clearable locale="da"  :locale-config="localeConfigs">
                    <template #icon>

                    </template>
                    </date-picker>
                    <floating-label :id="'selected_directorate'" :label="`{{__('document.out_date')}}`"/>
                </div>

                <div class="relative" v-show="!showSkeleton">
                    <v-select class="text-sm" :options="securityLevels" label="name"
                              v-model="selected_security_level"></v-select>
                    <floating-label :id="'selected_security_level'" :label="`{{__('document.security_level')}}`"/>
                </div>
                <div class="relative" v-show="!showSkeleton">
                    <v-select class="text-sm" :options="deadlineTypes" label="name"
                              v-model="selected_deadline_type"></v-select>
                    <floating-label :id="'selected_deadline_type'" :label="`{{__('document.deadline_type')}}`"/>
                </div>
                <div class="ml-0" v-show="(selected_deadline_type && selected_deadline_type.name)==='متغیر'">
                    <d-input :label="`{{__('document.request_deadline')}}`" :name.sync="trackerForm.request_deadline"/>

                </div>

                <div class="relative z-50 w-full group"
                     v-show="(selected_deadline_type && selected_deadline_type.name)==='ثابت'">
                    <v-select class="text-sm" :options="deadlines" label="days" v-model="selected_deadline"></v-select>
                    <floating-label :id="'selected_deadline'" :label="`{{__('document.deadline')}}`"/>
                </div>
                <div>
                    <d-input type="number" :label="`{{__('document.total_attachments')}}`"
                             :name.sync="trackerForm.attachment_count"/>
                </div>

                    <div class="relative" v-show="!showSkeleton">
                        <v-select class="text-sm" :options="statuses" label="name" v-model="selected_status"></v-select>
                        <floating-label :id="'selected_status'" :label="`{{__('document.document_status')}}`"/>
                    </div>
                    <div class="relative" v-show="!showSkeleton">
                        <v-select class="text-sm" :options="followupTypes" label="name"
                                  v-model="selected_followup_type"></v-select>
                        <floating-label :id="'selected_followup_type'" :label="`{{__('document.followup_type')}}`"/>
                    </div>
                    <div>
                        <d-input :label="`{{__('general_words.phone_number')}}`" :name.sync="trackerForm.phone_number"/>
                    </div>
                    <div>
                        <d-input :label="`{{__('document.focal_point')}}`" :name.sync="trackerForm.focal_point_name"/>
                    </div>
                    <div>
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                           @click="openAttachmentModal">Attachment</a>
                    </div>

                    <div class="relative">
                        <label for="subject" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform
                             -translate-y-3 scale-68 top-1 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2
                              peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                               peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1
                               peer-focus:scale-75 peer-focus:-translate-y-3 start-1 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                            {{__('document.decision_subject')}}
                        </label>
                        <textarea
                            id="subject"
                            rows="4"
                            v-model="trackerForm.decision_subject"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"

                        ></textarea>
                    </div>
                    <div class="relative">
                        <label for="subject" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform
                             -translate-y-3 scale-68 top-1 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2
                              peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                               peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1
                               peer-focus:scale-75 peer-focus:-translate-y-3 start-1 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                            {{__('document.conclusion')}}
                        </label>
                        <textarea
                            id="subject"
                            rows="4"
                            v-model="trackerForm.conclusion"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"

                        ></textarea>
                    </div>
                    <div class="relative">
                        <label for="subject" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform
                             -translate-y-3 scale-68 top-1 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2
                              peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                               peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1
                               peer-focus:scale-75 peer-focus:-translate-y-3 start-1 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                            {{__('document.remark')}}
                        </label>
                        <textarea
                            id="subject"
                            rows="4"
                            v-model="trackerForm.remark"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"

                        ></textarea>
                    </div>

            </div>
        </div>
    </form>

</modal>
