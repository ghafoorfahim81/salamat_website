@extends('layouts.master')

@section('title')
    سیتم مدیریت اسناد| جزئیات سند
@endsection

@section('content')
    <div id="app" class="min-h-screen flex">
        <div class="w-0/ bg-gray-200">
            Document Details


            <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-gray-400 dark:divide-gray-700 mt-2">
                <div class="flex items-center justify-between py-10">
                    <dt class="text-sm">{{ __('document.title') }}</dt>
                    <dd class="text-sm">{{ $document->title }}</dd>
                </div>

                <div class="flex items-center justify-between py-10">
                    <dt class="text-sm">{{ __('document.subject') }}</dt>
                    <dd class="text-sm">{{ $document->subject }}</dd>
                </div>


                <div class="flex items-center justify-between py-10 w-full">
                    <dt class="text-sm">{{ __('general_words.phone_number') }}</dt>
                    <dd class="text-sm">{{ $document->remark }}</dd>
                </div>


                <div class="text-p py-2">
                    {!! QrCode::encoding('UTF-8')->color(255, 0, 0)->generate(url()->current()) !!}
                </div>
            </dl>



        </div>








        <div class="w-3/4 p-4">
            Trackers List



{{--            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">--}}
{{--                @foreach($trackers as $tracker)--}}
{{--                    <div class="flex flex-col bg-white border border-gray-300 rounded-md p-4">--}}
{{--                        <div class="flex items-center justify-between mb-4">--}}
{{--                            <button @click="editRecord({{ $tracker->id }})" class="btn btn-primary">{{__('general_words.edit')}}</button>--}}
{{--                            <button @click="showCommentSection({{ $tracker->id }})" class="btn btn-primary">{{__('document.discussions')}}</button>--}}
{{--                        </div>--}}

{{--                        <div v-show="{{ $tracker->showComment }}" class="mb-4">--}}
{{--                            @include('documents.comment')--}}
{{--                        </div>--}}

{{--                        <div class="flex justify-between mb-2">--}}
{{--                            <span class="text-sm">{{__('document.in_number')}}: {{ $tracker->in_num ? $tracker->in_num.'-'.$tracker->in_doc_prefix : '' }}</span>--}}
{{--                            <span class="text-sm">{{__('document.in_date')}}: {{ $tracker->in_date }}</span>--}}
{{--                        </div>--}}

{{--                        <!-- Add more properties in a similar manner -->--}}

{{--                        <div class="flex justify-between">--}}
{{--                            <span class="text-sm">{{__('document.user')}}: {{ $tracker->user }}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}


            @foreach($trackers as $tracker)
                <div class="min-w-96 p-1 shadow-shadow-2xl mb-4 flex flex-col bg-white border border-gray-300 rounded-md">
                    <div class="flex items-center justify-between p-2 bg-gray-100">
                        <button @click="editRecord({{ $tracker->id }})" class="btn btn-primary px-3">{{__('general_words.edit')}}</button>
                        <button @click="showCommentSection({{ $tracker->id }})" class="btn btn-primary px-3">{{__('document.discussions')}}</button>
                    </div>

                    <div v-show="{{ $tracker->showComment }}" class="p-2">
                        @include('documents.comment')
                    </div>





                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700 p-2">


                        <li class="flex items-center justify-between py-2">
                            <dt class="text-sm">{{__('document.in_number')}}</dt>
                            <dd class="text-sm">{{ $tracker->in_num ? $tracker->in_num.'-'.$tracker->in_doc_prefix : '' }}</dd>
                        </li>

                        <li class="flex items-center justify-between py-2">
                            <dt class="text-sm">{{__('document.in_date')}}</dt>
                            <dd class="text-sm">{{ $tracker->in_date }}</dd>
                        </li>

                        <!-- ... other fields ... -->

                        <li class="flex items-center justify-between py-2">
                            <dt class="text-sm">{{__('document.total_attachments')}}</dt>
                            <dd class="text-sm" @click="showAttachment({{ $tracker->id }})">{{ $tracker->attachment_count ?? 0 }}</dd>
                        </li>

                        <li class="flex items-center justify-between py-2">
                            <dt class="text-sm">{{__('document.receivers')}}</dt>
                            <dd class="text-sm" @click="showReceivers({{ $tracker->id }})">{{ $tracker->doc_copies_count ?? 0 }}</dd>
                        </li>

                        <li class="flex items-center justify-between py-2">
                            <dt class="text-sm">{{__('document.user')}}</dt>
                            <dd class="text-sm">{{ $tracker->user }}</dd>
                        </li>
                    </ul>
                </div>
            @endforeach










        </div>
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
                    isReceiverListModalOpen: false,
                    totalComments: 0,
                    comments: [],
                    auth_user: "{!! auth()->user()->id !!}",
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
                    showAddTracker: false,
                    latestFlow: "{!! $latestFlow !!}",
                    selected_ccType: 'employee',
                    isAttachmentModalOpen: false,
                    attachments: [],
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
                this.title = this.document.title;
                this.remark = this.document.remark;
                this.trackerForm.document_id = this.document.id;
                this.isShowPage = true;
            },
            updated() {

            },
            methods: {
                showActionButtons() {
                    this.show_action_btn = !this.show_action_btn;
                },
                daysDifference(date1, request_deadline) {
                    const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
                    const firstDate = new Date(date1);
                    const secondDate = new Date(this.current_date);
                    const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
                    if (diffDays > request_deadline) {
                        return true;
                    } else {
                        return false;
                    }
                },
                flow(flow) {
                    this.updateFlows('document_flows', this.document.id, flow)
                },
                showAttachment(tracker_id) {
                    this.loading = true;
                    this.isAttachmentListModalOpen = true;
                    axios.get(`{!!url('trackers/')!!}/attachments/${tracker_id}`).then((res) => {
                        this.loading = false;
                        this.attachments = res.data
                    });
                },
                showReceivers(tracker_id) {
                    console.log('asdkfjaskdf')
                    this.loading = true;
                    this.isReceiverListModalOpen = true;
                    axios.get(`{!!url('trackers/')!!}/receivers/${tracker_id}`).then((res) => {
                        this.loading = false;
                        this.receivers = res.data
                    });
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
                isImage(fileName) {
                    return /\.(jpg|jpeg|png|gif)$/i.test(fileName);
                },
                getImagePath(fileName) {
                    return `/storage/comments/${fileName}`;
                },
                getAttachmentPath(fileName) {
                    return `/storage/trackers/${fileName}`;
                },
                postComment() {
                    if (this.commentForm.comment_body.trim() === '') {
                        console.log('this field is required')
                    } else {
                        this.loading = true;
                        let formData = new FormData();
                        formData.append('comment_body', JSON.stringify(this.commentForm));

                        // Add the file to FormData if a file is selected
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
                },
                updateComment(id) {
                    this.comments = this.comments.map(c => ({
                        ...c,
                        editing: false,
                    }));
                    axios.patch(`/comment/update/` + id, this.commentEditForm).then((res) => {
                        let response = res.data;
                        if (response.status === 200) {
                            // this.loading = false;
                            this.commentEditForm.comment_body = '';
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
                saveReply(parentCommentId) {
                    // Send the reply data to the server and handle the response
                    axios.post(`/comment/reply/${parentCommentId}`, {body: this.commentReplyForm})
                        .then((res) => {
                            let response = res.data;
                            if (response.status === 200) {
                                // Clear the reply text
                                this.commentReplyForm.comment_body = '';

                                // Update the comments array with the new reply
                                const index = this.comments.findIndex(comment => comment.id === parentCommentId);
                                if (index !== -1) {
                                    this.comments[index].replies.push(response.reply);
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

