<!DOCTYPE html>
<html lang="en" dir="{{(App::isLocale('en') ? 'ltr' : 'rtl')}}">

<head>
   <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- Favicon icon -->
    <link rel="icon" href="{{url('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    {{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">--}}

    <link href="{{asset('css/vue-select.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        [v-cloak] > * {
            display: none !important;
        }

        [v-cloak]::before {
            content: " ";
            display: block !important;

        }

        .highlighted-mention {
            background-color: yellow; /* Change the background color as desired */
        }

        /*.preloader {*/
        /*    position: fixed;*/
        /*    top: 0;*/
        /*    left: 0;*/
        /*    width: 100%;*/
        /*    height: 90%;*/
        /*    background: white; !* Set the background color to match your page background *!*/
        /*    z-index: 9999;*/
        /*}*/

        /*.loading {*/
        /*    position: absolute;*/
        /*    top: 50%;*/
        /*    left: 50%;*/
        /*    transform: translate(-30%, -30%);*/
        /*    border: 5px solid #f3f3f3; !* Light grey *!*/
        /*    border-top: 5px solid #3498db; !* Blue *!*/
        /*    border-radius: 50%;*/
        /*    width: 50px;*/
        /*    height: 50px;*/
        /*    animation: spin 2s linear infinite;*/
        /*}*/
        .relative:hover .tooltip {
            display: block;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .spin {
            animation: spin 2s linear infinite; /* Adjust the duration as needed */
        }

        @font-face {
            font-family: persian;
            src: url('{{ asset('fonts/FontsFree-Net-ir_sans.ttf') }}');
        }

        @font-face {
            font-family: poppins;
            src: url('{{asset('fonts/Poppins-Light.ttf')}}');
        }
        @font-face {
            font-family: poppins-bold;
            src: url('{{asset('fonts/Poppins-Bold.ttf')}}');
        }
        @font-face {
            font-family: poppins-semiBold;
            src: url('{{asset('fonts/Poppins-SemiBold.ttf')}}');
        }

         * {
             font-family: {{ App::isLocale('en') ? 'poppins' : 'persian' }};
         }


    </style>

</head>

<body>
<!-- [ Pre-loader ] start -->
{{--<div class="loader-bg dark:bg-blue-100">--}}
{{--    <div class="loader-track">--}}
{{--        <div class="loader-fill"></div>--}}
{{--    </div>--}}
{{--</div>--}}

<!--notification js -->

@include('general_files.setting-modal')
@include('layouts.navbar')

@include('layouts.sidebar')

<div class="p-4 sm:ml-64 rtl:sm:ml-0 rtl:sm:mr-64 dark:bg-slate-800 ">
    <div class="p-4 border-2 border-gray-200 h-[100%] border-solid rounded-lg dark:border-gray-700 mt-14">
        @yield('content')
    </div>
</div>


<script>
    function openUserMenu() {
        console.log('open user menu')
    }

    const toggleDarkMode = () => {
        const isDarkMode = document.documentElement.classList.toggle('dark');
        // Save the user's preference in local storage
        localStorage.setItem('darkMode', isDarkMode);
    };

    // Check for user preference on page load
    const userPrefersDarkMode = localStorage.getItem('darkMode') === 'true';
    if (userPrefersDarkMode) {
        document.documentElement.classList.add('dark');
    }

    //    rtl to ltr
    function switchLanguage(lang) {
        window.location.href = '/lang.switch/' + lang;
        localStorage.setItem('dir', (lang === 'prs' || lang === 'ps') ? 'rtl' : 'ltr');
    }

    // Add event listeners to each radio input
    document.querySelectorAll('input[name="filter-radio"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.checked) {
                switchLanguage(this.value);
            }
        });
    });

</script>

<!--notification js -->

