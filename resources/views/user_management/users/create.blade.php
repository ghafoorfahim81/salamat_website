@extends('layouts.master')
@section('title')
@endsection
@section('content')
    <div id="app" v-cloak>
        <!-- Breadcrumb -->
        <d-header :title="'Create User'" :show-icon="true" :url="`{{ route("user.index") }}`"></d-header>

        <div class="w-full bg-white rounded-lg shadow mt-1 dark:bg-gray-800">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <h3 class="text-3xl font-bold dark:text-white"></h3>
                <div
                    class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">

                </div>
            </div>
            <div class="mt-2">
                <form class="" onsubmit="saveForm">
                    @csrf
                    <div class="grid md:grid-cols-2 md:gap-6 p-2">
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">userName</label>
                            <input type="text" v-model="form.name" id="name"
                                   aria-describedby="helper-text-explanation"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Enter the User name">
                            <span style="color:red"> @{{ this.docFormErrors?.name?.[0] }} </span>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">userName</label>
                            <input type="text" v-model="form.name" id="name"
                                   aria-describedby="helper-text-explanation"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Enter the User name">
                            <span style="color:red"> @{{ this.docFormErrors?.name?.[0] }} </span>
                        </div>
                        
                    </div>
                    <div class="text-right py-2">
                        <save-btn :loading="loading" @click="saveForm" :disabled="disabled" :icon="'check'"
                                  :btn_name="'Save Record'" :loading_text="'Record Status is saving'"/>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script type="module">

        var vm = new Vue({
            el: '#app',
            components: {},
            data() {
                return {
                    disabled: false,
                    showToast: false,
                    isEdit: false,
                    loading: false,
                    form: {
                        name: null,
                        email:null,
                        email_verified: null,
                        first_login: null,
                        employee_id: null,
                        status: null,
                        directorate_id: null,
                    },
                   

                }
            },
            created() {
                // this.selected_dir = this.directorates.find((e) => e.id == 1);
            },
            updated() {

            },
            methods: {
                // save document
                saveForm(e) {
                    // e.preventDefault();
                    this.loading = true;
                    axios.post("{{ route('security-levels.store') }}", this.form).then((res) => {
                        let response = res.data;
                        if (response.status == 200) {
                            this.loading = false;
                            this.docFormErrors = null;
                            this.id = response.id;
                            showMessage("saved",'success');
                            this.disabled = true;
                            this.showToast = true;
                            this.addPreventNavigationEventListener();
                        } else {
                            this.loading = false;
                            showMessage('failed');
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

               
            }
        });

    </script>
@endsection
