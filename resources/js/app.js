/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import trackerMixin from "./trackerMixin";

require('./bootstrap');
// window.Vue=Vue;
// require('./echo');
import Vue from 'vue/dist/vue.esm.js';
import {Datepicker, initTE, Input} from "tw-elements";
import VueSkeletonLoader from 'skeleton-loader-vue';
import VueDatetimeJs from 'vue-datetime-js';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import swal from 'sweetalert2';
import vSelect from 'vue-select';
import moment from 'moment';
import Multiselect from 'vue-multiselect'
import 'material-icons/iconfont/material-icons.css';

initTE({Datepicker, Input});
// register globally
Vue.component('multiselect', Multiselect)
// Vue.component('vue-multiselect', window.VueMultiselect.default)

export default {
    // OR register locally
    components: {Multiselect},
    data() {
        return {
            value: null,
            options: ['list', 'of', 'options']
        }
    }
}

// import Vue from 'vue'
window.Vue = Vue;


// Register the component globally
Vue.component('vue-skeleton-loader', VueSkeletonLoader);


Vue.component('pagination', require('laravel-vue-pagination'));
window.VueSkeletonLoader = VueSkeletonLoader;

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.start();


window.Swal = swal;

Vue.component('v-select', vSelect);


Vue.component('datatable', require('./components/LaravelVueDatatable.vue').default);
Vue.component('loader', require('./components/Loader.vue').default);
Vue.component('btn', require('./components/Button.vue').default);
Vue.component('excel-btn', require('./components/ExcelBtn.vue').default);
Vue.component('add-new', require('./components/AddNewBtn.vue').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('d-header', require('./components/Header.vue').default);
Vue.component('d-input', require('./components/Input.vue').default);
Vue.component('file-input', require('./components/Input-file.vue').default);
Vue.component('d-textarea', require('./components/Textarea.vue').default);
Vue.component('action-btn', require('./components/ActionBtn.vue').default);
Vue.component('edit-btn', require('./components/EditBtn.vue').default);
Vue.component('floating-label', require('./components/FloatingLabel.vue').default);
Vue.component('save-btn', require('./components/SaveBtn.vue').default);
Vue.component('toaster', require('./components/Toaster.vue').default);
Vue.component('avatar', require('./components/Avatar.vue').default);
Vue.component('validation-message', require('./components/ValidationMessage.vue').default);
Vue.component('flow-btn', require('./components/FlowBtn.vue').default);
Vue.component('skeleton', require('./components/Skeleton.vue').default);
Vue.component('show-btn', require('./components/ShowBtn.vue').default);
Vue.component('delete-btn', require('./components/DeleteBtn.vue').default);
Vue.component('history-btn', require('./components/HistoryBtn.vue').default);
Vue.component('commentSkeleton', require('./components/CommentSkeleton.vue').default);
Vue.component('comment-action-btn', require('./components/comment/ActionBtns').default);
Vue.component('card-content', require('./components/comment/CardContent').default);
Vue.component('comment-content', require('./components/comment/CommentContent').default);
Vue.component('tracker-columns', require('./components/TrackerColumns.vue').default);

Vue.component('collapse', require('./components/CollapseComponent.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('activities-card', require('./components/ActivitiesCard.vue').default);
Vue.component('activities-child-card', require('./components/ActivityChildCard.vue').default);
Vue.component('search-btn', require('./components/SearchBtn.vue').default);
Vue.component('cancel-btn', require('./components/CancelBtn.vue').default);
Vue.component('toast', require('./components/Toast.vue').default);
Vue.component('dashboard-in-out', require('./components/DashboardInOutCard.vue').default);

import datePicker from '@alireza-ab/vue-persian-datepicker'


Vue.component('date-picker', datePicker);
//
// moment.updateLocale('ar-sa', {
//     postformat: function (string) {
//         return string
//             .replace(/\d/g, function (match) {
//                 return match;
//             })
//             .replace(/,/g, '،')
//     }
// })
// const dateType = localStorage.getItem('defaultDateType');
// Vue.use(datePicker, {
//     name: 'date-picker',
//     props: {
//
//         color: '#428bff',
//         class: 'border-2 p-2 mr-6',
//         locale: 'da',
//     }
// });

Vue.mixin(trackerMixin)

const myMixin = {
    methods: {
        myFunction() {
            // Your function code here
            console.log('hi')
        },
    },
};
Vue.mixin({
    data() {
        return {
            flowData: null,
            subFormSubmitted: false,
            showGdSkeleton: false,
            showExtDirSkeleton: false,
            showSkeleton: false,
            showDSkeleton: false,
            showEmpSkeleton: false,
            isShowSettings: false,
            employees: [],
            departments: [],
            directories: [],
            followupTypes: [],
            securityLevels: [],
            deadlineTypes: [],
            deputies: [],
            statuses: [],
            deadlines: [],
            documentTypes: [],
            file: null,
            table_id: null,
            table_name: null,
            directorates: [],
            generalDirectorates: [],
            externalDirectorates: [],
            roles: [],
            localeConfigs: {
                da: {
                    calendar: "jalali",
                    weekdays: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
                    months: [
                        "حمل","ثور","جوزا","سرطان","اسد","سنبله","میزان","عقرب","قوس","جدی","دلو","حوت"
                    ],
                    dir: {
                        input: "rtl",
                        picker: "rtl",
                    },
                    translations: {
                        label: "شمسی",
                        text: "تاریخ شمسی",
                        prevMonth: "le mois dernier",
                        nextMonth: "le mois prochain",
                        now: "امروز",
                        submit: "Confirmation",
                    },
                    inputFormat: "date",
                    displayFormat: "D MMMM",
                }
            },

        }
    },
    computed: {},
    mounted() {
        // this function is created globally and called here, so this function do enter shortcuts for every input, select,and textarea
        this.shortCut();
        //This code globally work for every input, when ths user focus on an input then the input is focused
        const inputs = document.getElementsByTagName('input')
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('focus', function () {
                this.select()
            })
        }
    },
    methods: {
        async getDropdownItem(types) {
            this.showSkeleton = true;
            return new Promise((resolve, reject) => {
                axios.get('/get-dropdown-items' + '?type=' + types).then(res => {
                    resolve(res.data);
                    this.showSkeleton = false;
                    if (types.includes('directorates') || types.includes('internal_dirs')) {
                        this.directorates = res.data.directorates;
                    }
                    if (types.includes('filter_dirs')) {
                        this.mDirectorates = res.data.directorates;
                    }
                    if (types.includes('employees')) {
                        this.employees = res.data.employees;
                    }
                    if (types.includes('external_dirs')) {
                        this.externalDirectorates = res.data.externalDirectorates;
                    }
                    if (types.includes('deputies')) {
                        this.deputies = res.data.deputies;
                    }
                    if (types.includes('followupTypes')) {
                        this.followupTypes = res.data.followupTypes;
                    }
                    if (types.includes('securityLevels')) {
                        this.securityLevels = res.data.securityLevels;
                    }
                    if (types.includes('deadlineTypes')) {
                        this.deadlineTypes = res.data.deadlineTypes;
                    }
                    if (types.includes('statuses')) {
                        this.statuses = res.data.statuses;
                    }
                    if (types.includes('deadlines')) {
                        this.deadlines = res.data.deadlines;
                    }
                    if (types.includes('documentTypes')) {
                        this.documentTypes = res.data.documentTypes;
                    }
                    if (types.includes('roles')) {
                        this.roles = res.data.roles;
                    }
                })
            })
        },
        showSettingsMenu() {
            this.ishowSettingsMenu = !this.ishowSettingsMenu;
            alert('sdkafjdsk')
        },

        focusToNextInput(nextInput) {
            this.$refs[nextInput].$el.focus()
            if (nextInput == 'directorate') {
                this.$nextTick(() => {
                    this.$refs.directorate.$el.querySelector('input').focus();
                });
            }
        },

        convertDate(date) {
            let p = new PersianDate();

            return p.fromGregorian(date).toString(); // 1399/10/12

            // p.calendar('g').fromGregorian([2021,1,1]).toString(); // 2021-01-01
        },


        //search employees from create and edit modal
        employeeSearch(search, loading) {
            axios.get('/search'
                + '?keyword=' + search + '&type=' + 'employee'
            )
                .then((response) => {
                    this.employees = response.data;
                    loading(false);
                })
                .catch(function (error) {
                    loading(false);
                });
        },
        // naim code start

        //search Directorate in create fc9
        searchDirectorate(search, loading) {
            axios.get('/search'
                + '?keyword=' + search + '&type=' + 'directorate'
            )
                .then((response) => {
                    this.directorates = response.data;
                    loading(false);
                })
                .catch(function (error) {
                    loading(false);
                });
        },
        //search Directorate in create fc9
        searchExternalDirectorate(search, loading) {
            axios.get('/search'
                + '?keyword=' + search + '&type=' + 'external_directorate'
            )
                .then((response) => {
                    this.externalDirectorates = response.data;
                    console.log('this is a response', response.data)
                    loading(false);
                })
                .catch(function (error) {
                    loading(false);
                });
        },
        // This function upload files and attachments
        onFileChange(e) {
            this.file = e;
        },
        uploadAttachments(table_name) {
            const formData = new FormData();
            formData.append("attachment", this.file);
            if (this.file) {
                this.loading = true;
                axios.post('/upload' + '?table_id=' + this.table_id + '&table_name=' + table_name + '&file_name=' + this.file_name, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                    .then((res) => {
                        let response = res.data;
                        if (response.status == 200) {
                            this.loading = false;
                            this.file_name = '';
                            this.attachmentList.push(response.lastFile)
                            showMessage(res.data.message, 'success');
                        } else {
                            showMessage(res.data.message, 'warning');
                        }
                    });
            }
        },
        //Update or inset follow(this function update all tables follow)
        updateFlows(table, table_id, flow) {
            confirmFlow(table, table_id, flow).then(data => {
                this.latestFlow = data;
            })
        },


        hijryMonths() {
            return ['حمل', 'ثور', 'جوزا', 'سرطان', 'اسد', 'سنبله', 'میزان', 'عقرب', 'قوس', 'جدی', 'دلو'];
        },

        filterEmployeeByDirectorate(directorate_id) {
            this.employess = [];
            this.selected_employee = null
            axios.get('/get-directorate-employees'
                + '?directorate_id=' + directorate_id
            )
                .then((response) => {
                    this.employees = response.data;
                    console.log('selectedEmplloyee', response.data)
                })
                .catch(function (error) {
                });
        },

        async getDeputyDirectorates(deputy_id, isGeneral = true) {
            this.generalDirectorates = [];
            this.directorates = [];
            this.selected_directorate = null;
            this.selected_general_directorate = null;
            this.employees = [];
            this.selected_sender_employee = null;
            if (deputy_id) {
                console.log('this directorates: ', deputy_id)
                this.getDirectorateEmployees(deputy_id);
                this.showGdSkeleton = true;
                try {
                    const response = await axios.get('/get-deputy-directorates', {
                        params: {
                            deputy_id: deputy_id
                        }
                    });
                    this.generalDirectorates = response.data;
                    this.showGdSkeleton = false;
                } catch (error) {
                    console.error('Error getting deputy directorates:', error);
                }
            }
        },

        async getGeneralDirDirectorates(director_id, isGeneral = true) {
            this.directorates = [];
            this.selected_directorate = null;
            this.employees = [];
            this.selected_sender_employee = null;

            if (director_id) {
                if (isGeneral) {
                    this.getDirectorateEmployees(director_id);
                }

                this.showDSkeleton = true;

                try {
                    const response = await axios.get('/get-general-dir-directorates', {
                        params: {
                            directorate_id: director_id
                        }
                    });

                    this.directorates = response.data;
                    this.showDSkeleton = false;
                } catch (error) {
                    console.error('Error getting general directorates:', error);
                }
            }
        },


        async getDirectorateEmployees(directorate_id) {
            try {
                this.employees = [];
                this.selected_sender_employee = null;
                this.showEmpSkeleton = true;

                const response = await axios.get('/get-directorate-users', {
                    params: {
                        directorate_id: directorate_id
                    }
                });

                console.log('this is directorate id', directorate_id);
                this.employees = response.data;
                this.showEmpSkeleton = false;
            } catch (error) {
                // Handle the error
            }
        },



        fiscalYear() {
            let years = [];
            for (let x = 1403; x >= 1397; x--) {
                years.push(x);
            }
            return (years);
        },


        hasFlowPermission: async function (table, id) {
            let response = await axios.get('/checkFlowPermission' + '?table=' + table + '&id=' + id)
            this.flowData = response.data;

            return response;
        },

        formatNumber(number) {
            if (number != null) {
                return new Intl.NumberFormat().format(Number(parseFloat(number).toFixed(2)))
            } else {
                return 0
            }
        },
        preventNavigation(event) {
            if (!this.subFormSubmitted) {
                const message = 'Are you sure?';
                event.preventDefault();
                event.returnValue = message;
                return message;
            }
        },
        handleSubFormSubmit() {
            this.subFormSubmitted = true
        },
        addPreventNavigationEventListener() {
            window.addEventListener('beforeunload', this.preventNavigation)
        },

        shortCut() {
            const inputs = document.querySelectorAll('input, select,textarea')
            inputs.forEach((input, index) => {
                input.addEventListener('keyup', e => {
                    if (e.keyCode === 13) { // enter key
                        if (index + 1 < inputs.length) {
                            inputs[index + 1].focus()
                        }
                    } else if (e.keyCode === 27) { // escape key
                        if (index - 1 >= 0) {
                            inputs[index - 1].focus()
                        }
                    }
                })
            })
        },


    }
})

