@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <!--wrapper-->
    <div class="wrapper">
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
                    <div class="breadcrumb-title ps-3">{{__('general_words.home')}}</div>
                    <div class="pe-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="/dashboard"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">{{ __('permission.user_list') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="row" id="app" v-cloak>
                    <div class="col-xl-12 mx-auto">
                        <div class="card border-top border-0">
                            <div class="card-title d-flex justify-content-between">
                                <div class="d-flex align-items-center mb-0">
                                    <i class="fadeIn animated bx bx-menu"></i>
                                    <h5 class="mb-0 fc-title">{{ __('permission.user_list') }}  </h5><br>
                                </div>
                                <div class="col-1 hover-text mt-1">
                                    <a href="{{url('user')}}" class="btn btn-outline-light">
                                    <i class="fadeIn animated bx bx-left-arrow-alt me-1"
                                    ></i>
                                    <span id="top" class="tooltip-text">Back</span></a>
                                </div>
                            </div>
                            <div class="card-body">
                                    <!-- finish discrption -->
                                    <form class="p-4" action="{{route('user.update',$user->id)}}"
                                          @submit="handleSubmit($event)"
                                        method="post" id="userForm">
                                        @csrf
                                        @method('patch')
                                        <div class="fc9-form row">
                                            <div class="col-md-4">
                                                <div class="row mb-3">
                                                    <div class="form-floating">
                                                        <label for="name" class="label">{{__('general_words.name')}}</label>
                                                        <input type="text" required v-model="form.name"
                                                        placeholder="{{__('general_words.name')}}" class="form-control"
                                                        id="name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row mb-3">
                                                    <div class="form-floating">
                                                        <label for="email" class="label">{{__('general_words.email')}}</label>
                                                        <input type="email" required v-model="form.email"
                                                        placeholder="{{__('general_words.email')}}" class="form-control"
                                                        id="email">
                                                        <div v-if="duplicateEmail"
                                                        style="color:red">{{__('general_words.email_already_exist')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row mb-3">
                                                    <div class="form-floating">
                                                        <label for="inputEmail"
                                                        class="label">{{__('permission.permission')}}</label>

                                                        <multiselect v-model="selected_role" :options="roles" :multiple="true"  :group-select="true" placeholder="@lang('permission.permission')" track-by="name" label="name"><span slot="noResult">Oops! No elements found. Consider changing the search query.</span></multiselect>
                                                    {{-- <pre class="language-json"><code><span v-for="(role,index) in selected_role">@{{role.name}},</span></code></pre> --}}
                                                        <p><span v-for="(role,index) in selected_role">@{{role.name}},</span></p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row mb-3">
                                                <div class="form-floating">
                                                    <label class="label">{{ __('general_words.employee') }}</label>
                                                    <v-select :options="employees" @search="employeeSearch"
                                                        label="full_name" v-model="selected_employee"
                                                        placeholder="@lang('general_words.employee')"></v-select>
                                                    <p>
                                                        @{{ selected_employee?selected_employee.name:null }}
                                                        <span v-show="selected_employee">{{ __('general_words.son') }}</span>
                                                        @{{ selected_employee?selected_employee.father_name:null
                                                        }}
                                                        <span v-show="selected_employee">-</span>
                                                        @{{ selected_employee?selected_employee.position:null }}
                                                        <span v-show="selected_employee">-</span>
                                                        @{{ selected_employee?selected_employee.directorate_name:null }}
                                                    </p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row mb-3">
                                                    <div class="form-floating">
                                                        <label for="inputEmail"
                                                        class="label">{{__('general_words.position')}}</label>
                                                        <v-select :options="positions" @search="searchDirectorate"
                                                        label="name" v-model="selected_position"
                                                        placeholder="@lang('general_words.position')"></v-select>
                                                        <input type="hidden" name="position"
                                                        :value="selected_position?selected_position.id:null">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row mb-3">
                                                    <div class="form-floating">
                                                        <label for="password"
                                                        class="label">{{__('general_words.password')}}</label>
                                                        <input type="password" @input="checkPassword" v-model="form.password"
                                                        autocomplete="new-password"
                                                        placeholder="{{__('general_words.password')}}"
                                                        class="form-control" id="password">
                                                        <div v-show="lengthFlag"
                                                        style="color:red">{{__('general_words.password_constraint')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row mb-3">
                                                    <div class="form-floating">
                                                        <label for="repeat-password"
                                                        class="label">{{__('general_words.repeat_password')}}</label>
                                                        <input @input="checkCurrentPassword"  type="password"
                                                        v-model="form.repeat_password"
                                                        placeholder="{{__('general_words.repeat_password')}}"
                                                        class="form-control" id="repeat-password">
                                                        <div v-show="flag"
                                                        style="color:red">{{__('general_words.password_not_match')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col mb-5 d-flex justify-content-end">
                                            <button type="button"
                                                    @click="handleSubmit($event)"
                                                :disabled="flag || duplicateEmail || lengthFlag || !selected_position || !selected_role"
                                                class="btn btn-outline-success px-3 detail-btn ms-1 mb-1">@lang('general_words.update')
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- finish discrption -->
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!-- model start -->


    <!-- model End -->
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->

@endsection
@section('scripts')
    <script type="module">

        var vm = new Vue({
            el: '#app',
            components: {},
            data() {
                return {
                    roles: {!!$roles!!},
                    new_roles:[],
                    user: {!!$user!!},
                    positions: {!!$positions!!},
                    userRole:{!! $userRole !!},
                    employees: {!!$employees!!},
                    selected_position: null,
                    selected_employee: null,
                    selected_role: null,
                    disable: false,
                    duplicateEmail: false,
                    lengthFlag: false,
                    flag: false,
                    form: {
                        password: null,
                        role_ids: [],
                        position_id: null,
                        email: null,
                        name: null,
                        employee_id: null,
                        repeat_password: null,
                    }
                }
            },
            computed:
                {},
            created() {
                this.editUser();
            },
            methods: {
                editUser() {
                    this.selected_employee = this.user.selected_employee;
                    this.form.email = this.user.email;
                    this.form.name = this.user.name;
                    this.form.password = this.user.password;
                    this.form.repeat_password = this.user.repeat_password;
                    if (this.userRole.length) {
                        this.selected_role = this.userRole;
                    }
                },

                checkCurrentPassword() {
                    this.flag = this.form.password != this.form.repeat_password;
                },
                checkPassword() {
                    this.lengthFlag = this.form.password.length < 8;
                },
                handleSubmit(e) {
                    console.log('this is selected role',this.selected_role)
                    for (let i = 0; i < this.selected_role.length; i++) {
                        if(this.form.role_ids[i] !=this.selected_role[i].id )
                        this.form.role_ids.push(this.selected_role[i].id)
                    }
                    this.form.position = this.selected_position.id;
                    this.form.employee_id = this.selected_employee.id;
                    e.preventDefault();
                    let url = (e.target.form == undefined) ? e.target.action : e.target.form.action;
                    axios.patch(url, this.form)
                        .then(function (response) {
                            if (response.data.status == 200) {
                                showMessage(response.data.message, 'success');
                                // window.location.href = "{{route('user.index')}}";
                            } else {
                                showMessage(response.data.message, 'warning');
                            }
                        })
                        .catch(function (error) {

                        })
                },

            }
        });

    </script>
@endsection
