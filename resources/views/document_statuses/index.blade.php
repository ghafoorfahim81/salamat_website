@extends('layouts.master')
@section('title')
@endsection
@section('content')
    <div id="app" v-cloak>
        <!-- Breadcrumb -->
        <d-header :title="`{{__('setting.document_status_list')}}`" :show-icon="false"></d-header>


        <div class="w-full bg-white rounded-lg shadow mt-1 dark:bg-gray-800">
            <!--- Top Title and add button --->
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <h3 class="text-3xl m-230 font-bold dark:text-white"></h3>
                @if(hasPermission(['document_status_create']))
                <div
                    class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <add-new @click="openModal" :btn_name="`{{__('setting.add_document_status')}}`"/>
                </div>
                    @endif
            </div>

            <!--- dataTable -->
            <div class="mt-2">
                <datatable ref="child" :per-page="{{perPage()}}"
                           :no-record-found-text="'@lang('general_words.no_record_found')'"
                           :search="'@lang('general_words.search')'"
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
                        <tr v-for="skeleton in 3">
                            <td v-for="skeleton in 3">
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
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"> @{{index
                                + 1}}
                            </td>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.name}}
                            </td>

                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">

                                <action-btn @edit=editRecord(record.id) :permissions="permissions"/>
                            </td>
                        </tr>

                        </tbody>

                    </template>
                </datatable>
            </div>
            @include('document_statuses.create-edit-modal')


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
                    loading: false,
                    showLoading: false,
                    url: '{{route("document-status.index")}}?',
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('setting.document_status')",
                            sort: true,
                            name: 'name',
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
                    loading: null,
                    show_search: null,
                    save_status_loader: false,
                    selectedRows: [],
                    isModalOpen: false,
                    form: {
                        name: '',

                    },
                    permissions: {
                        delete: "{!! hasPermission(['document_status_delete']) !!}",
                        edit: "{!! hasPermission(['document_status_edit']) !!}",
                        view: "{!! hasPermission(['document_status_view']) !!}",
                    },

                }
            },
            mounted() {
                this.getRecord();
            },
            methods: {
                /**
                 * get record from api
                 */
                getRecord: _.debounce((page = vm.page) => {
                    vm.showLoading = true;
                    axios.get(vm.url
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
                resetForm() {
                    this.name = '';
                },

                openModal() {
                    this.isModalOpen = true;
                },
                handleSubmit() {
                    if (this.isEdit) {
                        this.updateRecord();
                    } else {
                        this.saveRecord();
                    }
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                handleDecline() {
                    this.isModalOpen = false;

                    // this.closeModal();
                },

                saveRecord() {
                    if (this.form.name && this.form.name !== ' ') {
                        this.save_status_loader = true;
                        axios.post("{{route('document-status.store')}}", this.form).then((res) => {
                            let response = res.data;
                            if (response.status == 200) {
                                this.save_status_loader = false;
                                this.isModalOpen = false;
                                showMessage(response.message, 'success');
                                this.getRecord();
                                this.resetForm();
                            } else {
                                this.save_status_loader = false;
                                showMessage(response.message, 'warning');
                            }
                        });
                    }
                },

                editRecord(id = null, index) {
                    console.log('editRecord', id);
                    this.rowIndex = index;
                    this.isEdit = true;
                    this.id = id;
                    this.isModalOpen = true;
                    axios.get(`{!!url('document-status/edit')!!}/${id}`).then((res) => {
                        this.form.name = res.data.name;
                    });
                },
                updateRecord() {
                    if (this.form.name && this.form.name !== ' ') {
                        this.save_status_loader = true;
                        axios.patch(`{!!url('document-status/update')!!}/${this.id}`, this.form).then((res) => {
                            let response = res.data;
                            if (response.status == 200) {
                                this.isModalOpen = false;
                                showMessage(response.message, 'success');
                                this.$set(this.apiData.data, this.rowIndex, response.item)
                                this.resetForm();
                                this.getRecord();
                                this.save_status_loader = false;
                                this.isEdit = false;
                            } else {
                                this.save_status_loader = false;
                                showMessage(response.message, 'warning');
                            }
                        });
                    }
                },

                // delete record
                deleteRecord(id = null) {

                    Swal.fire({
                        title: "{{ __('general_words.are_you_sure')}}",
                        text: "{{ __('general_words.wont_be_to_revert')}}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonText: "{{ __('general_words.cancel_it')}}",
                        cancelButtonColor: '#d33',
                        confirmButtonText: "{{ __('general_words.yes_delete')}}"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(`{!! url('followup-types/${id}') !!}`).then((response) => {
                                if (response.status === 200) {
                                    showMessage(response.message, 'success');
                                } else {
                                    showMessage(" انجام نشد ", 'success');
                                }
                            })
                        } else {
                            Swal.fire(
                                "{{ __('general_words.not_deleted')}}",
                                "{{ __('general_words.record_is_safe')}}",
                                'success'
                            )
                        }
                    })
                },
            }
        });
    </script>
@endsection

