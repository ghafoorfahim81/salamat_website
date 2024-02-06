@extends('layouts.master')
@section('title')
    - لیست اسناد
@endsection
@section('content')
    <div id="app" v-cloak>
        <!-- Breadcrumb -->
        <d-header :title="`{{__('document.document_list')}}`" :show-icon="false"></d-header>

        <div class=" w-full bg-white rounded-lg shadow mt-1 dark:bg-gray-800">
            <collapse :search_text="`{{__('general_words.search')}}`">
                <div class="grid gap-4 mb-4 md:grid-cols-4">
                    <div>
                        <d-input type="text" :label="`{{__('document.title')}}`"
                                 :name.sync="searchForm.title"/>
                    </div>
                    <div class="relative">
                        <v-select class="" :options="docTypes" id="type" v-model="selected_type" label="name"
                        ></v-select>
                        <floating-label :id="''" :label="`{{__('document.internal_external')}}`"/>
                    </div>

                    <div class="relative" v-show="(selected_type && selected_type.label)==='external'">
                        <v-select :options="inOutDocument" id="" v-model="selected_in_out" label="name"
                        ></v-select>
                        <floating-label :id="''" :label="`{{__('document.ext_in_out')}}`"/>
                    </div>

                    <div class="relative">
                        <v-select class="" :options="documentTypes" id="" v-model="selected_doc_type" label="name"
                        ></v-select>
                        <floating-label :id="''" :label="`{{__('document.document_type')}}`"/>
                    </div>

                    <div>
                        <date-picker ref="date" locale="da" clearable placeholder="{{__('report.from_date')}}"
                                     :locale-config="localeConfigs" :column="1" mode="single"
                                     v-model="searchForm.from_date">

                        </date-picker>
                    </div>
                    <div>
                        <date-picker ref="date" locale="da" clearable placeholder="{{__('report.to_date')}}"
                                     :locale-config="localeConfigs" :column="1" mode="single"
                                     v-model="searchForm.to_date">

                        </date-picker>
                    </div>
                    <div>
                        <d-input type="text" :label="`{{__('document.in_number')}}`" :name.sync="searchForm.in_num"/>
                    </div>
                    <div>
                        <d-input type="text" :label="`{{__('document.out_number')}}`" :name.sync="searchForm.out_num"/>
                    </div>

                    <div class="relative">
                        <v-select class="" :options="statuses" id="type" v-model="selected_status" label="name"
                        ></v-select>
                        <floating-label :id="''" :label="`{{__('document.document_status')}}`"/>
                    </div>

                    <date-picker ref="date" locale="da" clearable :locale-config="localeConfigs"
                                 placeholder=" {{__('document.in_date')}}" :column="1" mode="single"
                                 v-model="searchForm.in_date">
                    </date-picker>
                    <date-picker ref="date" locale="da" clearable :locale-config="localeConfigs"
                                 placeholder=" {{__('document.out_date')}}" :column="1" mode="single"
                                 v-model="searchForm.out_date">

                    </date-picker>

                    <div class="relative">
                        <v-select :options="directorates" class="text-sm" id="receiver" label="name"
                                  @input="getDirectorateEmployees(searchForm.receiver_directorate_id.id)"
                                  v-model="searchForm.receiver_directorate_id"></v-select>
                        <floating-label :id="'selected_directorate'" :label="`{{__('general_words.directorate')}}`"/>
                    </div>
                    <div class="relative">
                        <v-select :options="employees" class="text-sm" id="sender_employee_id" label="name"
                                  v-model="searchForm.receiver_employee_id"></v-select>
                        <floating-label :id="'employee'" :label="`{{__('general_words.employee')}}`"/>
                    </div>

                    <div>
                        <d-input type="text" :label="`{{__('document.focal_point')}}`"
                                 :name.sync="searchForm.focal_point_name"/>
                    </div>
                    <div>
                        <d-input type="text" :label="`{{__('general_words.phone_number')}}`"
                                 :name.sync="searchForm.phone_number"/>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div>
                            <search-btn @click="getRecord()" :btn_name="`{{__('general_words.search')}}`"/>
                        </div>

                        <div>
                            <cancel-btn @click="resetForm" :btn_name="`{{__('general_words.cancel')}}`"/>

                        </div>
                    </div>

                </div>
            </collapse>
            @if(hasPermission(['document_create']))
                <div
                    class="flex flex-wrap justify-end mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <add-new @click="openTrackerModal(true)" :btn_name="`{{__('general_words.add_new')}}`"></add-new>
                </div>
            @endif
            <div class="mt-2">
                <datatable ref="child" :per-page="{{perPage()}}"
                           :no-record-found-text="'@lang('general_words.no_record_found')'"
                           :search="'@lang('document.document_search')'"
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
                            <td v-for="skeleton in 5">
                                <skeleton-loader-vue
                                    type="rect"
                                    :height="34"
                                    :width="150"
                                    :radius="8"
                                    class="m-2"
                                    animation="fade"
                                />
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-show="apiData.data && !showLoading">
                        <tr v-for="(record,index) in apiData.data" :key="record.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white"> @{{index
                                + 1}}
                            </td>
                            <td
                                v-if="record.title.length > 10"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.title.substr(0,40)}} ...
                            </td>
                            <td
                                v-else="record.title.length < 10"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.title.substr(0,40)}}
                            </td>
                            <td
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{ truncateText(record.documentSubject) }}
                            </td>
                            <td
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{ truncateText(record.documentRemark) }}
                            </td>
                            {{--                            <td>--}}
                            {{--                                <div v-for="notification in notifications" :key="notification.id">--}}
                            {{--                                    @{{ notification.data.message }}--}}
                            {{--                                    <button @click="markNotificationAsRead(notification.id)">Mark as Read</button>--}}
                            {{--                                </div>--}}
                            {{--                            </td>--}}
                            <td
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <action-btn @edit="editRecord(record.documentId)"
                                            @info="detailsRecord(record.documentId)"
                                            @delete="deleteRecord(record.documentId)" @tracker="newTracker(record)"
                                            :show-add-tracker="true" :show-info="true" :permissions="permissions"/>
                            </td>
                        </tr>

                        </tbody>

                    </template>
                </datatable>
            </div>
            @include('documents.create-edit-modal')
            @include('documents.attachment-modal')
            @include('documents.filter-modal')

        </div>
    </div>

