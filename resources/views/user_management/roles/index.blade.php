@extends('layouts.master')
@section('title')
    - لیست کاربران
@endsection
@section('content')
    <div id="app" v-cloak>
        <!-- Breadcrumb -->
        <d-header :title="'Roles List'" :show-icon="false"></d-header>
        <div class="w-full bg-white rounded-lg shadow mt-1 dark:bg-gray-800">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <h3 class="text-3xl font-bold dark:text-white"></h3>
                @if(hasPermission(['role_create']))
                <div
                    class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <add-new href="{{ route('role.create') }}" :btn_name="`{{__('user_management.add_role')}}`"/>
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
                           :limit="1" :filterRecord="getRecord"
                           @delete-method-action="deleteRecord">
                    <template slot="tbody">
                        <tbody v-show="!apiData.data || showLoading">
                        <tr v-for="skeleton in 4">
                            <td v-for="skeleton in 4">
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
                                @{{record.name}}
                            </td>
                            <td scope="row"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.created_at}}
                            </td>
                            <td scope="row"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @{{record.description}}
                            </td>
                            <td scope="row"
                                class="px-1 py-1 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <action-btn @edit="editRecord(record.id)" @info="viewRecord(record.id)"
                                            @delete="deleteRecord(record.id)" :permissions="permissions"/>
                            </td>
                        </tr>

                        </tbody>

                    </template>
                </datatable>
            </div>

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
                    url: '{{route("roles.index")}}?',
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            sort: false,
                        },
                        {
                            label: "@lang('general_words.name')",
                            name: 'name',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.created_at')",
                            name: 'created_at',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.description')",
                            name: 'description',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
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
                    directorates: {!! $directorates !!},
                    page: 1,
                    selected_dir: null,
                    name_en: null,
                    name_ps: null,
                    name_prs: null,
                    name: null,
                    email: null,
                    directorate_id: null,
                    date: null,
                    permissions: {
                        delete: "{!! hasPermission(['role_delete']) !!}",
                        edit: "{!! hasPermission(['role_edit']) !!}",
                        view: "{!! hasPermission(['role_view']) !!}",
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
                    vm.directorate_id = vm.selected_dir ? vm.selected_dir.id : null,
                        axios.get(vm.url
                            + '&current_page=' + page
                            + '&name_en=' + vm.name_en
                            + '&name_ps=' + vm.name_ps
                            + '&directorate_id=' + vm.directorate_id
                            + '&email=' + vm.email
                            + '&per_page=' + vm.perPage)
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
                editRecord(id) {
                    window.location.href = `{!!url('role/')!!}/edit/${id}`;
                },
                viewRecord(id) {
                    window.location.href = `{!!url('role/')!!}/show/${id}`;
                },
                // delete record
                deleteRecord(id = null) {
                    deleteItem(`role/${id}`);
                },
            }
        });
    </script>
@endsection
