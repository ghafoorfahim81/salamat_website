@extends('layouts.master')
@section('title')
    Reports
@endsection
@section('content')
    <div id="app" v-cloak>
        <d-header :title="'@lang('user_management.reports_list')'" :show-icon="false"></d-header>
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-block">

                                <div class="border-b border-gray-200 dark:border-gray-700">
                                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                                        <li class="me-2">
                                            <a href="#" @click="getDirectorateReportData"
                                               :class="show_directorate_report?'border-b-2 border-blue-600 text-blue-600':null"
                                               class="inline-flex items-center justify-center p-4 rounded-t-lg dark:text-blue-500 dark:border-blue-500 group"
                                               aria-current="page">
                                                <svg class="w-4 h-4 me-2 text-blue-600 dark:text-blue-500"
                                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                     fill="currentColor" viewBox="0 0 18 18">
                                                    <path
                                                        d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                                </svg>
                                                @lang('report.directorates_report')
                                            </a>
                                        </li>
                                        <li class="me-2">
                                            <a href="#" @click="generalReport"
                                               :class="show_general_report?'border-b-2 border-blue-600 text-blue-600':null"
                                               class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                                <svg
                                                    class="w-4 h-4 me-2 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M5 11.424V1a1 1 0 1 0-2 0v10.424a3.228 3.228 0 0 0 0 6.152V19a1 1 0 1 0 2 0v-1.424a3.228 3.228 0 0 0 0-6.152ZM19.25 14.5A3.243 3.243 0 0 0 17 11.424V1a1 1 0 0 0-2 0v10.424a3.227 3.227 0 0 0 0 6.152V19a1 1 0 1 0 2 0v-1.424a3.243 3.243 0 0 0 2.25-3.076Zm-6-9A3.243 3.243 0 0 0 11 2.424V1a1 1 0 0 0-2 0v1.424a3.228 3.228 0 0 0 0 6.152V19a1 1 0 1 0 2 0V8.576A3.243 3.243 0 0 0 13.25 5.5Z"/>
                                                </svg>
                                                @lang('report.general_report')
                                            </a>
                                        </li>
                                        <li class="me-2">
                                            <a href="#"
                                               @click="rankingReport"
                                               :class="show_ranking_report?'border-b-2 border-blue-600 text-blue-600':null"
                                               class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                                <svg
                                                    class="w-4 h-4 me-2 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor" viewBox="0 0 18 20">
                                                    <path
                                                        d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                                                </svg>

                                                @lang('report.ranking')

                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div id="default-tab-content">
                                    <div v-show="show_directorate_report"
                                         class=" p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile"
                                         role="tabpanel" aria-labelledby="profile-tab">
                                        @include('reports.directorate_reports')
                                    </div>
                                    <div v-show="show_general_report" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800"
                                         id="dashboard"
                                         role="tabpanel" aria-labelledby="dashboard-tab">
                                        @include('reports.general_reports')
                                    </div>
                                    <div v-show="show_ranking_report"
                                         class=" p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings"
                                         role="tabpanel" aria-labelledby="settings-tab">
                                        @include('reports.ranking-report')
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
        @endsection

        {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}
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
                            show_general_report: false,
                            directorateReportsData: [],
                            show_directorate_report: true,
                            selected_directorate: null,
                            //General report codes
                            generalReportsData: [],
                            generalReportProperties: {
                                subject: '',
                                in_num: '',
                                out_num: '',
                                from_date: '',
                                in_date: '',
                                to_date: '',
                                receiver_directorate_id: '',
                                receiver_employee_id: '',
                                sender_employee_id: '',
                                sender_directorate_id: '',
                                focal_point_name: '',
                                phone_number: '',
                                doc_type: '',
                                document_type: '',
                            },
                            docTypes: [
                                {name: `{{__('document.internal')}}`, label: 'internal'},
                                {name: `{{__('document.external')}}`, label: 'external'},
                                ],
                                inOut: [
                                    {name: `{{__('document.sadera')}}`, label: 'sadera'},
                                    {name: `{{__('document.wareda')}}`, label: 'wareda'},
                                ],
                            selected_in_out: null,
                            selected_sender_employee: null,
                            selected_receiver_employee: null,
                            selected_deadline: null,
                            selected_deadline_type: null,
                            selected_status: null,
                            selected_security_level: null,
                            selected_followup_type: null,
                            selected_type: null,
                            selected_doc_type: null,
                            selected_deputy: null,
                            selected_receiver_directorate: null,
                            selected_sender_directorate: null,
                            //    Ranking report
                            show_ranking_report: false,
                            rankingReportData: [],
                            selected_order_status: null,
                            ranking_download_loading: false,
                            directorate_download_loading: false,
                            general_download_loading: false,


                        }
                    },
                    created() {
                        this.getDirectorateReportData();
                        this.getDropdownItem(['directorates', 'documentTypes'])
                    },
                    methods: {
                        getDirectorateReportData() {
                            this.show_directorate_report = true;
                            this.show_ranking_report = false;
                            this.show_general_report = false;
                            this.loading = true;
                            axios.get('get-report-data', {
                                params: {
                                    directorate_id: this.selected_directorate ? this.selected_directorate.id : null,
                                    type: 'directorates_report'
                                }
                            })
                                .then((response) => {
                                    this.loading = false;
                                    this.directorateReportsData = response.data;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                            ;
                        },
                        generalReport() {
                            this.show_general_report = true;
                            this.show_directorate_report = false;
                            this.show_ranking_report = false;
                        },
                        getGeneralReportData() {
                            this.loading = true;
                            axios.get('get-report-data', {
                                params: {
                                    in_num: this.generalReportProperties.in_num,
                                    out_num: this.generalReportProperties.out_num,
                                    from_date: this.generalReportProperties.from_date,
                                    to_date: this.generalReportProperties.to_date,
                                    receiver_directorate_id: this.selected_receiver_directorate?.id,
                                    sender_directorate_id: this.selected_sender_directorate?.id,
                                    receiver_employee_id: this.selected_receiver_employee?.id,
                                    sender_employee_id: this.selected_sender_employee?.id,
                                    focal_point_name: this.generalReportProperties.focal_point_name,
                                    phone_number: this.generalReportProperties.phone_number,
                                    doc_type: this.selected_doc_type?.label,
                                    document_type: this.selected_type?.id,
                                    sadera_wareda: this.selected_in_out?.label,
                                    type: 'general_report'
                                }
                            })
                                .then((response) => {
                                    this.loading = false;
                                    this.generalReportsData = response.data;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                            ;
                        },
                        rankingReport() {
                            this.show_general_report = false;
                            this.show_directorate_report = false;
                            this.show_ranking_report = true;
                            this.getDropdownItem(['statuses']).then(() => {
                                this.selected_order_status = this.statuses.find(item => item.slug == 'completed')
                            })
                            this.getRankingData();
                        },
                        getRankingData() {
                            this.loading = true;
                            axios.get('get-report-data', {
                                params: {
                                    order_status: this.selected_order_status ? this.selected_order_status.slug : 'completed',
                                    type: 'ranking_report'
                                }
                            })
                                .then((response) => {
                                    this.loading = false;
                                    this.rankingReportData = response.data;
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                            ;
                        },
                        resetForm() {
                            this.generalReportProperties.in_num = '';
                            this.generalReportProperties.out_num = '';
                            this.generalReportProperties.in_date = '';
                            this.generalReportProperties.out_date = '';
                            this.generalReportProperties.receiver_directorate_id = '';
                            this.generalReportProperties.receiver_employee_id = '';
                            this.generalReportProperties.sender_employee_id = '';
                            this.generalReportProperties.sender_directorate_id = '';
                            this.generalReportProperties.focal_point_name = '';
                            this.generalReportProperties.phone_number = '';
                            this.generalReportProperties.doc_type = '';
                            this.generalReportProperties.document_type = '';
                            this.selected_sender_employee = null;
                            this.selected_receiver_employee = null;
                            this.selected_deadline = null;
                            this.selected_deadline_type = null;
                            this.selected_status = null;
                            this.selected_security_level = null;
                            this.selected_followup_type = null;
                            this.selected_type = null;
                            this.selected_doc_type = null;
                            this.selected_deputy = null;
                            this.selected_receiver_directorate = null;
                            this.selected_sender_directorate = null;
                        },

                        openModal() {
                            this.isModalOpen = true;
                        },
                        closeModal() {
                            this.isModalOpen = false;
                        },

                        handleDecline() {
                            this.isModalOpen = false;

                            // this.closeModal();
                        },
                        exportRankingReport() {
                            this.ranking_download_loading = true;
                            let filename = this.selected_order_status.slug == 'completed' ? "@lang('report.completed_trackers')" : this.selected_order_status.slug == 'approved' ?
                                "@lang('report.approved_trackers')" : this.selected_order_status.slug == 'pending' ? "@lang('report.pending_trackers')" : this.selected_order_status.slug == 'ongoing' ?
                                    "@lang('report.ongoing_trackers')" : this.selected_order_status.slug == 'rejected' ? "@lang('report.rejected_trackers')" : "@lang('report.not_completed_trackers')";
                            axios({
                                method: "get",
                                url: "{{url('excel')}}?type=" + 'ranking_report' +
                                    '&order_status=' + this.selected_order_status.slug,
                                responseType: "blob"
                            }).then(response => {
                                this.ranking_download_loading = false;
                                let Fformat = ".xlsx";
                                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                                var fileLink = document.createElement("a");
                                fileLink.href = fileURL;
                                fileLink.setAttribute("download", "@lang('report.most')".concat(' ').concat(filename).concat(".xlsx"));
                                document.body.appendChild(fileLink);
                                fileLink.click();
                            })
                                .catch((error) => {
                                    // reject(error);
                                    console.log(error);
                                });
                        },
                        exportGeneralReport() {
                            // this.general_download_loading = true;
                            axios.get('excel', {
                                params: {
                                    in_num: this.generalReportProperties.in_num,
                                    out_num: this.generalReportProperties.out_num,
                                    from_date: this.generalReportProperties.from_date,
                                    to_date: this.generalReportProperties.to_date,
                                    receiver_directorate_id: this.selected_receiver_directorate?.id,
                                    sender_directorate_id: this.selected_sender_directorate?.id,
                                    receiver_employee_id: this.selected_receiver_employee?.id,
                                    sender_employee_id: this.selected_sender_employee?.id,
                                    focal_point_name: this.generalReportProperties.focal_point_name,
                                    phone_number: this.generalReportProperties.phone_number,
                                    doc_type: this.selected_doc_type?.label,
                                    document_type: this.selected_type?.id,
                                    type: 'general_report'
                                },
                                responseType: "blob"
                            })
                                .then(response => {
                                    this.general_download_loading = false;
                                    let Fformat = ".xlsx";
                                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                                    var fileLink = document.createElement("a");
                                    fileLink.href = fileURL;
                                    fileLink.setAttribute("download", 'General report'.concat(".xlsx"));
                                    document.body.appendChild(fileLink);
                                    fileLink.click();
                                })
                                .catch((error) => {
                                    // reject(error);
                                    console.log(error);
                                });
                        },
                        exportDirectorateReport() {
                            this.directorate_download_loading = true;
                            let filename = (this.selected_directorate && this.selected_directorate.name)
                                ? this.selected_directorate.name
                                : "directorate_report"; // Make sure this is translated or handled appropriately

                            axios.get('excel', {
                                responseType: "blob", // Moved responseType here
                                params: {
                                    directorate_id: this.selected_directorate ? this.selected_directorate.id : null,
                                    type: 'directorate_report'
                                }
                            }).then(response => {
                                this.directorate_download_loading = false;
                                let blob = new Blob([response.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
                                var fileURL = window.URL.createObjectURL(blob);
                                var fileLink = document.createElement("a");
                                fileLink.href = fileURL;
                                fileLink.setAttribute("download", filename + ".xlsx");
                                document.body.appendChild(fileLink);
                                fileLink.click();
                                document.body.removeChild(fileLink); // Clean up
                            })
                                .catch((error) => {
                                    this.directorate_download_loading = false; // Ensure loading is set to false even if there is an error
                                    console.error(error);
                                });
                        }

                    }
                });
            </script>
@endsection