@endsection
@section('scripts')
    <script>
        let vm = new Vue({
            el: '#app',
            components: {
                'skeleton-loader-vue': window.VueSkeletonLoader,
            },
            data() {
                return {
                    notifications: [],
                    loading: false,
                    selected_department: null,
                    isModalOpen: false,
                    showLoading: false,
                    show_search: false,
                    selected_employee: null,
                    selected_type: '',
                    selected_in_out: '',
                    permissions: {
                        delete: "{!! hasPermission(['document_delete']) !!}",
                        edit: "{!! hasPermission(['document_edit']) !!}",
                        view: "{!! hasPermission(['document_view']) !!}",
                    },

                    searchForm: {
                        subject: '',
                        in_num: '',
                        out_num: '',
                        in_date: '',
                        out_date: '',
                        receiver_directorate_id: '',
                        receiver_employee_id: '',
                        sender_employee_id: '',
                        sender_directorate_id: '',
                        focal_point_name: '',
                        phone_number: '',
                        doc_type_id: '',
                        type: '',
                        from_date: '',
                        to_date: '',
                        title: '',
                    },

                    selected_directorate: '',
                    url: '{{route("documents.index")}}?',
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('document.title')",
                            sort: true,
                            name: 'title',
                        },
                        {
                            label: "@lang('document.subject')",
                            name: 'subject',
                        },

                        {
                            label: "@lang('document.remark')",
                            name: 'remark',
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
                    selectedRows: [],
                    //    add new tracker codes
                    docTypes: [
                        {name: `{{__('document.internal')}}`, label: 'internal'},
                        {name: `{{__('document.external')}}`, label: 'external'},
                    ],
                    selected_type: {name: `{{__('document.internal')}}`, label: 'internal'},

                    inOutDocument: [
                        {name: `{{__('document.incoming')}}`, label: 'in'},
                        {name: `{{__('document.outgoing')}}`, label: 'out'},
                    ],

                }

            },
            mounted() {
                this.getRecord();
                this.getDropdownItem([
                    'directorates',
                    'documentTypes',
                    'statuses',
                ]);
            },
            created() {
                // this.getNotifications();
            },

            methods: {

                // getNotifications() {
                //     // axios.get('/notifications')
                //         .then(response => {
                //             this.notifications = response.data;
                //             console.log('here kkkkkk', response.data);
                //         })
                //         .catch(error => {
                //             console.error('Error fetching notifications:', error);
                //         });
                // },
                validation: function () {
                    let flag = false;
                    if(this.showDocTtitle){
                        if (!this.trackerForm.title) {
                            this.errors.title =  "@lang('validation.title_is_required')";
                            flag = true;
                        }
                    }
                    if (!this.selected_type) {
                        this.errors.doc_type = "@lang('validation.in_out_is_not_selected')"
                        flag = true;
                    }

                    if (!this.selected_doc_type) {
                        this.errors.document_type = "@lang('validation.document_type_is_not_selected')";
                        flag = true;
                    }

                    if (this.selected_type.label === 'internal' && !this.selected_receiver_employee) {
                        this.errors.receiver_employee = "@lang('validation.receiver_employee_is_not_selected')";
                        flag = true;
                    }
                    if (this.selected_type.label === 'external') {
                        if (!this.selected_in_out) {
                            this.errors.in_out = "@lang('validation.document_status_is_not_selected')";
                            flag = true;
                        }
                        if (!this.selected_external_directorate) {
                            this.errors.external_directorate = "@lang('validation.directorate_is_not_selected')";
                            flag = true;
                        }
                        if (this.selected_in_out && this.selected_in_out.label === 'in') {
                            if (!this.selected_receiver_employee) {
                                this.errors.receiver_employee = "@lang('validation.receiver_employee_is_not_selected')";
                                flag = true;
                            }
                        }
                    }
                    return flag;
                },

                truncateText(text) {
                    if (!text) {
                        return '';
                    }
                    const maxLength = 40;
                    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                },
                markNotificationAsRead(notificationId) {
                    axios.put(`/notifications/${notificationId}/markAsRead`)
                        .then(response => {
                            // Update your component state as needed
                            this.getNotifications();  // Refresh the notifications after marking one as read
                        })
                        .catch(error => {
                            console.error('Error marking notification as read:', error);
                        });
                },

                showSearch() {
                    this.show_search = true;
                },
                /**
                 * get record from api
                 */
                getRecord: _.debounce((page = vm.page) => {
                    vm.showLoading = true;
                    axios.get(vm.url
                        + '&current_page=' + page
                        + '&per_page=' + vm.perPage
                        + '&in_num=' + vm.searchForm.in_num
                        + '&out_num=' + vm.searchForm.out_num
                        + '&in_date=' + vm.searchForm.in_date
                        + '&from_date=' + vm.searchForm.from_date
                        + '&to_date=' + vm.searchForm.to_date
                        + '&out_date=' + vm.searchForm.out_date
                        + '&receiver_directorate_id=' + vm.searchForm.receiver_directorate_id?.id
                        + '&receiver_employee_id=' + vm.searchForm.receiver_employee_id?.id
                        + '&sender_employee_id=' + vm.searchForm.sender_employee_id
                        + '&focal_point_name=' + vm.searchForm.focal_point_name
                        + '&title=' + vm.searchForm.title
                        + '&phone_number=' + vm.searchForm.phone_number
                        + '&type=' + vm.searchForm.selected_type?.label
                        + '&in_out=' + vm.selected_in_out?.label
                        + '&doc_type_id=' + vm.selected_doc_type?.id
                        + '&status_id=' + vm.selected_status?.id
                    ).then((response) => {
                        vm.showLoading = false;
                        if (response.data) {
                            console.log('here is trackers data', response.data)
                            vm.page = response.data.current_page;
                        }
                        vm.apiData = response.data;
                    })
                        .catch((error) => {
                            console.log(error);
                        });
                }, 200),

                editRecord(id) {
                    window.location.href = `{!!url('documents/')!!}/edit/${id}`;
                },
                viewRecord(id) {
                    window.location.href = `{!!url('documents/')!!}/show/${id}`;
                },
                detailsRecord(id) {
                    window.location.href = `{!!url('documents/')!!}/show/${id}`;
                },
                // delete record
                deleteRecord(id = null) {
                    deleteItem(`documents/${id}`);
                },

                closeModal() {
                    this.isModalOpen = false;
                },
            }
        });

    </script>
@endsection
