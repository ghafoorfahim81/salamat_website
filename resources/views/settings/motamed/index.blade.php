@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <div class="wrapper" id="app">
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-2">
                   
                <div class="breadcrumb-title pe-3">{{__('general_words.home')}}</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="/dashboard"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">{{__('general_words.settings')}}</li>
                            </ol>
                        </nav>
                    </div>
                    </div>
                <!-- End breadcrumb -->
              
                <div class="card radius-10">
                    <div class="card-title d-flex justify-content-between">
                        <div class="d-flex align-items-center mb-0">
                            <i class="fadeIn animated bx bx-menu"></i>
                            <h5 class="mb-0 fc-title">{{ __('general_words.motamed') }}</h5>
                        </div>
                            <div class="mt-2">
                            <div class="blink ms-4">
                                    <i v-show="disable" class="fadeIn animated bx bx-arrow-back arrow1"></i>
                                    <btn :label="'@lang('settings.add_motamed')'" @click="openModal"
                                    :icon="'bx bx-plus-circle align-middle'" :btn_class="'arrow btn btn-outline-success px-3 detail-btn ms-1 mb-1'"></btn>
                                </div>
                            </div>
                    </div>
                    <div class="card-body card-body1 p-4">
                        <!-- Search -->
                    
                        <!-- end Seaerch -->
                        <div class="spinner-border text-info" v-show="loading" style="z-index:999999999; position: absolute; left: 50%;
                            top: 35%; width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden"> @include('general_files.loading')</span>
                        </div>
                        <div class=" ">
                            <datatable ref="child" :per-page="{{perPage()}}"
                                       :no-record-found-text="'@lang('general_words.no_record_found')'"
                                       :search="'@lang('general_words.search')'"
                                       :search-placeholder-text="'@lang('general_words.name_father')'"
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
                                    <tr v-for="skeleton in 7">
                                        <td v-for="skeleton in 7">
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
                                    <tr v-for="(record,index) in apiData.data" :key="record.id">
                                        <td> @{{index + 1}}</td>
                                        <td> @{{record.name}}</td>
                                        <td> @{{record.father_name}}
                                        <td> @{{record.hangar_name}}
                                        </td>
                                        <td>
                                            <div class="p-1" role="group">
                                                <div class="d-flex justify-content-center order-actions">
                                                    <div class="hover-text">
                                                                    <edit-btn  @click="editRecord(record.id,index)"
                                                                              :tooltip_text="'@lang('general_words.edit')'"/>
                                                                </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>

                                </template>
                            </datatable>

                        </div>
                        @include('settings.motamed.create-edit-modal')
                    </div>
                </div>
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
                    url: '{{route("setting.motamed.index")}}?',
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.name')",
                            name: 'name',
                        },
                        {
                            label: "@lang('general_words.father_name')",
                            name: 'father_name',
                        },
                        {
                            label: "@lang('general_words.hangar')",
                            name: 'hangar',
                        },
                        {
                            label: "@lang('general_words.action')",
                            name: 'action',
                        }
                    ],
                    apiData: {},
                    appPerPage: '{!!perPage(1) !!}',
                    perPage: "{{perPage()}}",
                    hangar: {!! $hangar !!},
                    employees: {!! $employees !!},
                    disable: false,
                    selected_hangar: null,
                    loading: null,
                    show_search: null,
                    selectedRows: [],
                    rowIndex: null,
                    name:null,
                    father_name:null,
                    isEdit: false,
                    loading:false,
                    check_item_loader:false,
                    save_item_loader:false,
                    selected_employee: null,
                    id: null,
                    form: {
                        hangar_id:null,
                        employee_id:null
                      
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
                    vm.hangar_id = vm.selected_hangar ? vm.selected_hangar?.id : null,
                        axios.get(vm.url
                            + '&current_page=' + page
                            + '&name=' + vm.name
                            + '&hangar_id=' + vm.hangar_id
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
             
                deleteRecord(id = null) {
                    deleteItem(`setting/item/${id}`);
                },
                openModal(){
                    $('#AddMotamedModal').modal('show');
                },
                saveItems() {
                    this.save_item_loader = true;
                    this.form.employee_id = this.selected_employee ? this.selected_employee.id : null;
                    this.form.hangar_id = this.selected_hangar ? this.selected_hangar.id : null;
                    axios.post("{{route('setting.motamed.store')}}", this.form).then((res) => {
                        let response = res.data;
                        if (response.status == 200) {
                            this.save_item_loader = false;
                            $('#AddMotamedModal').modal('hide');
                            this.$emit('saveItems')
                            showMessage(response.message, 'success');
                            this.getRecord();
                            this.resetForm();
                            this.handleSubFormSubmit();
                        } else {
                            this.save_item_loader = false;
                            showMessage(response.message, 'warning');
                        }

                    });
                },
                editRecord(id = null, index) {
                    this.rowIndex = index;
                    this.isEdit = true;

                    $('#AddMotamedModal').modal('show');
                   this.selected_employee = this.employees.find((e) => e.id == this.employee_id);
                   this.selected_hangar = this.hangar.find((e) => e.id == this.hangar_id);
                    axios.get(`{!!url('setting/motamed')!!}/${id}`).then((res) => {
                        let data = res.data;
                        console.log('data', data);
                        this.loading = false;
                        this.selected_employee = data;
                        this.selected_hangar = data;
                        this.id=data.id;
                    });
                },
                updateItems() {
                    this.form.employee_id = this.selected_employee ? this.selected_employee.id : null;
                    this.save_item_loader = true;
                    axios.patch(`{!!url('setting/heiat')!!}/${this.id}`, this.form).then((res) => {
                        let response = res.data;
                        console.log('response', response);
                        if (response.status == 200) {
                            $('#AddMotamedModal').modal('hide');
                            showMessage(response.message, 'success');
                            this.$set(this.apiData.data, this.rowIndex, response.heiat)
                            this.resetForm();
                            this.save_item_loader = false;
                            this.isEdit = false;
                        } else {
                            this.save_item_loader = false;
                            showMessage(response.message, 'warning');
                        }
                    });
                },
                resetForm() {
                    this.name = null;
                    this.selected_employee = null;
                    this.form.start_date = null;
                    this.form.end_date = null;
                  
                   
                    this.isEdit=false;
                },
             
            }
        });
    </script>
@endsection
