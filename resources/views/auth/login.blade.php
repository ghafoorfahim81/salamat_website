<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/app.js') }}"></script>

</head>
<body>

<section class="flex items-center justify-center gradient-form h-full bg-neutral-200 dark:bg-neutral-700">
    <div class="container w-full p-90 max-w-screen-lg">
        <div class="g-6 flex h-full flex-wrap items-center justify-center text-neutral-800 dark:text-neutral-200">
        <div class="w-full">
                <div
                    class="block rounded-lg bg-white shadow-lg dark:bg-neutral-800">
                    <div class="flex">
                        <!-- Left column container with adjusted top margin -->
                        <div class="px-4 md:px-0 lg:w-6/12 lg:mt-[-50px]">
                            <div class="md:mx-6 md:p-12">
                                <!--Logo-->
                                <div class="text-center mt-0.5">
                                    <img
                                        class="py-22 max-h-40 mr-auto ml-auto"
                                        src="{{asset('assets/images/logo.png')}}"/>
                                    <h4 class="mb-12 mt-4 pb-1 text-xl font-semibold">
                                        @lang('user_management.document_management_and_tracking_system')

                                    </h4>
                                </div>
                                @if (session('status'))
                                    <div class="mb-4 font-medium text-sm text-green-600">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form method="POST" class="row g-3" action="{{ route('login') }}">
                                    @csrf

                                    @error('login_error')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                    <div class="col-12 text-center mb-4">
                                        <p class="mb-4 ml-4">
                                            @lang('user_management.please_login_to_your_account')
                                        </p>
                                    </div>
                                    <!--Username input-->
                                    <div class="mb-4" data-te-input-wrapper-init>
                                    </div>
                                    <div class="relative mb-3">
                                        <input type="text" name="user_name" id="floating_outlined"
                                               class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                               placeholder=" "/>
                                        <label for="floating_outlined"
                                               class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">@lang('user_management.user_name')</label>
                                    </div>
                                    <div class="relative mb-3">
                                        <input type="password" name="password" id="floating_outlined"
                                               class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                               placeholder=" "/>
                                        <label for="floating_outlined"
                                               class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">@lang('user_management.please_type_password')</label>
                                    </div>

                                    <!--Password input-->
                                    <!--Submit button-->
                                    <div class="mb-12 pb-1 pt-1 text-center">
                                        <button
                                            class="mb-3 inline-block w-full rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]"
                                            type="submit"
                                            data-te-ripple-init
                                            data-te-ripple-color="light"
                                            style="
                                    background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
                                ">
                                            @lang('user_management.login_to_system')
                                        </button>

                                        <!--Forgot password link-->
                                        <a href="#!">Forgot password?</a>
                                    </div>

                                    <!--Register button-->
                                    <div class="flex items-center justify-between pb-6">
                                        <p class="mb-0 mr-2">Don't have an account?</p>
                                        <button
                                            type="button"
                                            class="inline-block rounded border-2 border-danger px-6 pb-[6px] pt-2 text-xs font-medium uppercase leading-normal text-danger transition duration-150 ease-in-out hover:border-danger-600 hover:bg-neutral-500 hover:bg-opacity-10 hover:text-danger-600 focus:border-danger-600 focus:text-danger-600 focus:outline-none focus:ring-0 active:border-danger-700 active:text-danger-700 dark:hover:bg-neutral-100 dark:hover:bg-opacity-10"
                                            data-te-ripple-init
                                            data-te-ripple-color="light">
                                            Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Right column container with background and description-->
                        <div class="flex items-center rounded-b-lg lg:w-6/12 lg:rounded-r-lg lg:rounded-bl-none" style="background: linear-gradient(to right, #0000008a, #e1e1e1, #d7d7d7b5, #c6c6c6)">
                            <div class="px-4 py-6 text-white md:mx-6 md:p-12">
                                <h4 class="mb-6 text-xl font-semibold text-black">
                                    @lang('user_management.aim_of_document_management_and_tracking_system')
                                </h4>
                                <p class="text-sm">
                                    @lang('user_management.centralized_documents_repository')
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

