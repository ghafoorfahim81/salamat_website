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
                            <h5 class="mb-0 fc-title">{{ __('general_words.hangar') }}</h5>
                        </div>

                            <div class="mt-2">
                            <div class="blink ms-4">
                                    <i v-show="disable" class="fadeIn animated bx bx-arrow-back arrow1"></i>
                                    <btn :label="'@lang('general_words.hangar')'" @click="openModal"
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
                                                <div class="col-md-4">
                                                        <div class="row mb-3 select2-sm">
                                                            <div class="form-floating">
                                                                <label for="inputChoosePassword2"
                                                                class="label">{{ __('general_words.name_in_prs')}}
                                                                :*</label>
                                                                <input :disabled="disable" type="text" v-model="name_prs" 
                                                                        id="fecen9_number" class="form-control" placeholder="{{ __('general_words.name_in_prs') }}">
                                                            </div>
                                                        </div>
                                                </div>
                                                        <div class="col-md-4">
                                                                <div class="row mb-3 select2-sm">
                                                                    <div class="form-floating">
                                                                        <label  class="label">{{ __('general_words.name_in_ps') }}: </label>
                                                                        <input :disabled="disable" class="form-control" type="text" label="name"  v-model="name_ps"
                                                                        placeholder="{{ __('general_words.name_in_ps') }}">
                                                                    </div>
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
                                    <tr v-for="skeleton in 5">
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
                                    <tr v-for="(record,index) in apiData.data" :key="record.id">
                                        <td> @{{index + 1}}</td>
                                        <td> @{{record.name_en}}</td>
                                        <td> @{{record.name_prs}}</td>
                                        <td> @{{record.name_ps}}
                                        <td> @{{record.description}}
                                       
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
                        @include('settings.hangars.create-edit-modal')
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
                    url: '{{route("setting.hangars.index")}}?',
                    columns: [
                        {
                            label: "@lang('general_words.number')",
                            name: 'id',
                            sort: true,
                            activeSort: true,
                            order_direction: 'desc',
                        },
                        {
                            label: "@lang('general_words.name_in_en')",
                            name: 'name',
                        },
                        {
                            label: "@lang('general_words.name_in_prs')",
                            name: 'last_name',
                        },
                        {
                            label: "@lang('general_words.name_in_ps')",
                            name: 'name_en',
                        },
                        {
                            label: "@lang('general_words.description')",
                            name: 'name_en',
                        },
                        {
                            label: "@lang('general_words.action')",
                            name: 'action',
                        }
                    ],
                    apiData: {},
                    appPerPage: '{!!perPage(1) !!}',
                    perPage: "{{perPage()}}",
                    disable: false,
                    name_prs: null,
                    name_ps: null,
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
                       name_en:null,
                       name_ps:null,
                       name_prs:null,
                       description:null,
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
                            + '&current_page=' + page
                            + '&name_prs=' + vm.name_prs
                            + '&name_ps=' + vm.name_ps
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
                    deleteItem(`setting/directorate/${id}`);
                },
                openModal(){
                    $('#AddHangarModal').modal('show');
                },
                saveItems() {
                    this.save_item_loader = true;
                    axios.post("{{route('setting.hangars.store')}}", this.form).then((res) => {
                        let response = res.data;
                        if (response.status == 200) {
                            this.save_item_loader = false;
                            $('#AddHangarModal').modal('hide');
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

                    $('#AddHangarModal').modal('show');
                   // this.selected_dir = this.directorates.find((e) => e.id == this.directorate_id);
                    axios.get(`{!!url('setting/hangars')!!}/${id}`).then((res) => {
                        let data = res.data;
                        // console.log('data', data);
                        this.loading = false;
                        this.form.name_en = data.name_en;
                        this.form.name_prs = data.name_prs;
                        this.form.name_ps = data.name_ps;
                        this.form.description = data.description;
                        this.id=data.id;
                    });
                },
                updateItems() {
                    this.save_item_loader = true;
                    axios.patch(`{!!url('setting/hangars')!!}/${this.id}`, this.form).then((res) => {
                        let response = res.data;
                        console.log('response', response);
                        if (response.status == 200) {
                            $('#AddHangarModal').modal('hide');
                            showMessage(response.message, 'success');
                            this.$set(this.apiData.data, this.rowIndex, response.hangar)
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
                    this.form.name_en = null;
                    this.form.name_prs = null;
                    this.form.name_ps = null;
                    this.form.description = null;
                    this.isEdit=false;
                },
             
            }
        });
    </script>
@endsection
