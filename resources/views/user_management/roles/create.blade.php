@extends('layouts.master')
@section('title')
    سیستم اسناد
@endsection
@section('content')
    <div id="app" v-cloak>
        <!-- Breadcrumb -->
        <d-header :title="'@lang('user_management.create_role')'" :show-icon="true" :url="`{{ route("roles.index") }}`"></d-header>
        <div class="w-full bg-white rounded-lg shadow mt-1 dark:bg-gray-800">
            <div class="mt-2">
                <form class="p-4 needs-validation" action="{{route('role.store')}}"
                      @submit="handleSubmit($event)" method="post">
                    @csrf
                    <div class="fc9-form row">
                        <!-- col-md-6 end -->
                        <div class="grid md:grid-cols-2 md:gap-6 p-2">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> @lang('user_management.role_name')</label>
                                <input type="text" id="first_name"  name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="@lang('user_management.typing_role_name')" required>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('user_management.description')</label>
                                <textarea id="message"  name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="@lang('user_management.typing_description')"></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 border-r-2">
                            <input type="hidden" name="permission_id" id="permission_id">
                            <div v-for="(item, g_index) of permission_group" :key="g_index">
                                <div class="bg-white shadow-md p-3">
                                    <h5 class="bg-transparent border-b border-gray-300 mt-0">
                                        <input type="checkbox"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                               @click="checkPoint(item.permission_group_id, 0, 'parent')"
                                               :id="item.permission_group_name"
                                               :checked="item.checked">
                                        @{{ item.permission_group_name }}
                                    </h5>
                                    <div class="p-3">
                                        <p v-for="(permissions, p_index) in item.permissions" :key="p_index">
                                            <input type="checkbox"
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                   @click="checkPoint(item.permission_group_id, permissions.permission_id, 'child')"
                                                   :id="'perm_' + permissions.permission_id"
                                                   :value="permissions.permission_name"
                                                   :checked="permissions.checked">
                                            @{{ permissions.permission_name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- save button -->
                    <div class="text-right py-2">
{{--                        <save-btn   @click="handleSubmit($event)" :disabled="disable" :icon="'save'"--}}
{{--                                  :btn_name="'Save Role'" :loading_text="'Document is saving'"/>--}}
                        <button type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600
                        hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800
                         shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg
                         text-sm px-5 py-2.5 text-center mr-2 mb-2" @click="handleSubmit($event)">@lang('user_management.save_role')</button>

                    </div>

{{--                    <div class="col mb-5 d-flex justify-content-end hover-text">--}}
{{--                        <button type="button" :disabled="disable" @click="handleSubmit($event)"--}}
{{--                                class="btn btn-outline-success position-relative px-5 detail-btn">--}}
{{--                                            <span class="tooltip-text"--}}
{{--                                                  id="top">{{ __('general_words.save')}}</span> {{ __('general_words.save')}}--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>

        var permission_group = {!! $permission_data !!};
        var vm = new Vue({
            el: '#app',
            data: {
                permission_group: permission_group,
                permission: [],
                selected_permission: [],
                select_all: false,
                disable: false,
                pWidth: 'height:400px'
            },
            mounted: function () {
            },
            created() {
                this.permission_group.sort((a, b) => b.permissions.length - a.permissions.length);
            },
            methods: {
                //handle check and uncheck or permission
                checkPoint(p_g_id, p_id, type) {

                    if (type == 'all') {
                        this.select_all = !this.select_all;
                        if (this.select_all == true) {

                            for (var i = 0; i < this.permission_group.length; i++) {
                                for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                                    this.permission_group[i].permissions[m].checked = true;
                                }
                                this.permission_group[i].checked = true;

                            }
                        } else {
                            for (var i = 0; i < this.permission_group.length; i++) {
                                for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                                    this.permission_group[i].permissions[m].checked = false;
                                }
                                this.permission_group[i].checked = false;

                            }
                        }
                    }
                    //begin parent
                    if (type == 'parent') {
                        for (var i = 0; i < this.permission_group.length; i++) {
                            if (this.permission_group[i].permission_group_id == p_g_id) {
                                this.permission_group[i].checked = !this.permission_group[i].checked;
                                var flag = this.permission_group[i].checked;
                                for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                                    this.permission_group[i].permissions[m].checked = flag;
                                }
                            }
                        }
                    }

                    // end parent


                    //begin child

                    if (type == 'child') {
                        for (var i = 0; i < this.permission_group.length; i++) {

                            let flag_temp = false;
                            for (var m = 0; m < this.permission_group[i].permissions.length; m++) {
                                if (p_id == this.permission_group[i].permissions[m].permission_id) {
                                    var temp = !this.permission_group[i].permissions[m].checked;
                                    this.permission_group[i].permissions[m].checked = temp;
                                }

                                if (this.permission_group[i].permissions[m].checked == false) {
                                    flag_temp = true;
                                    this.permission_group[i].checked = false;
                                }


                            }

                            if (flag_temp == false) {
                                // this.permission_group[i].checked = true;
                            }

                        }
                    }
                    // end child


                    let check_all_check = false;
                    for (var i = 0; i < this.permission_group.length; i++) {
                        for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                            if (this.permission_group[i].permissions[m].checked == false) {
                                check_all_check = true;
                            }
                        }

                    }

                    if (check_all_check == true) {
                        // not check all
                        this.select_all = false;
                    } else {
                        this.select_all = true;
                    }

                },

                /**
                 * handleSubmit
                 */
                handleSubmit(e, type = 'save') {
                    let selected_p = [];
                    for (var i = 0; i < this.permission_group.length; i++) {
                        for (var m = 0; m < this.permission_group[i].permissions.length; m++) {

                            if (this.permission_group[i].permissions[m].checked) {
                                selected_p.push(this.permission_group[i].permissions[m].permission_id);
                            }
                        }

                    }
                    document.getElementById('permission_id').value = selected_p;
                    let url = (e.target.form == undefined) ? e.target.action : e.target.form.action;
                    let data = (e.target.form == undefined) ? $(e.target).serialize() : $(e.target.form).serialize();

                    axios.post(url, data)
                        .then(function (response) {
                            if (response.data.status == 200) {
                                showMessage(response.data.message, 'success');
                                window.location.href = "{{route('roles.index')}}";
                            } else {
                                showMessage(response.data.message, 'warning');
                            }

                        })
                        .catch(function (error) {

                        })
                },
                /**
                 * this is used to set default value
                 */
                defaultValue(e) {
                    $(e.target.form).trigger('reset');
                    this.permission_group = permission_group;
                    this.permission = [];
                    this.selected_permission = [];
                },

            }
        });
    </script>
@endsection
