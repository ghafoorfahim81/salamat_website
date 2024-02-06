@extends('layouts.master')
@section('title')
    سیتم مدیریت اسناد| ایجاد سند
@endsection
@section('content')
    <div id="app" v-cloak>
        <!-- Breadcrumb -->
        <d-header :title="`{{__('document.document_create')}}`" :show-icon="true" :url="`{{ route("documents.index") }}`"></d-header>
        <div class="w-full bg-white rounded-lg shadow mt-1 dark:bg-gray-800">
            <div class="mt-2">
                <form class="" @submit.prevent="saveForm">
                    <div class="grid md:grid-cols-3 md:gap-4 p-2">
                        <div class="relative z-0 w-full">
                            <div>
                                <d-input :label="`{{__('document.title')}}`" :name.sync="form.title"/>
                            </div>
                            <div class="text-sm text-red-600 dark:text-red-500 mt-2">
                                <span class="font-medium">@{{ errors.title }}</span>
                            </div>
                        </div>

                        <div class="relative">
                            <label for="subject" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform
                             -translate-y-3 scale-68 top-1 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2
                              peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
                               peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1
                               peer-focus:scale-75 peer-focus:-translate-y-3 start-1 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                {{__('document.subject')}}
                            </label>
                            <textarea
                                id="subject"
                                rows="4"
                                v-model="form.subject"
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
                                v-model="form.remark"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"

                            ></textarea>
                        </div>

                    </div>
                    <div class="text-right rtl:text-left py-2">
                        <save-btn :loading="loading" @click="saveForm" :isdisable="disable" :icon="'edit'"
                                  :btn_name="`{{__('document.save_document')}}`" :loading_text="`{{__('document.document_is_creating')}}`"></save-btn>
                    </div>
                </form>
            </div>
            @include('documents.create-edit-modal')
            @include('documents.tracker-info-modal')
            @include('documents.attachment-modal')
            @include('documents.filter-modal')
            @include('documents.attachment-modal')

            <div class="">

                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-1">
                        <add-new @click="openAddTrackerModal" :btn_name="`{{__('document.add_tracker')}}`"/>
                    </div>
                </div>

                <hr class="h-px bg-gray-200 border-0 dark:bg-gray-700">
                <datatable ref="child" :per-page="{{perPage()}}"
                           :no-record-found-text="'@lang('general_words.no_record_found')'"
                           :search="'@lang('document.search_tracker')'"
                           :current="'@lang('general_words.current')'"
                           :next="'@lang('general_words.next')'"
                           :previous="'@lang('general_words.previous')'"
                           :per-page-text="'@lang('general_words.per_page_record')'"
                           :app-per-page="{!! perPage(1) !!}"
                           :columns="columns" :data="apiData" @pagination-change-page="getRecord"
                           :limit="1" :filterRecord="getRecord"
                           @delete-method-action="deleteRecord">
                    <template slot="tbody">
                        <tbody v-show="!apiData.data || showLoading">
                        <tr v-for="skeleton in 4">
                            <td v-for="skeleton in 4">

                            </td>
                        </tr>
                        </tbody>
                        <tbody v-show="apiData.data && !showLoading">
                        <tr v-for="(record,index) in apiData.data" :key="record.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"> @{{index
                                + 1}}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.sender}}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.receiver}}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.in_num !== null ? record.in_doc_prefix +'-'+ record.in_num : '' }}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.out_doc_prefix?record.out_doc_prefix+'-' + record.out_num:record.out_num}}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.in_date}}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.out_date}}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{ calculateSum(record.request_deadline, record.deadline_days) }}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.doc_type_name}}
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{ dateDifferences[index] }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <input type="checkbox" v-model="record.is_checked" @change="openConfirmationPopup(record)">
                                <label v-if="record.is_checked === 0">
                                </label>
                            </td>
                            <td
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <template>
                                    <div>
                                        <action-btn @edit="editRecord(record.id)" @info="viewTracker(record.id)"
                                                    @delete="deleteRecord(record.id)" :permissions="permissions"/>
                                    </div>
                                </template>
                            </td>
                        </tr>
                        </tbody>
                    </template>
                </datatable>
            </div>

            <div v-if="confirmationPopup" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-gray-300 z-50 rounded-md">
                <div class="popup-content">
                    <p>Are you sure you want to update?</p><br>
                    <button @click="confirmUpdate" class="bg-green-500 text-white px-4 py-2 mr-2 rounded-md">Yes</button>
                    <button @click="cancelUpdate" class="bg-red-500 text-white px-4 py-2 rounded-md">No</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var vm = new Vue({
            el: '#app',
            components: {
                // datePicker
            },
            data() {
                return {
                    current_date: "{!! now()->format('Y-m-d') !!}",
                    docTypes: [
                        {name: `{{__('document.internal')}}`, label: 'internal'},
                        {name: `{{__('document.external')}}`, label: 'external'},
                    ],
                    selected_type: {name: `{{__('document.internal')}}`, label: 'internal'},

                    inOutDocument: [
                        {name: `{{__('document.incoming')}}`, label: 'in'},
                        {name: `{{__('document.outgoing')}}`, label: 'out'},
                    ],
                    form: {
                        title: null,
                        subject: null,
                        remark: null,
                    },
                    loading: false,
                    disable: false,
                    permissions:{
                        delete: "{!! hasPermission(['tracker_delete']) !!}",
                        edit: "{!! hasPermission(['tracker_edit']) !!}",
                        view: "{!! hasPermission(['tracker_view']) !!}",
                    },
                    //    Tracker list
                    url: '{{route("trackers.index")}}?',
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('document.sender')",
                            sort: true,
                            name: 'sender',
                        },
                        {
                            label: "@lang('document.receiver')",
                            name: 'receiver',
                        },
                        {
                            label: "@lang('document.in_number')",
                            name: 'in_num',
                        },
                        {
                            label: "@lang('document.out_number')",
                            name: 'out_num',
                        },
                        {
                            label: "@lang('document.in_date')",
                            name: 'out_date',
                        },
                        {
                            label: "@lang('document.out_date')",
                            name: 'out_date',
                        },
                        {
                            label: "@lang('document.request_deadline')",
                            name: 'request_deadline',
                        },
                        {
                            label: "@lang('document.document_type')",
                            name: 'document_type',
                        },
                        {
                            label: "@lang('document.date_difference')",
                            name: 'date_difference',
                        },
                        {
                            label: "@lang('document.is_checked')",
                            name: 'is_checked',
                        },
                        {
                            label: "@lang('general_words.action')",
                            name: 'action',
                        },
                    ],
                    apiData: {},
                    appPerPage: '{!! perPage(1) !!}',
                    perPage: "{{ perPage() }}",
                    page: 1,
                }
            },
            created() {
            },
            mounted() {
            },
            updated() {

            },

            computed: {

            },
            watch: {
                selected_doc_type: 'fetchDaysData',
                selected_security_level: 'fetchDaysData',
            },

            methods: {
                openAddTrackerModal() {
                    if(!this.trackerForm.document_id){
                        showMessage("@lang('document.please_create_the_document_first')", "warning");
                        return false;
                    }
                    this.trackerModalTitle = this.form.title;
                    this.getDropdownItem(['deputies',
                        'followupTypes',
                        'securityLevels',
                        'deadlineTypes',
                        'statuses',
                        'deadlines',
                        'documentTypes',
                        'external_dirs'
                    ]).then(() => {
                        this.selected_deadline_type = this.deadlineTypes.find(item => item.id == 1)
                        this.selected_security_level = this.securityLevels.find(item => item.id == 1)
                        this.selected_followup_type = this.followupTypes.find(item => item.id == 1)
                        this.selected_status        = this.statuses.find(item => item.slug == 'ongoing');
                    })
                    this.isModalOpen = true;
                },



                validation: function() {
                    let flag = false;
                    if (!this.selected_type) {
                        this.errors.doc_type = "@lang('validation.in_out_is_not_selected')"
                        flag=true;
                    }

                    if (!this.selected_doc_type) {
                        this.errors.document_type = "@lang('validation.document_type_is_not_selected')";
                        flag=true;
                    }

                    if (this.selected_type.label === 'internal' && !this.selected_receiver_employee) {
                        this.errors.receiver_employee = "@lang('validation.receiver_employee_is_not_selected')";
                        flag=true;
                    }
                    if (this.selected_type.label === 'external') {
                        if (!this.selected_in_out) {
                            this.errors.in_out = "@lang('validation.document_status_is_not_selected')";
                            flag=true;
                        }
                        if (!this.selected_external_directorate) {
                            this.errors.external_directorate = "@lang('validation.directorate_is_not_selected')";
                            flag=true;
                        }
                        if(this.selected_in_out && this.selected_in_out.label==='in'){
                            if (!this.selected_receiver_employee) {
                                this.errors.receiver_employee = "@lang('validation.receiver_employee_is_not_selected')";
                                flag=true;
                            }
                        }
                    }
                    return flag;
                },



                // save document
                saveForm(e) {
                    if(this.form.title === null || this.form.title.trim() === '') {
                        this.errors.title="@lang('validation.title_is_required')";
                        return false;
                    }
                    else{
                        this.loading = true;
                        axios.post("{{ route('documents.store') }}", this.form).then((res) => {
                            let response = res.data;
                            if (response.status == 200) {
                                this.loading = false;
                                this.disable=true;
                                this.docFormErrors = null;
                                this.trackerForm.document_id = response.document_id;
                                showMessage("saved", 'success');
                                this.showToast = true;
                                this.addPreventNavigationEventListener();
                            } else {
                                this.loading = false;
                                showMessage('failed');
                            }
                        }).catch((error) => {
                            this.loading = false
                            // Handle error response (including validation errors)
                            if (error.response && error.response.status === 422) {
                                this.docFormErrors = error.response.data.errors;
                            } else {
                                console.error("Other Error: ", error);
                            }
                        });
                    }
                },

                //Tracker list functions
                getRecord: _.debounce((page = vm.page) => {
                    vm.showLoading = true;
                    axios.get(vm.url
                        + '&current_page=' + page
                        + '&document_id=' + vm.trackerForm.document_id
                        + '&per_page=' + vm.perPage
                    )
                        .then((response) => {
                            vm.showLoading = false;
                            if (response.data) {
                                vm.page = response.data.current_page;
                            }
                            vm.apiData = response.data;
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }, 200),

                openModal() {
                    if(this.trackerForm.document_id == null) {
                        showMessage("@lang('document.please_create_the_document_first')", 'warning');
                        return false;
                    }
                    this.getDropdownItem(['deputies',
                        'followupTypes',
                        'securityLevels',
                        'deadlineTypes',
                        'statuses',
                        'deadlines',
                        'documentTypes',
                        'external_dirs',
                    ]).then(()=>{
                        this.selected_deadline_type = this.deadlineTypes.find(item => item.id == 1)
                        this.selected_security_level = this.securityLevels.find(item => item.id == 1)
                        this.selected_followup_type = this.followupTypes.find(item => item.id == 1)
                        this.selected_status        = this.statuses.find(item => item.slug == 'ongoing');
                    })
                    this.isModalOpen = true;
                },


            },

        });

    </script>
@endsection
