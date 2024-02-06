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
                            <h5 class="mb-0 fc-title">{{ __('general_words.item') }}</h5>
                        </div>
                            <div class="mt-2">
                            <div class="blink ms-4">
                                    <i v-show="disable" class="fadeIn animated bx bx-arrow-back arrow1"></i>
                                    <btn :label="'@lang('general_words.add_item')'" @click="openModal"
                                    :icon="'bx bx-plus-circle align-middle'" :btn_class="'arrow btn btn-outline-success px-3 detail-btn ms-1 mb-1'"></btn>
                                </div>
                            </div>
                    </div>
                    <div class="card-body card-body1 p-4">
                        <!-- Search -->
                        <div class="accordion accordion1" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                        <i class="bx bx-search"></i> {{ __('general_words.search') }}
                                    </button>

                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                     data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <div class="p-4">
                                            <form class="row g-3 needs-validation" novalidate="">
                                                <div class="col-md-4 select2-sm">
                                              
                                                    <div class="form-floating">
                                                    <label  class="label">{{ __('general_words.unit_of_measure') }}: </label>
                                                        <v-select :options="unit_of_measures"
                                                        label="name"  v-model="selected_measure"
                                                        placeholder="{{ __('general_words.unit_of_measure') }}"></v-select>
                                                      
                                                    </div>
                                                </div>
                                                <div class="col-md-4 select2-sm">
                                              
                                                <div class="form-floating">
                                                    <label class="label">{{ __('general_words.item_type') }}: </label>
                                                    <v-select :options="item_types"
                                                    label="name"  v-model="selected_item_type"
                                                    placeholder="{{ __('general_words.item_type') }}"></v-select>
                                                </div>
                                                </div>
                                                <div class="col-md-4 select2-sm">
                                              
                                                <div class="form-floating">
                                                <label class="label">{{ __('general_words.category') }}: </label>
                                                    <v-select :options="categories"
                                                    label="name"  v-model="selected_category"
                                                    placeholder="{{ __('general_words.category') }}"></v-select>
                                                </div>
                                                </div>
                                                <div class="col-12 d-flex flex-row-reverse mt-4">
                                                    <btn :label="'@lang('general_words.reset')'"
                                                         :icon="'fadeIn animated bx bx-reset'" 
                                                         @click="resetForm(); getRecord()"></btn>

                                                    <btn :label="'@lang('general_words.search')'"
                                                         :tooltip_text="'@lang('general_words.search')'"
                                                         :icon="'bx bx-search'" @click="getRecord()"
                                                         :loading="showLoading"></btn>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end Seaerch -->
                        <div class="spinner-border text-info" v-show="loading" style="z-index:999999999; position: absolute; left: 50%;
                            top: 35%; width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden"> @include('general_files.loading')</span>
                        </div>
                        <div class=" ">
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
                                    <tr v-for="(record,index) in apiData.data" :key="record.id">
                                        <td> @{{index + 1}}</td>
                                        <td> @{{record.name}}</td>
                                        <td> @{{record.category}}</td>
                                        <td> @{{record.item_type}}
                                        <td> @{{record.measure}}
                                        </td>
                                        <td>
                                            <div class="p-1" role="group">
                                                <div class="d-flex justify-content-center order-actions">
                                                    <div class="hover-text">
                                                                    <edit-btn @click="editRecord(record.id,index)"
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
                        @include('settings.items.create-edit-modal')
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
                    url: '{{route("setting.item.index")}}?',
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
                            name: 'fecen9_number',
                        },
                        {
                            label: "@lang('general_words.category')",
                            name: 'fecen9_number',
                        },
                        {
                            label: "@lang('general_words.item_type')",
                            name: 'fecen9_number',
                        },
                        {
                            label: "@lang('general_words.unit_of_measure')",
                            name: 'status',
                        },
                        {
                            label: "@lang('general_words.action')",
                            name: 'action',
                        }
                    ],
                    apiData: [],
                    appPerPage: '{!!perPage(1) !!}',
                    perPage: "{{perPage()}}",
                    categories: {!! $categories !!},
                    item_types: {!! $item_types !!},
                    unit_of_measures: {!! $unit_of_measures !!},
                    // unit_of_measures: [],
                    // page: 1,
                    // selected_dir: null,
                    // fc9_number: null,
                    // directorate_id: null,
                    // date: null,
                    items: {!! $items !!},
                    disable: false,
                    category_id: null,
                    item_type_id:null,
                    selected_item:null,
                    selected_item_type: null,
                    selected_category: null,
                    // unit_measure_id:null,
                    selected_measure: null,
                    loading: null,
                    show_search: null,
                    selectedRows: [],
                    rowIndex: null,
                    isEdit: false,
                    loading:false,
                    check_item_loader:false,
                    save_item_loader:false,
                    id: null,
                    form: {
                        category_id: null,
                        item_type_id: null,
                        unit_of_measure_id: null,
                        name_en: null,
                        name_prs: null,
                        name_ps: null,
                        quantity_threshold: null,
                        description: null,
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
                checkDuplication() {
                    if(this.itemData.length>=1)
                    {
                        this.check_item_loader =true;
                        let url = "{{route('is_duplicate')}}";
                        axios.get(url
                            + '?table_name=' + 'items' +
                            '&foreign_key=' + 'category_id' +
                            '&foreign_key_id=' + this.category_id +
                            '&employee_id=' + this.selected_employee.id +
                            '&check_id=' + this.selected_item.id
                        )
                            .then((response) => {
                                this.check_item_loader =false;
                                if (response.data == 1) {
                                    showMessage("{{ __('general_words.this_item_already_exist')}}", 'warning');
                                    this.selected_item = null
                                } else {
                                    console.log('sss')
                                }
                            })
                            .catch(function (error) {
                            });
                    }
                },
                getRecord: _.debounce((page = vm.page) => {
                    vm.showLoading = true;
                    vm.unit_measure_id = vm.selected_measure ? vm.selected_measure?.id : null,
                    vm.category_id = vm.selected_category ? vm.selected_category?.id : null,
                    vm.item_type_id = vm.selected_item_type ? vm.selected_item_type?.id : null,
                        axios.get(vm.url
                            + '&current_page=' + page
                            + '&category_id=' + vm.category_id
                            + '&item_type_id=' + vm.item_type_id
                            + '&unit_measure_id=' + vm.unit_measure_id
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
                    $('#AddItemModal').modal('show');
                },
                resetForm() {
                    this.selected_item = null;
                    this.selected_dir = null;
                    this.selected_employee = null;
                    this.selected_category = null;
                    this.selected_measure = null;
                    this.selected_item_type = null;
                    this.form.name_en = null;
                    this.form.name_ps = null;
                    this.form.name_prs = null;
                    this.form.description = null;
                    this.isEdit=false;
                },
                saveItems() {
                    this.save_item_loader = true;
                    this.form.category_id = this.selected_category ? this.selected_category.id : null;
                    this.form.item_type_id = this.selected_item_type ? this.selected_item_type.id : null;
                    this.form.unit_of_measure_id = this.selected_measure ? this.selected_measure.id : null;
                    axios.post("{{route('setting.item.store')}}", this.form).then((res) => {
                        let response = res.data;
                        if (response.status == 200) {
                            this.save_item_loader = false;
                            $('#AddItemModal').modal('hide');
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
                    $('#AddItemModal').modal('show');
                    axios.get(`{!!url('setting/item')!!}/${id}`).then((res) => {
                        let data = res.data;
                        this.loading = false;
                        this.form.name_prs = data.name_prs;
                        this.form.name_ps = data.name_ps;
                        this.form.name_en = data.name_en;
                        this.form.name_en = data.name_en;
                        this.selected_category = data.selected_category;
                        this.selected_measure = data.selected_measure;
                        this.selected_item_type = data.selected_item_type;
                        this.form.description = data.description;
                        this.form.quantity_threshold = data.quantity_threshold;
                        this.id=data.id;
                    });
                },
                updateItems() {
                    this.form.category_id = this.selected_category ? this.selected_category.id : null;
                    this.form.unit_of_measure_id = this.selected_measure ? this.selected_measure.id : null;
                    this.form.item_type_id = this.selected_item_type ? this.selected_item_type.id : null;
                    this.save_item_loader = true;
                    axios.patch(`{!!url('setting/item')!!}/${this.id}`, this.form).then((res) => {
                        let response = res.data;
                        console.log('response', response);
                        if (response.status == 200) {
                            $('#AddItemModal').modal('hide');
                            showMessage(response.message, 'success');
                            this.$set(this.apiData.data, this.rowIndex, response.item)
                            this.resetForm();
                            this.save_item_loader = false;
                            this.isEdit = false;
                        } else {
                            this.save_item_loader = false;
                            showMessage(response.message, 'warning');
                        }
                    });
                },
            }
        });
    </script>
@endsection
