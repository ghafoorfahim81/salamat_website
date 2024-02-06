import { unset } from "lodash";
export default {
    data() {
        return {
            confirmationPopup: false,
            recordToUpdate: null,
            is_checked: null,
            showBtns: false,
            trackerModalTitle: null,
            isAttachmentListModalOpen: false,
            trackerForm: {
                title: null,
                ccUsers: [],
                ccDirs: [],
                receiver_employee_id: null,
                receiver_directorate_id: null,
                external_directorate_id: null,
                in_num: null,
                out_num: null,
                in_date: null,
                out_date: new Date().toISOString().slice(0, 10),
                request_deadline: null,
                remark: null,
                attachment_count: null,
                deadline_id: null,
                status_id: null,
                deadline_type_id: null,
                security_level_id: null,
                followup_type_id: null,
                doc_type_id: null,
                document_id: null,
                phone_number: null,
                focal_point_name: null,
                decision_subject: null,
                conclusion: null,
                in_out: null,
                type: null,
            },
            deadlines: [],
            doc_edit: false,
            selected_sender_employee: null,
            selected_receiver_employee: null,
            selected_external_directorate: null,
            selected_deadline: null,
            selected_directorate: null,
            selected_general_directorate: null,
            selected_assign_department: null,
            selected_deputy: null,
            selected_deadline_type: null,
            selected_status: null,
            selected_security_level: null,
            selected_followup_type: null,
            selected_doc_type: null,
            showToast: false,
            isModalOpen: false,
            isInfoModalOpen: false,
            trackerData: [],
            tracker_id: null,
            document_id: null,
            trackerFormErrors: null,
            isAttachmentModalOpen: false,
            attachmentList: [],
            save_tracker_loader: false,
            selected_ccType: 'employee',
            selected_directorates: [],
            //Motahidulmal directives
            mDirectorates: [],
            isEdit: false,
            mEmployees: [],
            isFilterModalOpen: false,
            m_selected_directorate: [],
            m_directorates: [],
            m_selected_employee: [],
            selected_employees: [],
            m_employees: [],
            selected_in_out: null,
            errors: {
                title: '',
                doc_type: null,
                document_type: null,
                receiver_employee: null,
                status: null,
                in_out: null,
                external_directorate: null,
                focal_point_name: null,
            },
            showSkeleton: false,
            showDocTtitle: false,
        }
    },
    computed: {

        dateDifferences() {
            if (!this.apiData || this.apiData.length < 1) {
                return [];
            }

            // console.log('here hs Nad', this.apiData)

            // const sortedRecords = this.apiData.data.slice().sort((a, b) => {
            //     return new Date(a.created_at) - new Date(b.created_at);
            // });

            // const differences = sortedRecords.map((record, index) => {
            //     if (index === sortedRecords.length - 1) {
            //         const currentDate = new Date(record.created_at);
            //         const today = new Date();
            //         console.log('Current Date:', currentDate);

            //         console.log('Todayddss:', today);

            //         const differenceInDays = Math.floor(
            //             (today - currentDate) / (1000 * 60 * 60 * 24)
            //         );

            //         console.log('Difference withToday:', differenceInDays);
            //         return differenceInDays;
            //     }

            //     const currentDate = new Date(record.created_at);
            //     const nextDate = new Date(sortedRecords[index + 1].created_at);
            //     const differenceInDays = Math.floor(
            //         (nextDate - currentDate) / (1000 * 60 * 60 * 24)
            //     );

            //     // console.log('Difference with the next record:', differenceInDays);
            //     return differenceInDays;
            // });

            // return differences;
        },
    },
    watch: {
        selected_doc_type: 'fetchDaysData',
        selected_security_level: 'fetchDaysData',
    },
    methods: {
        openTrackerModal(showTitle = false) {
            this.showDocTtitle = showTitle;
            this.getDropdownItem(['deputies',
                'followupTypes',
                'securityLevels',
                'deadlineTypes',
                'statuses',
                'deadlines',
                'documentTypes',
                'external_dirs'
            ]).then(() => {
                this.selected_deadline_type = this.deadlineTypes.find(item => item.id == 1)
                this.selected_security_level = this.securityLevels.find(item => item.id == 1)
                this.selected_followup_type = this.followupTypes.find(item => item.id == 1)
                this.selected_status        = this.statuses.find(item => item.slug == 'ongoing');
            })
            this.isModalOpen = true;
        },
        handleSubmit() {
            if (this.isEdit) {
                this.updateItems();
            } else {
                this.saveTracker();
            }
        },
        getRecord: _.debounce((page = vm.page) => {
            vm.showLoading = true;
            let url ="/trackers?";
            axios.get(vm.url
                + '&current_page=' + page
                + '&document_id=' + vm.trackerForm.document_id
                + '&per_page=' + vm.perPage
            )
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
        //attachment modal for tracker
        openAttachmentModal() {
            this.isAttachmentModalOpen = true;
        },
        closeAttachmentModal() {
            this.trackerForm.attachment_count= this.attachmentList.length;
            this.isAttachmentModalOpen = false;
        },
        closeAttachmentListModal() {
            this.isAttachmentListModalOpen = false;
        },
        onFileSelect(event) {
            // Check if a file is selected
            if (event.target.files.length > 0) {
                // Get the first selected file
                let file = event.target.files[0];
                // Add the file object to the attachmentList array
                this.attachmentList.push({
                    name: file.name,
                    file: file
                });
            }
        },
        deleteFromAttachmentArray(index) {
            this.attachmentList.splice(index, 1);
        },
        daysDifference(date1, date2) {
            const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
            const firstDate = new Date(date1);
            const secondDate = new Date(date2);
            const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
            return diffDays;
        },

        calculateDateDifference(date1, date2) {
            const a = new Date(date1);
            // return b;
            if (date2 === null) {
                return 0;
            }

            const b = new Date(date2);
            a.setHours(0, 0, 0, 0);
            b.setHours(0, 0, 0, 0);
            const differenceInMilliseconds = b - a;
            // return differenceInMilliseconds;

            const differenceInDays = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));

            return differenceInDays;
        },


        calculateSum(requestDeadline, deadlineDays) {
            if (requestDeadline === null && deadlineDays === null) {
                return '';
            }
            const sum = (parseInt(requestDeadline) || 0) + (parseInt(deadlineDays) || 0);
            return sum;
        },
        fetchDaysData() {
            if (this.selected_doc_type && this.selected_security_level) {
                axios.get(`/fetch-deadlines?doc_type_id=${this.selected_doc_type.id}&security_level_id=${this.selected_security_level.id}`)
                    .then(response => {
                        const deadlines = response.data;
                        console.log('Dead', deadlines);
                        if (deadlines) {
                            this.selected_deadline = this.deadlines.find(item => item.days == deadlines.days)
                        } else {
                            this.deadlineForm.days = null;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching days data:', error);
                    });
            }
        },


        openConfirmationPopup(record) {
            this.recordToUpdate = record;
            // console.log('aaMir',this.recordToUpdate);
            this.confirmationPopup = true;
        },
        confirmUpdate() {
            this.updateCheckedStatus(this.recordToUpdate.id);
            this.confirmationPopup = false;
        },
        cancelUpdate() {
            this.confirmationPopup = false;
        },

        updateCheckedStatus(recordId) {
            axios.patch(`/tracker/updateIsChecked/${recordId}`)
                .then(response => {
                    const updatedRecord = response.data.status;

                    if (updatedRecord) {
                        this.getRecord();
                    } else {
                        console.error('Error: Updated record is undefined in the response:', response.data);
                    }

                    // console.log('hhere', updatedRecord);
                })
                .catch(error => {
                    // Handle the error
                    console.error('Error updating checkbox status:', error);
                });
        },
        openFilterModal(){
            this.getDropdownItem([
                'filter_dirs',
            ]);
            this.isFilterModalOpen = true;
        },
        directorateChange() {
            if (this.selected_ccType === 'employee') {
                this.getDirectorateFilterEmployees();
            } else {
                this.addToDirArray(this.m_selected_directorate);
            }
        },
        getDirectorateFilterEmployees() {
            this.mEmployees = [];
            this.m_selected_employee = null;
            this.showEmpSkeleton = true;
            axios.get('/get-directorate-users'
                + '?directorate_id=' + this.m_selected_directorate?.id
            )
                .then((response) => {
                    this.mEmployees = response.data;
                    this.showEmpSkeleton = false;
                })
                .catch((error) => {
                    // Handle the error
                });
        },
        addToEmpArray(employee){
            if (employee) {
                const isDuplicate = this.selected_employees.some(
                    (existingEmployee) => existingEmployee.id === employee.id
                );
                if (!isDuplicate) {
                    this.selected_employees.push(employee);
                }
            }
        },
        addToDirArray(directorate) {
            if (directorate) {
                const isDuplicate = this.selected_directorates.some(
                    (existingDirectorate) => existingDirectorate.id === directorate.id
                );
                if (!isDuplicate) {
                    this.selected_directorates.push(directorate);
                }
            }
        },
        deleteToEmpArray(index){
            if (index !== undefined && index >= 0 && index < this.selected_employees.length) {
                this.selected_employees.splice(index, 1);
            }
        },
        deleteFromDirArray(index) {
            if (index !== undefined && index >= 0 && index < this.selected_directorates.length) {
                this.selected_directorates.splice(index, 1);
            }
        },
        ccTypeChange(type) {
            if (type ==='employees') {
                this.trackerForm.ccDirs =[];
                this.m_selected_directorate = null;
            }
            else {
                this.m_selected_employee= null;
                this.trackerForm.ccUsers =[];
            }
        },
        closeFilterModal(){
            this.isFilterModalOpen =false;
        },

        saveTracker() {
            if (!this.validation()) {
                // console.log('this is validation', this.validation())
                this.save_tracker_loader = true;
                this.trackerForm.receiver_employee_id = this.selected_receiver_employee.id;
                this.trackerForm.receiver_directorate_id = this.selected_receiver_employee.directorate_id;
                this.trackerForm.external_directorate_id = this.selected_external_directorate?this.selected_external_directorate.id:null;
                this.trackerForm.deadline_id = this.selected_deadline?.id;
                this.trackerForm.deadline_type_id = this.selected_deadline_type?.id;
                this.trackerForm.status_id = this.selected_status?.id;
                this.trackerForm.security_level_id = this.selected_security_level?.id;
                this.trackerForm.followup_type_id = this.selected_followup_type?.id;
                this.trackerForm.doc_type_id = this.selected_doc_type?.id;
                this.trackerForm.type = this.selected_type?.label;
                this.trackerForm.in_out = this.selected_in_out?.label;
                if (this.selected_ccType === 'employee') {
                    if (this.selected_employees && this.selected_employees.length > 0) {
                        this.selected_employees.forEach(employee => {
                            this.trackerForm.ccUsers.push(employee.id);
                        });
                    }
                } else {
                    if (this.selected_directorates && this.selected_directorates.length > 0) {
                        this.selected_directorates.forEach(directorate => {
                            this.trackerForm.ccDirs.push(directorate.id);
                        });
                    }
                }
                const formData = new FormData();
                formData.append('ccUsers', JSON.stringify(this.trackerForm.ccUsers));
                formData.append('ccDirs', JSON.stringify(this.trackerForm.ccDirs));
                formData.append('form', JSON.stringify(this.trackerForm));
                this.attachmentList.forEach((attachment) => {
                    formData.append('attachments[]', attachment.file);
                });

                axios.post('/trackers/store', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((res) => {
                    let response = res.data;
                    if (response.status == 200) {
                        this.save_tracker_loader = false;
                        this.trackerFormErrors = null;
                        if(this.doc_edit){
                            this.getRecord();
                        }
                        else if(this.showDocTtitle) {
                            window.location.href = '/documents/show/' + response.document_id;
                        }
                        else{
                            this.trackers.unshift(response.tracker[0]);
                        }
                        this.isModalOpen = false;
                        showMessage(response.message, 'success');
                        this.resetForm();
                    } else {
                        this.save_tracker_loader = false;
                        showMessage(response.message, 'warning');
                    }

                }).catch((error) => {
                    this.loading = false
                    this.save_tracker_loader = false;
                    // Handle error response (including validation errors)
                    if (error.response && error.response.status === 422) {
                        this.trackerFormErrors = error.response.data.errors;
                    } else {
                        console.error("Other Error: ", error);
                    }
                });
            }
        },
        closeModal() {
            this.isModalOpen = false;
            this.resetForm();
            this.isInfoModalOpen = false;
            this.isAttachmentModalOpen = false;
        },
        decline() {
            this.isModalOpen = false;
            this.isInfoModalOpen = false;
            this.isAttachmentModalOpen = false;
        },
        uploadAttachment() {
            this.table_id = this.trackerForm.document_id;
            this.table_id = 3;
            this.uploadAttachments('documents');
        },
        editRecord(id = null, index) {
            this.isEdit = true;
            this.tracker_id = id;
            this.getDropdownItem(['deputies',
                'followupTypes',
                'securityLevels',
                'deadlineTypes',
                'statuses',
                'deadlines',
                'documentTypes',
                'external_dirs',
            ])
            this.isModalOpen = true;
            this.showSkeleton = true;
            let url ="/trackers/edit" + "/" + id
            axios.get(url).then((res) => {
                console.log('this is res', res.data)
                this.showSkeleton = false;
                const response = res.data;

                this.selected_sender_employee = response.sender;
                this.selected_receiver_employee = response.receiver_emp;
                if (this.docTypes.label === 'external') {
                    this.selected_external_directorate = this.externalDirectorates.find(item => item.id == response.sender_directorate_id);
                }
                this.selected_deputy = this.deputies.find(item => item.id == response.receiver_directorate_id);
                if (!this.selected_deputy) {
                    this.getDeputyDirectorates(response.receiver.parent_id, false).then(() => {
                        if (this.generalDirectorates.length) {
                            this.selected_general_directorate = this.generalDirectorates.find(item => item.id == response.receiver_directorate_id);
                            console.log(this.generalDirectorates)
                        }
                        if (!this.selected_general_directorate) {
                            this.getGeneralDirDirectorates(response.receiver.parent_id, false).then(() => {
                                if (this.directorates.length) {
                                    this.selected_directorates = this.directorates.find(item => item.id == response.receiver_directorate_id);
                                }
                            });
                        }
                    });
                }
                this.trackerForm.in_num = response.in_num;
                this.trackerForm.out_num = response.out_num;
                this.trackerForm.in_date = response.in_date;
                this.trackerForm.out_date = '1402-10-8';

                this.trackerForm.request_deadline = response.request_deadline;
                this.trackerForm.attachment_count = response.attachment_count;
                this.trackerForm.remark = response.remark;
                this.selected_deadline = response.deadline;
                this.selected_status = response.status;
                this.selected_deadline_type = response.deadline_type;
                this.selected_security_level = response.security_level;
                this.selected_followup_type = response.followup_type;
                this.selected_doc_type = response.doc_type;
                this.trackerForm.phone_number = response.phone_number;
                this.trackerForm.focal_point_name = response.focal_point_name;
                this.trackerForm.conclusion = response.conclusion;
                this.trackerForm.decision_subject = response.decision_subject;
                // this.selected_type = response.type;
                this.selected_type= this.docTypes.find(item => item.label == response.type);
                this.selected_in_out = this.inOutDocument.find(item => item.label == response.in_out);
                if(this.selected_type.label === 'external'){
                    this.selected_external_directorate = this.externalDirectorates.find(item => item.id == response.sender_directorate_id);
                }
            });
        },
        viewTracker(id) {
            this.isInfoModalOpen = true;
            let url ="/trackers/show" + "/" + id
            axios.get(url).then((res) => {
                this.selected_sender_employee = res.data.sender;
                this.selected_receiver_employee = res.data.receiver;
                this.trackerForm.in_num = res.data.in_num;
                this.trackerForm.out_num = res.data.out_num;
                this.trackerForm.in_date = res.data.in_date;
                this.trackerForm.out_date = res.data.out_date;
                this.trackerForm.request_deadline = res.data.request_deadline;
                this.trackerForm.attachment_count = res.data.attachment_count;
                this.trackerForm.remark = res.data.remark;
                this.selected_deadline = res.data.deadline;
                this.selected_status = res.data.status;
                this.selected_deadline_type = res.data.deadline_type;
                this.selected_security_level = res.data.security_level;
                this.selected_followup_type = res.data.followup_type;
                this.selected_doc_type = res.data.doc_type;
                this.trackerForm.conclusion = res.data.conclusion;
                this.trackerForm.decision_subject = res.data.decision_subject;
                this.selected_type = res.data.type;
                this.selected_in_out = res.data.in_out;
            });
        },
        updateItems() {
            this.save_tracker_loader = true;
            this.trackerForm.receiver_employee_id = this.selected_receiver_employee.id;
            this.trackerForm.receiver_directorate_id = this.selected_receiver_employee.directorate_id;
            this.trackerForm.external_directorate_id = this.selected_external_directorate?.id;
            this.trackerForm.deadline_id = this.selected_deadline?.id;
            this.trackerForm.deadline_type_id = this.selected_deadline_type?.id;
            this.trackerForm.status_id = this.selected_status?.id;
            this.trackerForm.security_level_id = this.selected_security_level?.id;
            this.trackerForm.followup_type_id = this.selected_followup_type?.id;
            this.trackerForm.doc_type_id = this.selected_doc_type?.id;
            this.trackerForm.type = this.selected_type?.label;
            this.trackerForm.in_out = this.selected_in_out?.label;
            if (this.selected_ccType === 'employee') {
                if (this.selected_employees && this.selected_employees.length > 0) {
                    this.selected_employees.forEach(employee => {
                        this.trackerForm.ccUsers.push(employee.id);
                    });
                }
            } else {
                if (this.selected_directorates && this.selected_directorates.length > 0) {
                    this.selected_directorates.forEach(directorate => {
                        this.trackerForm.ccDirs.push(directorate.id);
                    });
                }
            }
            const formData = new FormData();
            formData.append('ccUsers', JSON.stringify(this.trackerForm.ccUsers));
            formData.append('ccDirs', JSON.stringify(this.trackerForm.ccDirs));
            formData.append('form', JSON.stringify(this.trackerForm));
            this.attachmentList.forEach((attachment) => {
                formData.append('attachments[]', attachment.file);
            });
            if (this.isEdit) {
                formData.append("_method", "PATCH");
            }
            let url ="/trackers/update/" + this.tracker_id
            axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }}).then((res) => {
                let response = res.data;
                if (response.status == 200) {
                    this.trackerFormErrors = null;
                    this.getRecord();
                    this.isModalOpen = false;
                    showMessage(response.message, 'success');
                    this.resetForm();
                    this.save_tracker_loader = false;
                    this.isEdit = false;
                } else {
                    this.save_tracker_loader = false;
                    showMessage(response.message, 'warning');
                }
            }).catch((error) => {
                this.save_tracker_loader = false
                // Handle error response (including validation errors)
                if (error.response && error.response.status === 422) {
                    this.trackerFormErrors = error.response.data.errors;
                } else {
                    console.error("Other Error: ", error);
                }
            });
        },
        deleteRecord(id, index) {
            deleteItem(`/trackers/${id}`);
        },
        resetForm() {
            this.selected_sender_employee = null;
            this.selected_receiver_employee = null;
            this.trackerForm.in_num = null;
            this.showDocTtitle = false;
            this.trackerForm.out_num = null;
            this.trackerForm.in_date = null;
            this.selected_ccType     = 'employee';
            this.trackerForm.out_date = null;
            this.trackerForm.request_deadline = null;
            this.trackerForm.attachment_count = null;
            this.trackerForm.remark = null;
            this.selected_deadline = null;
            this.selected_status = null;
            this.selected_deadline_type = null;
            this.selected_security_level = null;
            this.selected_followup_type = null;
            this.selected_doc_type = null;
            this.trackerForm.phone_number = null;
            this.selected_directorates =[];
            this.m_selected_directorate = null;
            this.m_selected_employee= null;
            this.trackerForm.ccDirs =[];
            this.selected_employees =[];
            this.trackerForm.ccUsers =[];
            this.trackerForm.focal_point_name = null;
            this.trackerForm.conclusion = null;
            this.selected_deputy = null;
            this.selected_general_directorate = null;
            this.selected_external_directorate = null;
            this.selected_directorates = null;
            this.trackerForm.decision_subject = null;
            this.selected_in_out= null;

        },
    }
}
