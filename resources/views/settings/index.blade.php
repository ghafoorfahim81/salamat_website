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
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">{{__('general_words.home')}}</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active"
                                    aria-current="page">{{__('general_words.settings')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-success" role="tablist">     
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#Item-Type" role="tab"
                                   aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-title">{{__('general_words.item_type')}}</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#Item-Status" role="tab"
                                   aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-title">{{__('general_words.item_status')}}</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#hangar" role="tab" aria-selected="false"
                                   tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-title">{{__('general_words.hangar')}}</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#motamed" role="tab"
                                   aria-selected="false" tabindex="-1">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-title">{{__('general_words.motamed')}}</div>
                                    </div>
                                </a>
                            </li>
                           
                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade" id="hangar" role="tabpanel">
                                <div class="item-list">
                                    <div class="table-responsive table-style">
                                        @include('settings.hangars.hangar')
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="motamed" role="tabpanel">
                                <div class="item-list">
                                    <div class="table-responsive table-style">
                                        @include('settings.motamed.motameds')
                                    </div>
                                </div>

                            </div>
                    
                            <div class="tab-pane fade" id="Item-Type" role="tabpanel">
                                <div class="item-list">
                                    <div class="table-responsive table-style">
                                        @include('settings.item_type.itemtype')
                                    </div>
                                </div>
                                <!-- end of tab -->
                            </div>
                            <div class="tab-pane fade" id="Item-Status" role="tabpanel">
                                <div class="item-list">
                                    <div class="table-responsive table-style">
                                        @include('settings.itemstatus.itemstatus')
                                    </div>
                                </div>
                                <!-- end of tab -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!-- Category -->
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                    class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
@endsection
