@extends('layouts.master')
@section('title')
    سیستم مدیریت اسناد
@endsection
@section('content')

    <div class="page-wrapper" id="app1" v-cloak>
        <div class="page-content flex space-x-4">
            <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 flex-shrink-0">
                <div class="flex justify-between items-start w-full">
                    <div class="flex-col items-center">
                        <div class="flex items-center mb-1">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1"></h5>
                        </div>
                    </div>
                </div>
                <div class="py-6" id="pie-chart">
                </div>
            </div>

            <div class="block w-full max-w-[18rem] rounded-lg bg- shadow-md dark:bg-neutral-700">
                <label class="font-bold mr-4">  @lang('general_words.top_five_directorates')</label>
                <ul class="w-full bg-white dark:bg-blue-700 p-4 rounded-lg divide-y divide-neutral-200">

                    <li v-for="topFive in topFiveDirectorate"
                        class="px-4 py-3 dark:border-opacity-50 mt-0.5 rounded-md bg-blue-300">
                        <div class="flex justify-between items-center">
                            <div class="text-black font-bold "> @{{topFive.name_prs}}</div>
                            <div class="text-black font-bold"> @{{topFive.document_count}}</div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="block w-full max-w-[18rem] rounded-lg bg- shadow-md dark:bg-neutral-700">
                {{--                <div class="text-black font-bold "> @{{ dataForLetter.length > 0 ? dataForLetter[0].slug : 'No Slug' }}</div>--}}
                <div class="text-black font-bold ">  @lang('general_words.letters')</div>
                <ul class="w-full bg-white dark:bg-blue-700 p-4 rounded-lg divide-y divide-neutral-200">
                    <div class="text-black font-bold "></div>

                    <li v-for="dataForLetters in dataForLetter"
                        class="px-4 py-3 dark:border-opacity-50 mt-0.5 rounded-md bg-blue-300">
                        <div class="flex justify-between items-center">
                            <div class="text-black font-bold "> @{{dataForLetters.name}}</div>
                            <div class="text-black font-bold"> @{{dataForLetters.total_count}}</div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="block w-full max-w-[18rem] rounded-lg bg- shadow-md dark:bg-neutral-700">
                {{--                <div class="text-black font-bold "> @{{ dataForSlugs.length > 0 ? dataForSlugs[0].slug : 'No Slug' }}</div>--}}
                <div class="text-black font-bold "> @lang('general_words.suggestions')</div>
                <ul class="w-full bg-white dark:bg-blue-700 p-4 rounded-lg divide-y divide-neutral-200">
                    <div class="text-black font-bold "></div>

                    <li v-for="dataFo in dataForSlugs"
                        class="px-4 py-3 dark:border-opacity-50 mt-0.5 rounded-md bg-blue-300">
                        <div class="flex justify-between items-center">
                            <div class="text-black font-bold "> @{{dataFo.name}}</div>
                            <div class="text-black font-bold"> @{{dataFo.total_count}}</div>
                        </div>
                    </li>
                </ul>
            </div>


            <div class="block w-full max-w-[18rem] rounded-lg bg- shadow-md dark:bg-neutral-700">
                {{--                <div class="text-black font-bold "> @{{ dataForRequisition.length > 0 ? dataForRequisition[0].slug : 'No Slug' }}</div>--}}
                <div class="text-black font-bold ">@lang('general_words.requisitions')</div>
                <ul class="w-full bg-white dark:bg-blue-700 p-4 rounded-lg divide-y divide-neutral-200">
                    <div class="text-black font-bold "></div>

                    <li v-for="dataFo in dataForRequisition"
                        class="px-4 py-3 dark:border-opacity-50 mt-0.5 rounded-md bg-blue-300">
                        <div class="flex justify-between items-center">
                            <div class="text-black font-bold "> @{{dataFo.name}}</div>
                            <div class="text-black font-bold"> @{{dataFo.total_count}}</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{--        <div class="max-w-xs rounded overflow-hidden shadow-lg bg-blue-300 mt-2">--}}
        {{--            <div class="px-6 py-4">--}}
        {{--                <div class="text-md font-bold text-slate-900 mb-1">{{__('document.letters')}}</div>--}}
        {{--                <div class="flex mb-4">--}}
        {{--                    <div class="w-1/2">--}}
        {{--                        <p class="text-gray-700 text-base">Label One</p>--}}
        {{--                    </div>--}}
        {{--                    <div class="w-1/2">--}}
        {{--                        <p class="text-gray-700 text-base text-right">Date One</p>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="flex mb-4">--}}
        {{--                    <div class="w-1/2">--}}
        {{--                        <p class="text-gray-700 text-base">Label Two</p>--}}
        {{--                    </div>--}}
        {{--                    <div class="w-1/2">--}}
        {{--                        <p class="text-gray-700 text-base text-right">Data Two</p>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="flex flex-row">
            @foreach($saderaAndWareda as $doc)
                <dashboard-in-out
                    :title="'{{$doc->docType}}'"
                    :labels="['{{__('document.sadera')}}', '{{__('document.wareda')}}']"
                    :data="['{{$doc->sadera}}', '{{$doc->wareda}}']"
                ></dashboard-in-out>
            @endforeach
        </div>

     

        <div class="block w-full rounded-lg bg-white shadow dark:bg-neutral-700">
            <label class="font-bold"></label>
            <div class="p-4 md:p-6">
                <div id="column-chart"></div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript">
        let vm = new Vue({
            el: '#app1',
            data() {
                return {
                    todaySentTracker: [],
                    topFiveDirectorate: [],
                    todayTracker: [],
                    // dataForSlug:[],
                    dataForSlugs: {!! $dataForSlugs !!},
                    dataForRequisition: {!! $dataForRequisitions !!},
                    dataForLetter: {!! $dataForLetters !!},

                    // documentCountTypes: {},
                    documentCountTypes: {!! $documentCountTypes !!},
                    directoratesDocument: [],
                    directoratesSentDocument: {},
                    documentsCountByDirectorate: {},
                }
            },

            mounted() {
                this.fetchTodaySentTrackers();
                this.fetchTopFiveDirectorates();
                this.fetchTodayTrackers();
                this.fetchDocumentCountTypes();
                this.renderPieChart();
                this.renderColumnChart();
                this.fetchDataForSlugs();
            },
            methods: {
                renderPieChart() {
                    const getChartOptions = () => {
                        console.log('noMo:', this.documentCountTypes);
                        return {

                            series: Object.values(this.documentCountTypes),
                            colors: ["#1C64F2", "#16BDCA", "#9061F9"],
                            chart: {
                                height: 320,
                                width: "100%",
                                type: "pie",
                            },
                            stroke: {
                                colors: ["white"],
                                lineCap: "",
                            },
                            plotOptions: {
                                pie: {
                                    labels: {
                                        show: true,
                                    },
                                    size: "100%",
                                    dataLabels: {
                                        offset: -25
                                    }
                                },
                            },
                            labels: ["@lang('general_words.letters')", "@lang('general_words.suggestions')", "@lang('general_words.requisitions')"],
                            dataLabels: {
                                enabled: true,
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                },
                            },
                            legend: {
                                position: "bottom",
                                fontFamily: "Inter, sans-serif",
                            },
                            yaxis: {
                                labels: {
                                    formatter: function (value) {
                                        return value + "%"
                                    },
                                },
                            },
                            xaxis: {
                                labels: {
                                    formatter: function (value) {
                                        return value + "%"
                                    },
                                },
                                axisTicks: {
                                    show: false,
                                },
                                axisBorder: {
                                    show: false,
                                },
                            },
                        };
                    };

                    const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
                    chart.render();
                }, catch(error) {
                    console.error('e sjsjksdkjnd error:', error);
                },


                renderColumnChart() {
                    axios.get('{!! route("dashboard_data") !!}')
                        .then(response => {
                            console.log('Directorates Documents:', response.data.documentsCountByDirectorates);

                            const directoratesData = response.data.documentsCountByDirectorates;

                            // Check if the data is not empty
                            if (!directoratesData || Object.keys(directoratesData).length === 0) {
                                console.error('Empty or undefined data received for directoratesSentDocuments.');
                                return;
                            }

                            const categories = Object.keys(directoratesData);
                            const seriesData = categories.map(key => directoratesData[key]);

                            const chartOptions = {
                                colors: ["#1A56DB", "#FDBA8C"],
                                series: [
                                    {
                                        name: "@lang('general_words.sent_trackers')",
                                        data: seriesData.map(item => item.receivedTrackers),
                                    },
                                    {
                                        name: "@lang('general_words.received_trackers')",
                                        data: seriesData.map(item => item.sentTrackers),
                                    },
                                ],
                                chart: {
                                    type: "bar",
                                    height: "320px",
                                    fontFamily: "Inter, sans-serif",
                                    toolbar: {
                                        show: false,
                                    },
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: "70%",
                                        borderRadiusApplication: "end",
                                        borderRadius: 8,
                                    },
                                },
                                xaxis: {
                                    categories: categories,
                                },
                                tooltip: {
                                    enabled: true,
                                    y: {
                                        formatter: function (val) {
                                            return val + " documents";
                                        },
                                    },
                                },
                            };

                            if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
                                const chart = new ApexCharts(document.getElementById("column-chart"), chartOptions);
                                chart.render();
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching directorates documents data:', error);
                        });
                },


                // ...
                fetchTodaySentTrackers() {
                    axios.get('{!! route("dashboard_data") !!}')
                        .then(response => {
                            // console.log('DJHSDJ TODAYT', response.data.todaySentTrackers);

                            this.todaySentTracker = response.data.todaySentTrackers;
                        })
                        .catch(error => {
                            console.error('Error fetching todayTrackers data:', error);
                        });
                },

                fetchTopFiveDirectorates() {
                    axios.get('{!! route("dashboard_data") !!}')
                        .then(response => {
                            // console.log('s TODAYT', response.data.topFiveDirectorates);

                            this.topFiveDirectorate = response.data.topFiveDirectorates;
                        })
                        .catch(error => {
                            console.error('Error fetching todayTrackers data:', error);
                        });
                },

                fetchTodayTrackers() {
                    axios.get('{!! route("dashboard_data") !!}')
                        .then(response => {
                            // console.log('s dsdssdsddsss', response.data.todayTrackers);

                            this.todayTracker = response.data.todayTraackers;
                        })
                        .catch(error => {
                            console.error('Error fetching todayTrackers data:', error);
                        });
                },

                fetchDataForSlugs() {
                    axios.get('{!! route("dashboard_data") !!}')
                        .then(response => {
                            this.dataForSlug = response.data.dataForSlugs;
                            console.log('kjkjcskjcjkcjjc nskdjskjsd NOBS', response.data.dataForSlugs);

                        })
                        .catch(error => {
                            console.error('Error fetching todayTrackers data:', error);
                        });
                },


                fetchDocumentCountTypes() {
                    axios.get('{!! route("dashboard_data") !!}')
                        .then(response => {
                            console.log('NomoFetch', response.data.documentCountTypes);

                            this.documentCountTypes = response.data.documentCountTypes;
                            // this.renderPieChart();
                        })
                        .catch(error => {
                            console.error('Error fetching todayTrackers data:', error);
                        });
                }


// ...

            },
        });

    </script>
@endsection
