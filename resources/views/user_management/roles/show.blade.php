@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <!--wrapper-->
    <div class="wrapper">
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content" id="app" v-cloak>
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">{{__('general_words.home')}}</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">View FC9</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="row">
                    <div class="col-xl-12 mx-auto">
                        <div class="card border-top border-0">
                            <div class="card-body">
                                <div class="p-4 row">
                                    <div class="card-title d-flex mr-auto justify-content-between">
                                        <h5 class="mt-2">{{ __('fc9.fc9_view') }}</h5>
                                        <div class="p-2">
                                            <button type="button" @click="openModal" class="btn btn-outline-light"><i
                                                        class="bx bx-cloud-upload me-1" style="color: #5e01e7;"></i>
                                            </button>
                                            <a href="{{url('print','fc9')}}/{{$fecen9->id}}"
                                               class="btn btn-outline-light"><i class="bx bx-printer me-1"
                                                                                style="color: #000;"></i></a>
                                            <a href="{{url('excel','fc9')}}/{{$fecen9->id}}"
                                               class="btn btn-outline-light"><i class="bx bx-note me-1"
                                                                                style="color: #5e01e7;"></i></a>
                                            <a href="{{url('fc9')}}" class="btn btn-outline-light">
                                                <i class="fadeIn animated bx bx-left-arrow-alt me-1"
                                                   style="color: rgb(0, 0, 0);"></i>
                                                <span id="top" class="tooltip-text">Back</span></a>
                                        </div>
                                    </div>
                                    <hr/>
                                    <!-- col-md-7 end -->
                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="fc9-form row">
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="inputEnterRFPNumber"
                                                           class="col-sm-4 col-form-label">{{ __('fc9.fc9_number') }}
                                                        :</label>
                                                    <div class="col-sm-8">
                                                        <label class="formedit">{{ $fecen9->fecen9_number }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-6 end -->
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="inputEmailAddress2"
                                                           class="col-sm-4 col-form-label">{{ __('general_words.issue_date') }}
                                                        : *</label>
                                                    <div class="col-sm-8">
                                                        <label class="formedit">{{ $fecen9->issue_date }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end of col -->
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="inputEnterRFPNumber"
                                                           class="col-sm-4 col-form-label">{{ __('general_words.directorate') }}
                                                        :</label>
                                                    <div class="col-sm-8">
                                                        <label class="formedit">{{ $fecen9->dir_name }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row mb-3">
                                                    <label for="inputEnterRFPNumber"
                                                           class="col-sm-4 col-form-label">{{ __('general_words.requested_by') }}
                                                        :</label>
                                                    <div class="col-sm-8">
                                                        <label class="formedit">{{ $fecen9->name }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-6 end -->
                                            <!-- end of col -->
                                        </div>
                                        <div class="item-list">
                                            <h6>{{ __('fc9.fc9_detail') }}:*</h6>
                                            <div class="table-responsive">
                                                <table class="table mb-0 borderbtm">
                                                    <thead class="table-light">

                                                    <tr>
                                                        <th>{{ __('general_words.number') }}</th>
                                                        <th>{{ __('general_words.item') }}</th>
                                                        <th>{{ __('general_words.item_specification') }}</th>
                                                        <th>{{ __('general_words.quantity') }}</th>
                                                        <th>{{ __('fc9.requested_for') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($fecen9_details as $fc9_detail)
                                                        <tr>
                                                            <td>
                                                                <label class="formedit">{{ $loop->iteration }}</label>
                                                            </td>
                                                            <td>
                                                                <label class="formedit">{{ $fc9_detail->name }}</label>
                                                            </td>
                                                            <td>
                                                                <label
                                                                        class="formedit">{{ $fc9_detail->description }}</label>
                                                            </td>
                                                            <td>
                                                                <label
                                                                        class="formedit">{{ $fc9_detail->quantity }} {{ $fc9_detail->unit_of_measure_name_prs}}</label>
                                                            </td>
                                                            <td>
                                                                <label
                                                                        class="formedit">{{ $fc9_detail->employee }}</label>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- save button -->

                                        <!-- end save button -->
                                    </form>
                                    <!-- finish discrption -->
                                </div>
                            </div>
                        </div>
                        @include('general_files.attachment-modal')
                    </div>
                </div>
                <!--end row-->
            </div>

        </div>
        <!-- model -->


        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                    class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        @endsection
        @section('scripts')
            <script type="module">

                var vm = new Vue({
                    el: '#app',
                    components: {},
                    data() {
                        return {
                            table_id: {!! $fecen9->id !!},
                            file: null,
                            loading: false,
                            attachmentList: {!! $attachments !!},
                            file_name: '',
                        }
                    },
                    created() {
                    },
                    methods: {
                        openModal() {
                            $('#attachment-modal').modal('show');
                        },
                        onFileChange(e) {
                            this.file = e.target.files[0];
                        },
                        upload() {
                            this.loading = true;
                            const formData = new FormData();
                            formData.append("attachment", this.file);
                            let url = "{{route('upload')}}";
                            axios.post(url + '?table_id=' + this.table_id + '&table_name=' + 'fecen9s' + '&file_name=' + this.file_name, formData, {
                                headers: {
                                    "Content-Type": "multipart/form-data",
                                },
                            })
                                .then((res) => {
                                    let response = res.data;
                                    if (response.result) {
                                        this.loading = false;
                                        this.file_name = '';
                                        this.attachmentList.push(response.lastFile)
                                        showMessage("{{ __('general_words.upload_success')}}", 'success');
                                    } else {
                                        showMessage("{{ __('general_words.something_went_wrong')}}", 'warning');
                                    }
                                });
                        },

                    }
                });

            </script>
@endsection