<script>

    {{--    opening setting modal--}}
    // Get references to the button and the modal element
    const button = document.getElementById('settingsIcon');
    const modal = document.getElementById('top-right-modal');

    // Add a click event listener to the button to show the modal
    button.addEventListener('click', function () {
        modal.style.display = 'block'; // Display the modal
    });

    // Add a click event listener to the close button to hide the modal
    const closeButton = modal.querySelector('[data-modal-hide="top-right-modal"]');
    closeButton.addEventListener('click', function () {
        modal.style.display = 'none'; // Hide the modal
    });

    // Close the modal if the user clicks outside of it
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    {{--    opening setting modal--}}


    const settingsButton = document.getElementById('settingsButton');
    const settingsMenu = document.getElementById('dropdown-example');
    let isSettingsMenuVisible = false;

    // Function to toggle the visibility of the menu
    function toggleSettingsMenu() {
        isSettingsMenuVisible = !isSettingsMenuVisible;
        if (isSettingsMenuVisible) {
            settingsMenu.style.display = 'block';
        } else {
            settingsMenu.style.display = 'none';
        }
    }

    const userDropdown = document.getElementById('user-dropdown');
    let isUserDropDownVisible = false;

    document.getElementById("userButton").addEventListener("click", function () {
        isUserDropDownVisible = !isUserDropDownVisible;
        if (isUserDropDownVisible) {
            userDropdown.style.display = 'block';
        } else {
            userDropdown.style.display = 'none';
        }
    });

    const userMenu = document.getElementById('user-menu');
    let isUserMenuVisible = false;

    document.getElementById("user-menu-btn").addEventListener("click", function () {
        isUserMenuVisible = !isUserMenuVisible;
        if (isUserMenuVisible) {
            userMenu.style.display = 'block';
        } else {
            userMenu.style.display = 'none';
        }
    });

    const notificationMenu = document.getElementById('notification-content');
    let isNotificationMenuVisible = false;

    document.getElementById("notification-icon").addEventListener("click", function () {
        isNotificationMenuVisible = !isNotificationMenuVisible;
        if (isNotificationMenuVisible) {
            notificationMenu.style.display = 'block';
        } else {
            notificationMenu.style.display = 'none';
        }
    });
    //Date type changer
    const dateType = document.getElementById('dateTypeDropdown');
    let isDateTypeVisible = false;

    document.getElementById("dateTypeBtn").addEventListener("click", function () {
        isDateTypeVisible = !isDateTypeVisible;
        if (isDateTypeVisible) {
            dateType.style.display = 'block';
        } else {
            dateType.style.display = 'none';
        }
    });
    //Language dropdown
    const locale = document.getElementById('localeDropdown');
    let isLocaleVisible = false;

    document.getElementById("localeBtn").addEventListener("click", function () {
        isLocaleVisible = !isLocaleVisible;
        if (isLocaleVisible) {
            locale.style.display = 'block';
        } else {
            locale.style.display = 'none';
        }
    });

    window.addEventListener("load", function () {
        document.getElementById("preloader").style.display = "none";
    });

    // Add a click event listener to the button
    settingsButton.addEventListener('click', toggleSettingsMenu);

    function setDefaultDate(dateType) {
        localStorage.setItem('defaultDateType', dateType);
        setCookie('localStorageDateType', dateType, 7);
        window.location.reload();
    }

    const settingsIcon = document.getElementById('settingsIcon');

    settingsIcon.addEventListener('click', function () {
        settingsIcon.classList.toggle('rotate-180');
    });

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function showMessage(message, type) {
        Swal.fire({
            icon: type,
            position: 'top-end',
            title: type === 'warning' ? message : message,
            showConfirmButton: false,
            timer: 1500
        })
    }

    function getTranslation(key) {
        {{--return "{{ __( '@{{key}}') }}";--}}
    }




    function deleteItem(url, callbackFunction) {
        Swal.fire({
            title: "{{ __('general_words.are_you_sure')}}",
            text: "{{ __('general_words.wont_be_to_revert')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonText: "{{ __('general_words.cancel_it')}}",
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('general_words.yes_delete')}}"
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(url, {}).then((response) => {
                    let res = response.data;
                    if (res.status == 200) {
                        if (callbackFunction) {
                            callbackFunction();
                        } else {
                            vm.getRecord();
                        }
                        showMessage(res.message, 'success')
                    } else {
                        showMessage(res.message, 'warning')
                    }
                })
            } else {
                Swal.fire(
                    "{{ __('general_words.not_deleted')}}",
                    "{{ __('general_words.record_is_safe')}}",
                    'success'
                    )
                }
            })
    }

    function hasFlowPermission(table, id) {
        let flow = null;
        axios.get('/checkFlowPermission' + '?table=' + table + '&id=' + id).then(res => {
            flow = res.data;
            return res.data;
        })
    }

    function confirmFlow(table, table_id, flow) {
        return new Promise((resolve, reject) => {
            Swal.fire({
                title: '{{ __("general_words.are_you_sure") }}',
                input: 'text',
                inputLabel: '{{ __("general_words.remark") }}',
                inputValue: '',
                showCancelButton: true,
                confirmButtonText: '{{ __("general_words.yes") }}',
                cancelButtonText: '{{ __("general_words.no") }}',
                inputValidator: (value) => {
                    remark = value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/flow' + '?table=' + table + '&flow=' + flow + '&table_id=' + table_id + "&remark=" + remark)
                        .then((res) => {
                            let response = res.data;
                            if (response.status == 200) {
                                resolve(response.flow)
                                latestFlow = response.flow;
                                showMessage('{{ __("general_words.done") }}', 'success');
                            } else {
                                reject()
                                showMessage(response.message, 'warning');
                            }
                        })
                }
            })
        })
    }

    function curDate() {
        return '{!!currentDate()!!}';
    }
</script>

<!-- Required Js -->
<script src="{{ asset('/js/app.js') }}"></script>

@yield('scripts')

{{-- @include('layouts.footer') --}}
</body>
</html>
