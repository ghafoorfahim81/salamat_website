@extends('layouts.master')
@section('title')
    سیتم مدیریت اسناد| جزئیات سند
@endsection
@section('content')
    <div id="app" v-cloak :class="trackers.length>0?'w-full':''">
        <d-header :title="`{{__('document.document_show')}}`" :show-icon="true"
                  :url="`{{ route("documents.index") }}`">
        </d-header>

        <!-- component -->
        <div class="w-full bg-white shadow-xl rounded-lg flex overflow-x-auto custom-scrollbar">
            <div class="w-64 px-4">
                <div class="h-16 flex items-center">
                    <a href="#"
                       @click="openTrackerModal(false)"
                       class="w-48 mx-auto bg-blue-600 hover:bg-blue-700 flex items-center justify-center text-gray-100 py-2 rounded space-x-2 transition duration-150">
                        <i class="material-icons text-white">add</i>
                        <span>{{__('document.add_tracker')}}</span>
                    </a>
                </div>
                <div class="px-2 pt-4 pb-8 border-r border-gray-300">
                    <ul class="space-y-2">
                        <li>
                            <a class="hover:bg-gray-500 hover:bg-opacity-10 hover:text-blue-600 flex items-center text-gray-700 py-1.5 px-4 rounded space-x-2 cursor-pointer">
                                <i class="material-icons">toc</i>
                                <span class="font-medium">{{__('document.title')}}</span>
                            </a>
                            <p class="text-gray-500 mx-3 text-xs px-4">@{{document.title}}</p>
                        </li>
                        <li>
                            <a class="hover:bg-gray-500 hover:bg-opacity-10 hover:text-blue-600 flex items-center text-gray-700 py-1.5 px-4 rounded space-x-2 cursor-pointer">
                                <i class="material-icons">subject</i>
                                <span class="font-medium">{{__('document.subject')}}</span>
                            </a>
                            <p class="text-gray-500 mx-3 text-xs px-4">@{{document.subject}}</p>
                        </li>
                        <li>
                            <a class="hover:bg-gray-500 hover:bg-opacity-10 hover:text-blue-600 flex items-center text-gray-700 py-1.5 px-4 rounded space-x-2 cursor-pointer">
                                <i class="material-icons">description</i>
                                <span class="font-medium">{{__('document.description')}}</span>
                            </a>
                            <p class="text-gray-500 mx-3 text-xs px-4">@{{document.remark}}</p>
                        </li>
                        <li>
                            <a class="hover:bg-gray-500 hover:bg-opacity-10 hover:text-blue-600 flex items-center text-gray-700 py-1.5 px-4 rounded space-x-2 cursor-pointer">
                                <i class="material-icons">subject</i>
                                <span class="font-medium">{{__('document.date_difference')}}</span>
                            </a>
                            <p class="text-gray-500 mx-3 text-xs px-4">3</p>
                        </li>
                        <li>
                            <a class="hover:bg-gray-500 hover:bg-opacity-10 hover:text-blue-600 flex items-center text-gray-700 py-1.5 px-4 rounded space-x-2 cursor-pointer">
                                <i class="material-icons">calendar_month</i>
                                <span class="font-medium">{{__('document.entry_date')}}</span>
                            </a>
                            <p class="text-gray-500 text-xs mx-4 px-4">@{{document.created_at}}</p>
                        </li>
                        <li>
                            <a class="hover:bg-gray-500 hover:bg-opacity-10 hover:text-blue-600 flex items-center text-gray-700 py-1.5 px-4 rounded space-x-2 cursor-pointer">
                                <i class="material-icons">person</i>
                                <span class="font-medium">{{__('general_words.created_by')}}</span>
                            </a>
                            <p class="text-gray-500 mx-3 text-xs px-4">@{{document.user.user_name}}</p>
                        </li>
                        <li >
                            <a :href="'{{ url('print-receipt/') }}/' + document.id"
                               target="_blank"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                               Print
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex-1 px-2" v-show="!showTrackerDetails">
                <div class="h-16 flex  items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <div class="flex items-center ml-3">
                                <button title="Reload"
                                        @click="reloadTrackers"
                                        class="text-gray-700 px-2 py-1 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100">
                                    <svg v-if="!loading" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                         fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <svg aria-hidden="true" v-if="loading"
                                         class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                         viewBox="0 0 100 101" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0
                         22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50
                         91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921
                          9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227
                          92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698
                           1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874
                            41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347
                            21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                              fill="currentFill"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                {{--                <div class="relative items-center block max-w-sm p-6 bg-white border border-gray-100 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-800 dark:hover:bg-gray-700">--}}
                {{--                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white opacity-20">Noteworthy technology acquisitions 2021</h5>--}}
                {{--                    <p class="font-normal text-gray-700 dark:text-gray-400 opacity-80">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>--}}
                {{--                    <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">--}}
                {{--                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>--}}
                {{--                        <span class="sr-only">Loading...</span>--}}
                {{--                    </div>--}}
                {{--                </div>--}}


                <div class="bg-blue-200 mb-6 flex items-center rounded-md"
                     :class="loading?'opacity-30':''"
                     v-for="tracker in trackers">
                    <div
                        :class="{'bg-rose-200 flex justify-between rounded-md w-full hover:cursor-pointer': daysDifference(tracker.tracker_created_at, current_date) > tracker.request_deadline,
                                                  'flex justify-between rounded-md w-full hover:cursor-pointer ': true
                                                }"
                        @click="viewTracker(tracker.id)"
                    >
                        {{-- <div class="p-1">
                            <avatar :user-name="'Admin'"
                                    :profile-photo-path="null"></avatar>
                        </div> --}}

                        <div
                            class="relative w-8 mt-4 mx-1 h-8 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                            <svg class="absolute  text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>


                        <div class="flex-1 min-w-0 p-2 ">
                            <div class="text-sm font-medium text-gray-900 flex">
                                <i class="material-icons text-xs">forward_to_inbox</i> @{{ tracker.sender }}
                            </div>
                            <div class="flex">
                                <span class="material-icons text-xs">
                                        mail
                                        </span>
                                <p class="text-sm text-gray-500 truncate">
                                    @{{ tracker.receiver }}</p>

                            </div>
                            <div class="flex">
                                <input id="inline-checkbox" type="checkbox" value=""
                                       :checked="tracker.in_num"
                                       @change="openConfirmationPopup(tracker)"
                                       :disabled="tracker.in_num>0"
                                       class="w-4 h-4  text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-1 p-2">
                                <div class="mr-2">
                                    <span>{{__('document.out_number')}}: @{{ tracker.out_num }}@{{ tracker.out_doc_prefix?'-'+tracker.out_doc_prefix:null }}</span>

                                    <span class="mr-4">
                                    {{__('document.out_date')}}: @{{ tracker.out_date }}
                             </span>
                                    <span class="mr-4">
                                    {{__('document.in_date')}}: @{{ tracker.in_date }}
                             </span>
                                    <span class="mr-6">
                                    {{__('document.in_number')}}: @{{ tracker.in_num }}@{{ tracker.in_doc_prefix?'-'+tracker.in_doc_prefix:null }}
                             </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 p-2">
                            <span class="text-sm text-gray-500 p-2 mt-2">@{{ tracker.created_at }}</span>
                            <i class="w-4 h-4 material-icons">calendar_month</i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 mt-14" v-show="showTrackerDetails">
                <div class="bg-slate-100 py-3 rounded-md">
                    <div class="flex">
                        <i @click="showTrackerDetails =!showTrackerDetails" class="material-icons cursor-pointer">chevron_right</i>
                        <span>
                        @{{document.title}}
                    </span>
                    </div>
                </div>
                <div class="mt-2">
                    <div
                        class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="bg-gray-100 mb-6 flex items-center rounded-md">
                            <div class=" flex justify-between w-full"
                            >
                                <div class="p-1">
                                    <div
                                        class="relative inline-flex items-center justify-center w-16 h-16 overflow-hidden bg-white rounded-full dark:bg-gray-600">
                                        <template>
                                            <span class="font-medium text-gray-600 dark:text-gray-300">@{{ tracker.user }}</span>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0 p-2 mt-2">
                                    <div class="text-sm font-medium text-gray-900">@{{tracker.sender?.name}}</div>
                                    <div class="flex">
                                        <p class="text-sm text-gray-500 truncate">@{{tracker.receiver_emp?.name}}</p>
                                        <i class="material-icons cursor-pointer" @click="showReceivers(tracker.id)">keyboard_arrow_down</i>
                                    </div>
                                    <div v-show="show_receivers">
                                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('document.receivers') }}
                                            :</h2>
                                        <ol class="max-w-md space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400">
                                            <li v-for="(receiver, index) in receivers">
                                                <span class=" text-gray-900 dark:text-white">@{{ receiver.employee_name }}
                                            </li>

                                        </ol>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 p-2"
                                     v-show="(auth_emp_id==tracker.sender_employee_id) && permissions.edit">
                                    <span class="material-icons cursor-pointer"
                                          @click="editRecord(tracker.id)">edit</span>
                                </div>
                            </div>
                            <hr/>
                        </div>
                        <div>
                            <div class="grid grid-rows-subgrid gap-4 row-span-3">
                                <tracker-columns :value="tracker.type"
                                                 :label="`{{__('document.internal_external')}}`"></tracker-columns>
                                {{--                                    <div v-if="tracker.type=='external'">--}}
                                {{--                                        <tracker-columns :value="tracker.in_out" :label="`{{__('document.ext_in_out')}}`"></tracker-columns>--}}
                                {{--                                    </div>--}}
                                {{--                                        <tracker-columns :value="tracker.sender_external?.name" :label="`{{__('document.sender')}}`"></tracker-columns>--}}
                                {{--                                    <div v-if="tracker.type=='internal'">--}}
                                <tracker-columns :value="tracker.sender_dir?.name"
                                                 :label="`{{__('document.sender')}}`"></tracker-columns>
                                {{--                                    </div>--}}
                                <tracker-columns :value="tracker.receiver?.name"
                                                 :label="`{{__('document.receiver')}}`"></tracker-columns>
                                {{--                                    <tracker-columns :value="tracker.in_num" :label="`{{__('document.in_number')}}`"></tracker-columns>--}}
                            </div>
                            <div class="grid grid-rows-subgrid gap-4 row-span-3">
                                <tracker-columns :value="tracker.in_num"
                                                 :label="`{{__('document.in_number')}}`"></tracker-columns>
                                <tracker-columns :value="tracker.in_date"
                                                 :label="`{{__('document.in_date')}}`"></tracker-columns>
                                <tracker-columns :value="tracker.in_date"
                                                 :label="`{{__('document.in_date')}}`"></tracker-columns>
                                <tracker-columns :value="document.out_num"
                                                 :label="`{{__('document.out_number')}}`"></tracker-columns>
                            </div>
                            <hr class="mt-3"/>
                            <div class="bg-slate-100 rounded-md p-2 mt-5">
                                <div class="flex cursor-pointer" @click="showAttachment(tracker.id)">
                                    <i class="material-icons w-3 h-3">
                                        attach_file
                                    </i>
                                    <span class="font-medium">
                                        {{__('document.attachments')}}
                                       @{{ tracker.attachment_count }}
                                   </span>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4"
                                     >
                                    <div v-for="attachment in attachments">
                                        <img :src="getAttachmentPath(attachment?.file)" @click="downloadImage(attachment?.id)" class="h-72 max-w-full rounded-lg" alt="Comment Attachment">
                                    </div>
                                </div>

                                {{--                                        <div class="grid grid-rows-subgrid gap-4 row-span-3" v-for="attachment in attachments">--}}
                                {{--                                            <div class="row-start-2">--}}
                                {{--                                                --}}
                                {{--                                                <div v-if="isImage(attachment?.file)">--}}
                                {{--                                                    <!-- Render image -->--}}
                                {{--                                                    <img :src="getAttachmentPath(attachment?.file)" alt="Comment Attachment">--}}
                                {{--                                                </div>--}}
                                {{--                                                <div v-else>--}}
                                {{--                                                    <a :href="`{{url('/download')}}/${attachment?.id}`"--}}
                                {{--                                                       class="btn btn-outline-light text-blue-500">--}}
                                {{--                                                        @{{attachment?.file }}--}}
                                {{--                                                    </a>--}}
                                {{--                                                </div>--}}
                                {{--                                            --}}
                                {{--                                            </div> --}}
                                {{--                                        </div> --}}

                            </div>
                        </div>
                        <div class="">
                            @include('documents.comment')
                        </div>
                    </div>

                    <div v-if="confirmationPopup"
                         class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-8 border border-gray-300 z-50 rounded-md">
                        <div class="popup-content">
                            <p>Are you sure you want to update?</p><br>
                            <button @click="confirmUpdate" class="bg-green-500 text-white px-4 py-2 mr-2 rounded-md">
                                Yes
                            </button>
                            <button @click="cancelUpdate" class="bg-red-500 text-white px-4 py-2 rounded-md">No</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        @include('documents.create-edit-modal')
        @include('documents.attachment-modal')
        @include('documents.filter-modal')

    </div>
@endsection
@section('scripts')
    <script>
        var vm = new Vue({
            el: '#app',
            data() {
                return {
                    document: {!! $document !!},
                    current_date: "{!! now()->format('Y-m-d') !!}",
                    firstTracker: [],
                    title: null,
                    tracker: [],
                    receivers: [],
                    tracker_id: null,
                    isReceiverListModalOpen: false,
                    show_receivers: null,
                    show_attachment: null,
                    totalComments: 0,
                    showReplyActionButtons: false,
                    comments: [],
                    auth_user: "{!! auth()->user()->id !!}",
                    auth_emp_id: "{!! auth()->user()->employee_id !!}",
                    commentForm: {
                        comment_body: null,
                        attachment: null,
                        user_id: "{!! auth()->user()->id !!}",
                        tracker_id: null,
                        parent_id: null,
                    },
                    commentEditForm: {
                        comment_body: null,
                        attachment: null,
                        user_id: "{!! auth()->user()->id !!}",
                        tracker_id: null,
                        parent_id: null,
                    },
                    commentReplyForm: {
                        comment_body: null,
                        attachment: null,
                        user_id: "{!! auth()->user()->id !!}",
                        tracker_id: null,
                        parent_id: null,
                    },
                    replyEditForm: {
                        comment_body: null,
                        attachment: null,
                        user_id: "{!! auth()->user()->id !!}",
                        tracker_id: null,
                        parent_id: null,
                    },
                    replyingCommentId: null,
                    remark: null,
                    trackers: {!! $trackers !!},
                    isInfoModalOpen: false,
                    loading: false,
                    show_action_btn: false,
                    showSuggestions: false,
                    realTimeComment: null,
                    suggestedUsers: [],
                    isTrackerShowModalOpen: false,
                    showTrackerDetails: false,
                    showAddTracker: false,
                    latestFlow: "{!! $latestFlow !!}",
                    selected_ccType: 'employee',
                    isAttachmentModalOpen: false,
                    attachments: [],
                    permissions: {
                        delete: "{!! hasPermission(['tracker_delete']) !!}",
                        edit: "{!! hasPermission(['tracker_edit']) !!}",
                        view: "{!! hasPermission(['tracker_view']) !!}",
                        create: "{!! hasPermission(['tracker_create']) !!}",
                    },
                    docTypes: [
                        {name: `{{__('document.internal')}}`, label: 'internal'},
                        {name: `{{__('document.external')}}`, label: 'external'},
                    ],
                    selected_type: {name: `{{__('document.internal')}}`, label: 'internal'},

                    inOutDocument: [
                        {name: `{{__('document.incoming')}}`, label: 'in'},
                        {name: `{{__('document.outgoing')}}`, label: 'out'},
                    ],
                }
            },
            computed: {
                editable() {

                }
            },
            created() {
                // this.viewTracker(this.trackers[0].id);
                console.log('this is auth emp', this.auth_emp_id)
                this.title = this.document.title;
                this.remark = this.document.remark;
                this.trackerForm.document_id = this.document.id;
                this.isShowPage = true;
            },
            updated() {

            },
            methods: {
                reloadTrackers() {
                    this.loading = true;
                    axios.get(`{!!url('trackers/')!!}/refresh/${this.document.id}`).then((res) => {
                        this.loading = false;
                        this.trackers = res.data;
                    });
                },
                printReceipt() {
                    // Get the div element to print
                    const printContent = this.$refs.printContent;

                    // Create a new window for printing
                    const printWindow = window.open('', '_blank');

                    // Append the div content to the new window
                    printWindow.document.write(printContent.innerHTML);

                    // Trigger printing
                    printWindow.print();

                    // Close the new window after printing
                    printWindow.close();
                },
                showActionButtons() {
                    this.show_action_btn = !this.show_action_btn;
                },
                // daysDifference(date1, request_deadline) {
                //     const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
                //     const firstDate = new Date(date1);
                //     const secondDate = new Date(this.current_date);
                //     const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
                //     if (diffDays > request_deadline) {
                //         return true;
                //     } else {
                //         return false;
                //     }
                // },
                viewTracker(tracker_id) {
                    this.loading = true;
                    this.showTrackerDetails = true;
                    this.tracker_id = tracker_id;
                    axios.get(`{!!url('trackers/')!!}/show/${tracker_id}`).then((res) => {
                        this.loading = false;
                        this.tracker = res.data.tracker;
                        this.comments = res.data.comments;
                        this.totalComments = res.data.comments.length;
                        this.commentForm.tracker_id = this.tracker.id;
                        this.subscribeToPusherChannel(this.tracker.id);
                    });
                },
                flow(flow) {
                    this.updateFlows('document_flows', this.document.id, flow)
                },
                showAttachment(tracker_id) {
                    // this.loading = true;
                    console.log('this is tracker id', tracker_id)
                    this.show_attachment = !this.show_attachment;
                    if (this.show_attachment) {
                        axios.get(`{!!url('trackers/')!!}/attachments/${tracker_id}`).then((res) => {
                            this.loading = false;
                            this.attachments = res.data
                        });
                    }
                },
                showReceivers(tracker_id) {
                    this.show_receivers = !this.show_receivers;
                    if (this.show_receivers) {
                        axios.get(`{!!url('trackers/')!!}/receivers/${tracker_id}`).then((res) => {
                            this.loading = false;
                            this.receivers = res.data
                        });

                    }
                },
                closeReceiverListModal() {
                    this.isReceiverListModalOpen = false;
                },
                showCommentSection(tracker) {
                    this.loading = true;
                    let tracker_id = tracker.id;
                    tracker.showComment = !tracker.showComment;
                    for (let i = 0; i < this.trackers.length; i++) {
                        if (this.trackers[i].id !== tracker_id) {
                            this.trackers[i].showComment = false;
                        }
                    }
                    // this.isTrackerShowModalOpen = true;
                    axios.get(`{!!url('trackers/')!!}/show/${tracker_id}`).then((res) => {
                        this.loading = false;
                        this.tracker = res.data.tracker;
                        this.comments = res.data.comments;
                        this.totalComments = res.data.comments.length;
                        this.commentForm.tracker_id = this.tracker.id;
                        // this.subscribeToPusherChannel(this.tracker.id);
                    });
                },
                subscribeToPusherChannel(trackerId) {
                    window.Echo.channel('tracker.' + trackerId)
                        .listen('CommentAdded', (event) => {
                            // Handle the new comment event
                            this.realTimeComment = event.comment;
                        });
                },
                validation: function () {
                    let flag = false;
                    if (!this.selected_type) {
                        this.errors.doc_type = "@lang('validation.in_out_is_not_selected')"
                        flag = true;
                    }

                    if (!this.selected_doc_type) {
                        this.errors.document_type = "@lang('validation.document_type_is_not_selected')";
                        flag = true;
                    }

                    if (this.selected_type.label === 'internal' && !this.selected_receiver_employee) {
                        this.errors.receiver_employee = "@lang('validation.receiver_employee_is_not_selected')";
                        flag = true;
                    }
                    if (this.selected_type.label === 'external') {
                        if (!this.selected_in_out) {
                            this.errors.in_out = "@lang('validation.document_status_is_not_selected')";
                            flag = true;
                        }
                        if (!this.selected_external_directorate) {
                            this.errors.external_directorate = "@lang('validation.directorate_is_not_selected')";
                            flag = true;
                        }
                        if (this.selected_in_out && this.selected_in_out.label === 'in') {
                            if (!this.selected_receiver_employee) {
                                this.errors.receiver_employee = "@lang('validation.receiver_employee_is_not_selected')";
                                flag = true;
                            }
                        }
                    }
                    return flag;
                },
                closeModal: function () {
                    this.isTrackerShowModalOpen = false;
                },
                triggerFileInput() {
                    document.getElementById('fileInput').click();
                },


                // Handle file selection
                handleFileChange(event) {
                    if (event.target.files.length > 0) {
                        this.commentForm.attachment = event.target.files[0];
                    }
                },

                triggerEditFileInput() {
                    document.getElementById('editFileInput').click();
                },

                // Handle file selection
                handleEditFileChange(event) {
                    if (event.target.files.length > 0) {
                        this.commentEditForm.attachment = event.target.files[0];
                    }
                },

                triggerEditReplyFileInput() {
                    document.getElementById('replyEditFileInput').click();
                },

                // Handle file selection
                handleEditReplyFileChange(event) {
                    if (event.target.files.length > 0) {
                        this.replyEditForm.attachment = event.target.files[0];
                    }
                },
                triggerReplyFileInput() {
                    document.getElementById('replyFileInput').click();
                },

                // Handle file selection
                handleReplyFileChange(event) {
                    if (event.target.files.length > 0) {
                        this.commentReplyForm.attachment = event.target.files[0];
                    }
                },

                isImage(fileName) {
                    return /\.(jpg|jpeg|png|gif|web)$/i.test(fileName);
                },
                downloadImage(id){
                    const link = `{{url('/download')}}/${id}`;
                    window.location.href=link;
                },
                getImagePath(fileName) {
                    return `/storage/comments/${fileName}`;
                },
                getAttachmentPath(fileName) {
                    return `/storage/trackers/${fileName}`;
                },
                postComment() {
                    if (this.commentForm.comment_body.trim() === '') {
                        return;
                    } else {
                        this.loading = true;
                        let formData = new FormData();
                        formData.append('comment_body', JSON.stringify(this.commentForm));
                        if (this.commentForm.attachment) {
                            formData.append('attachment', (this.commentForm.attachment));
                        }
                        axios.post("{{ route('comment.store') }}", formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((res) => {
                            let response = res.data;
                            if (response.status === 200) {
                                this.loading = false;
                                this.commentForm.comment_body = '';
                                this.selectedFile = null; // Reset the file input
                                this.comments.unshift(response.comment);
                                this.totalComments += 1;
                            } else {
                                this.loading = false;
                            }
                        }).catch((error) => {
                            this.loading = false;
                            // Handle error response
                            if (error.response && error.response.status === 422) {
                                this.docFormErrors = error.response.data.errors;
                            } else {
                                console.error("Other Error: ", error);
                            }
                        });
                    }
                },
                editComment(comment) {
                    this.comments = this.comments.map(c => ({
                        ...c,
                        editing: c.id === comment.id,
                    }));
                    this.commentEditForm.comment_body = comment.body;
                    this.commentEditForm.tracker_id = comment.tracker_id;
                },
                editReply(commentId, replyId) {
                    this.comments = this.comments.map(comment => {
                        if (comment.id === commentId) {
                            comment.replies = comment.replies.map(reply => ({
                                ...reply,
                                editing: reply.id === replyId,
                            }));
                        }
                        return comment;
                    });
                    const editedReply = this.comments
                        .find(comment => comment.id === commentId)
                        ?.replies.find(reply => reply.id === replyId);

                    // Set the form values for editing the reply
                    if (editedReply) {
                        editedReply.showActionButtons = false;
                        this.replyEditForm.comment_body = editedReply.body;
                        this.replyEditForm.tracker_id = editedReply.tracker_id;
                    }
                },

                updateComment(id) {
                    this.comments = this.comments.map(c => ({
                        ...c,
                        editing: false,
                    }));
                    let formData = new FormData();
                    formData.append('comment_body', JSON.stringify(this.commentEditForm));
                    if (this.commentEditForm.attachment) {
                        formData.append('attachment', (this.commentEditForm.attachment));
                    }
                    formData.append("_method", "PATCH");
                    axios.post(`/comment/update/` + id, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then((res) => {
                        let response = res.data;
                        if (response.status === 200) {
                            // this.loading = false;
                            this.commentEditForm.comment_body = '';
                            this.commentEditForm.attachment = null;
                            const index = this.comments.findIndex(comment => comment.id === response.comment.id);
                            this.$set(this.comments, index, response.comment);
                        } else {
                            // this.loading = false;
                        }
                    }).catch((error) => {
                        this.loading = false
                        // Handle error response (including validation errors)
                        if (error.response && error.response.status === 422) {
                            this.docFormErrors = error.response.data.errors;
                        } else {
                            console.error("Other Error: ", error);
                        }
                    });
                },
                updateReply(id, comment_id) {
                    // this.comments = this.comments.map(c => ({
                    //     ...c,
                    //     editing: false,
                    // }));
                    this.replyEditForm.parent_id = comment_id;
                    let formData = new FormData();
                    formData.append('comment_body', JSON.stringify(this.replyEditForm));
                    if (this.replyEditForm.attachment) {
                        formData.append('attachment', (this.replyEditForm.attachment));
                    }

                    formData.append("_method", "PATCH");
                    console.log('this is comment_body', this.commentEditForm)

                    axios.post(`/reply/update/` + id, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then((res) => {
                        let response = res.data;
                        if (response.status === 200) {
                            console.log('this is response', response.comment)
                            this.comments = this.comments.map(comment => {
                                if (comment.id === comment_id) {
                                    comment.replies = comment.replies.map(reply => {
                                        if (reply.id === id) {
                                            return {
                                                ...reply, body: response.comment.body,
                                                attachment: response.comment.attachment,
                                                editing: false, /* update other fields */
                                            };
                                        }
                                        return reply;
                                    });
                                }

                                return comment;
                            });


                        } else {
                            // this.loading = false;
                        }
                    }).catch((error) => {
                        this.loading = false
                        // Handle error response (including validation errors)
                        if (error.response && error.response.status === 422) {
                            this.docFormErrors = error.response.data.errors;
                        } else {
                            console.error("Other Error: ", error);
                        }
                    });
                },
                deleteComment(id, index) {
                    axios.delete(`{!!url('comment')!!}/${id}`, {}).then((res) => {
                        let response = res.data;
                        if (response.status == 200) {
                            this.comments.splice(index, 1);
                        }
                    })
                },
                startReply(commentId) {
                    this.replyingCommentId = commentId;
                },
                async deleteReply(commentId, replyId) {
                    try {
                        // Send a DELETE request to the server
                        const response = await axios.delete(`/comment/delete-reply/${commentId}/${replyId}`);

                        // Assuming the server returns a success message or any other indication of success
                        // const successMessage = response.data.message;

                        // Update the local comments array
                        this.comments = this.comments.map(comment => {
                            if (comment.id === commentId) {
                                // Remove the deleted reply from the replies array
                                comment.replies = comment.replies.filter(reply => reply.id !== replyId);
                            }
                            return comment;
                        });

                        // Handle the success message or perform other actions if needed
                        // console.log(successMessage);
                    } catch (error) {
                        // Handle the error as needed
                        console.error('Error deleting reply:', error);
                    }
                },

                saveReply(parentCommentId) {
                    this.commentReplyForm.tracker_id = this.tracker_id;
                    this.commentReplyForm.parent_id = parentCommentId;
                    let formData = new FormData();
                    formData.append('comment_body', JSON.stringify(this.commentReplyForm));
                    if (this.commentReplyForm.attachment) {
                        formData.append('attachment', (this.commentReplyForm.attachment));
                    }
                    axios.post(`/comment/reply/${parentCommentId}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then((res) => {
                            let response = res.data;
                            if (response.status === 200) {
                                this.commentReplyForm.comment_body = '';
                                this.commentReplyForm.attachment = '';
                                const index = this.comments.findIndex(comment => comment.id === parentCommentId);
                                if (index !== -1) {
                                    this.comments[index].replies.unshift(response.reply);
                                }
                                // Reset the replyingCommentId to null
                                this.replyingCommentId = null;
                            } else {
                                // Handle other status codes or errors if needed
                            }
                        })
                        .catch((error) => {
                            // Handle error response
                            console.error("Error: ", error);

                            // You may want to display an error message to the user or handle errors in another way
                        });
                },

                toggleActionButtons(commentId) {
                    this.comments = this.comments.map(comment => {
                        if (comment.id === commentId) {
                            comment.showActionButtons = !comment.showActionButtons;
                        } else {
                            comment.showActionButtons = false;
                        }
                        return comment;
                    });
                },

                toggleReplyActionButtons(commentId, replyId) {
                    this.comments = this.comments.map(comment => {
                        if (comment.id === commentId) {
                            comment.replies = comment.replies.map(reply => {
                                if (reply.id === replyId) {
                                    reply.showActionButtons = !reply.showActionButtons;
                                } else {
                                    reply.showActionButtons = false;
                                }
                                return reply;
                            });
                        }
                        return comment;
                    });
                },

                handleInput() {
                    const matches = this.commentForm.comment_body.match(/@(\w+)/);
                    if (matches && matches.length > 1) {
                        const query = matches[1];
                        this.searchUser(query);
                    } else {
                        this.showSuggestions = false;
                    }
                },
                searchUser(keyword) {
                    this.loading = true;
                    this.isTrackerShowModalOpen = true;
                    axios.get('/search-users'
                        + '?keyword=' + keyword +
                        '&tracker_id=' + this.commentForm.tracker_id).then((res) => {
                        this.suggestedUsers = res.data;
                        this.showSuggestions = true;
                    });
                },
                mentionUser(user) {

                    // const cursorPos = textarea.selectionStart;
                    // let start = this.commentForm.comment_body.lastIndexOf('@', cursorPos - 1);
                    // if (start === -1) {
                    //     start = cursorPos;
                    // }
                    // this.commentForm.comment_body = this.commentForm.comment_body.slice(0, start) + `@${user.name} ` + this.commentForm.comment_body.slice(cursorPos);


                    const textarea = this.$refs.mentionTextarea;

                    // Get the current cursor position
                    const cursorPos = textarea.selectionStart;

                    // Find the start of the mention
                    let start = this.commentForm.comment_body.lastIndexOf('@', cursorPos - 1);

                    // If the cursor is not at the mention start, set start to cursorPos
                    if (start === -1) {
                        start = cursorPos;
                    }

                    // Replace the mention pattern with the user's name
                    this.commentForm.comment_body = this.commentForm.comment_body.slice(0, start) + user.user_name + this.commentForm.comment_body.slice(cursorPos);

                    // Hide suggestions
                    this.showSuggestions = false;
                },
                addNewTracker() {
                    this.showAddTracker = true;
                },
            }

        });
    </script>

@endsection
