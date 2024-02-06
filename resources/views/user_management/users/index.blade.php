@extends('layouts.master')
@section('title')
@endsection
@section('content')
    <div id="app" v-cloak>
        <!-- Breadcrumb -->
        <d-header :title="`{{__('user_management.user_list')}}`":show-icon="false"></d-header>
        <div class="w-full bg-white rounded-lg shadow mt-1 dark:bg-gray-800">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <h3 class="text-3xl font-bold dark:text-white"></h3>
                @if(hasPermission(['user_create']))
                    <div
                        class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                        <add-new @click="openModal" :btn_name="`{{__('general_words.add_new')}}`"/>
                    </div>
                @endif

            </div>
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
                           :limit="1"
                >
                    <template slot="tbody">
                        <tbody v-show="!apiData.data || showLoading">
                        <tr v-for="skeleton in 6">
                            <td v-for="skeleton in 6">
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
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white"> @{{index
                                + 1}}
                            </td>
                            <td scope="row"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.employee_name}}
                            </td>
                            <td scope="row"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.directorate}}
                            </td>
                            <td scope="row"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.status}}
                            </td>
                            <td scope="row"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.email}}
                            </td>

                            <td scope="row"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <action-btn @edit="editRecord(record.id)" @delete="deleteRecord(record.id)"
                                            :permissions="permissions"
                                />
                            </td>
                        </tr>
                        </tbody>
                    </template>
                </datatable>
            </div>
            @include('user_management.users.create-edit-modal')

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
                    selected_directorate: '',
                    selected_employee: '',
                    selected_roles: null,
                    save_users_loader: false,
                    showToast: false,
                    isModalOpen: false,
                    disabled: false,
                    isEdit: false,
                    loading: false,
                    FormErrors: null,

                    url: '{{route("users.index")}}?',
                    form: {
                        user_name: '',
                        email: '',
                        directorate_id: null,
                        status: null,
                        employee_id: null,
                        role_id: [],
                        date: null,
                        user_id: null,
                        password: '',
                        repeat_password: '',
                    },
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            sort: false,
                        },
                        {
                            label: "@lang('general_words.name')",
                            name: 'user_name',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.directorate')",
                            name: 'directorate',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.status')",
                            name: 'status',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.email')",
                            name: 'email',
                            sort: true,
                        },

                        {
                            label: "@lang('general_words.action')",
                            name: 'action',
                            sort: false
                        }
                    ],
                    apiData: {},
                    appPerPage: '{!!perPage(1) !!}',
                    perPage: "{{perPage()}}",
                    page: 1,
                    record_id: null,
                    permissions: {
                        delete: "{!! hasPermission(['user_delete']) !!}",
                        edit: "{!! hasPermission(['user_edit']) !!}",
                        view: "{!! hasPermission(['user_view']) !!}",
                    },
                    errors:{
                        user_name:'',
                        directorate:'',
                        employee:'',
                        password:'',
                        role:'',
                        repeat_password: '',
                        compare_password:''
                    },
                }

            },
            mounted() {
                this.getRecord();
            },
            methods: {

                validation:function ()
                {
                    let flag=false;
                    if(this.form.user_name.trim() ===''){
                        flag = true;
                        this.errors.user_name = "@lang('validation.user_name_is_required')"
                    }
                    if(!this.selected_directorate){
                        flag = true;
                        this.errors.directorate = "@lang('validation.directorate_is_not_selected')"
                    }
                    if(!this.selected_employee){
                        flag = true;
                        this.errors.employee = "@lang('validation.employee_is_not_selected')"
                    }
                    if(!this.selected_roles){
                        flag = true;
                        this.errors.role = "@lang('validation.role_is_not_selected')"
                    }
                    if(this.form.password.trim() ==='' && !this.isEdit){
                        flag = true;
                        this.errors.password = "@lang('validation.password_is_required')"
                    }
                    if(this.form.repeat_password.trim() ==='' && !this.isEdit){
                        flag = true;
                        this.errors.repeat_password = "@lang('validation.repeat_password_is_required')"
                    }
                    if(this.form.password.trim() !== this.form.repeat_password.trim() && !this.isEdit){
                        flag = true;
                        console.log('this is the password validation',this.form.password.trim())
                        this.errors.compare_password = "@lang('validation.password_not_match')"
                    }
                    {{--if(this.form.password.trim().length < 8){--}}
                    {{--    flag = true;--}}
                    {{--    this.errors.password = "@lang('validation.password_is_short')"--}}
                    {{--}--}}
                    if(this.form.user_name.trim()){
                        axios.post('/check-username', { username: this.form.user_name })
                            .then(response => {
                                let usernameStatus = response.data.isAvailable;
                                if(usernameStatus === false){
                                    flag = true;
                                    console.log('this is a test',usernameStatus)
                                    this.errors.user_name = "@lang('validation.user_name_is_not_available')"
                                }
                                else{
                                    flag = false;
                                }
                            })
                            .catch(error => {
                                console.error('Error checking username:', error);
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                    return flag;

                },
                /**
                 * get record from api
                 */
                getRecord: _.debounce((page = vm.page) => {
                    vm.showLoading = true;
                    axios.get(vm.url
                        + '&current_page=' + page
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
                    this.getDropdownItem(['employees', 'directorates', 'roles'
                    ])
                    this.isModalOpen = true;

                },
                closeModal() {
                    this.resetForm();
                    this.isModalOpen = false;
                    this.isInfoModalOpen = false;
                },
                handleDecline() {

                    this.closeModal();
                },
                handleAccept() {

                    this.closeModal();
                },
                handleSubmit() {
                    if (this.isEdit) {
                        this.updateUsers();
                    } else {
                        this.saveUser();
                    }
                },
                resetForm() {
                    this.form.user_name = '';
                    this.form.email = '';
                    this.directorate_id = null;
                    this.status = null;
                    this.employee_id = null;
                    this.form.role_id = [];
                    this.selected_roles = null;
                    this.selected_employee = null;
                    this.selected_directorate = null;
                    this.form.date = null;
                    this.form.user_id = null;
                    this.form.password = '';
                    this.form.repeat_password = '';
                },


                saveUser() {
                    if (!this.validation()) {
                        this.save_users_loader = true;
                        let ids = [];
                        console.log('this is selected roles', this.selected_roles,' and this is the role_id',this.form.role_id)
                        for (let i = 0; i < this.selected_roles.length; i++) {
                            this.form.role_id.push(this.selected_roles[i].id)
                        }
                        this.form.directorate_id = this.selected_directorate?.id;
                        this.form.employee_id = this.selected_employee?.id;
                        axios.post("{{ route('user.store') }}", this.form).then((res) => {
                            let response = res.data;
                            if (response.status == 200) {
                                this.save_users_loader = false;
                                this.FormErrors = null;
                                this.getRecord();
                                this.isModalOpen = false;
                                showMessage(response.message, 'success');
                                this.resetForm();
                            } else {
                                this.save_users_loader = false;
                                showMessage('please check your form!', 'warning');
                            }

                        }).catch((error) => {
                            this.loading = false
                            this.save_users_loader = false;
                            // Handle error response (including validation errors)
                            if (error.response && error.response.status === 422) {
                                this.formErrors = error.response.data.errors;
                            } else {
                                console.error("Other Error: ", error);
                            }
                        });
                    }
                },

                editRecord(id = null, index) {
                    this.isEdit = true;
                    this.record_id = id;
                    this.getDropdownItem(['employees', 'directorates', 'roles'
                    ])
                    this.isModalOpen = true;
                    axios.get(`{!!url('user/')!!}/edit/${id}`).then((res) => {
                        this.selected_roles = res.data.roles.map(role => {
                            return this.roles.find(item => item.id === role.role_id);
                        });

                        this.selected_directorate = res.data.directorate;
                        this.selected_employee = res.data.employee.name;
                        this.form.user_name = res.data.user_name;
                        this.form.user_id = res.data.id;
                        this.form.email = res.data.email;
                        this.form.status = res.data.status;
                    });
                },

                updateUsers() {
                    if (!this.validation()) {
                        this.form.directorate_id = this.selected_directorate ? this.selected_directorate.id : null;
                        this.form.employee_id = this.selected_employee?.id;

                        this.form.role_id = this.form.role_id || [];

                        for (let i = 0; i < this.selected_roles.length; i++) {
                            this.form.role_id.push(this.selected_roles[i].id);
                        }

                        this.save_users_loader = true;
                        axios.patch(`/user/update/${this.form.user_id}`, this.form).then((res) => {
                            console.log('here is the data', res.data);
                            let response = res.data;
                            if (response.status == 200) {
                                this.FormErrors = null;
                                this.getRecord();
                                this.isModalOpen = false;
                                showMessage(response.message, 'success');
                                this.resetForm();
                                this.save_users_loader = false;
                                this.isEdit = false;
                            } else {
                                this.save_users_loader = false;
                                showMessage(response.message, 'warning');
                            }
                        }).catch((error) => {
                            this.save_users_loader = false;
                            if (error.response && error.response.status === 422) {
                                this.FormErrors = error.response.data.errors;
                            } else {
                                console.error("Other Error: ", error);
                            }
                        });
                    }
                },


                deleteRecord(id) {
                    deleteItem(`user/${id}`);
                },

            }
        });
    </script>
@endsection




