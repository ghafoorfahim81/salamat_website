@extends('layouts.master')
@section('title')
    د خدماتو ریاست - ریاست خدمات
@endsection
@section('content')
    <div id="app" v-cloak>
        <!-- Breadcrumb -->
        <nav
            class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="#"
                       class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="#"
                           class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Templates</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Flowbite</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="w-full bg-white rounded-lg shadow mt-1 dark:bg-gray-800">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <h3 class="text-3xl font-bold dark:text-white">Create Security Levels</h3>
                <div
                    class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">

                </div>
            </div>
            <div class="mt-2">
                <form class="" onsubmit="saveForm">
                    @csrf
                    <div class="grid md:grid-cols-2 md:gap-6 p-2">
                        <div class="relative z-0 w-full mb-6 group">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                            <input type="text" v-model="form.name" id="name"
                                   aria-describedby="helper-text-explanation"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Enter the security level name">
                            <span style="color:red"> @{{ this.docFormErrors?.name?.[0] }} </span>
                        </div>
                        
                    </div>
                    <div class="text-right py-2">
                        <save-btn :loading="loading" @click="saveForm" :disabled="disabled" :icon="'check'"
                                  :btn_name="'Save document'" :loading_text="'Document is saving'"/>
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
