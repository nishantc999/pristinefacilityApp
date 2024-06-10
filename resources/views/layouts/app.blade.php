<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets/logop.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/backend/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/backend/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/backend/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/backend/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/backend/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/backend/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/icons.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">


    <link rel="stylesheet" href="{{ asset('assets/backend/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/header-colors.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
   <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
   <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
    <script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script>
  {{-- date range --}}
      <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
      {{-- date range end --}}
    @stack('style')
</head>

<body>


    <div class="wrapper">
        @guest
            @yield('content')
        @else
            @auth
                @include('includes.sidebar')
                @include('includes.header')








                @yield('content')
                @include('includes.footer')
            @endauth

        @endguest

    </div>

    <script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(".datepicker").flatpickr();
    </script>


    <script>
        function get_district_on_state_id(e) {
            id = e.value;

            if (id != null) {
                $.ajax({
                    type: "get",
                    url: "{{ route('get_district_on_state_id') }}",
                    data: {
                        id
                    },

                    success: function(result) {
                        $('#district_id').html('<option value="">Select District</option>');
                        $('#city_id').html('<option value="">Select City</option>');
                        $.each(result, function(index, district) {
                            $('#district_id').append('<option value="' + district.id + '">' + district.district_title + '</option>');
                        });



                    }
                });
            }

        }
        function get_city_on_district_id(e) {
            id = e.value;

            if (id != null) {
                $.ajax({
                    type: "get",
                    url: "{{ route('get_city_on_district_id') }}",
                    data: {
                        id
                    },

                    success: function(result) {
                        $('#city_id').html('<option value="">Select City</option>');
                        $.each(result, function(index, city) {
                            $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });



                    }
                });
            }

        }
        </script>
        <script>
        function searchformsubmit() {

            $('#searchform').submit();
        }
        function searchformsubmit1() {

            $('#searchform1').submit();
        }
        function searchformsubmit22() {

            $('#searchform22').submit();
        }
        function searchformsubmit23() {

            $('#searchform23').submit();
        }
    </script>

    <script>
        function statuschange(e, route) {
            id = e.getAttribute("data-id")
            if (e.checked) {
                status = 1;
            } else {
                status = 0;
            }
            $.ajax({
                type: "get",
                url: route,
                data: {
                    status,
                    id
                },

                success: function(result) {

                    console.log("result");
                }
            });
        };


        function Deletedata(id, route) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete the resource
                    $.ajax({

                        url: route,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            if (result.success == true) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: result.message,
                                    icon: "success"
                                });
                                location.reload();
                            }
                            if (result.success == false) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: result.message,

                                });

                            }
                        },
                        error: function(xhr) {
                            // Handle error
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        }
    </script>
        <script>

document.getElementById('mobile_no').addEventListener('keypress', function(event) {
    // Get the input value
    let inputValue = event.target.value;

    // Ensure it's a number key and not a special key like backspace or delete
    if (!isNaN(Number(event.key))) {
        // If input length is already 10 and user tries to add more digits, prevent that
        if (inputValue.length >= 10) {
            event.preventDefault();
        }

    } else {
        // Prevent non-numeric input
        event.preventDefault();
    }
});

document.getElementById('mobile_no').addEventListener('input', function(event) {
    let inputValue = event.target.value;
    let validationMessage = document.getElementById('validationMessage');

    if (inputValue.length != 10) {
        validationMessage.textContent = ''; // Clear previous validation message
    } else {
        validationMessage.textContent = 'Please enter exactly 10 digits.';
    }
});


</script>

    <script src="{{ asset('assets/backend/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/chartjs/js/chart.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/index.js') }}"></script>
   <script src="{{ asset('assets/backend/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/index.js') }}"></script>
    <script src="{{ asset('assets/backend/js/index2.js') }}"></script>



    <!--app JS-->
    <script src="{{ asset('assets/backend/js/app.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/select2/js/select2-custom.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    {{-- date picker  --}}
    <script src="{{ asset('assets/backend/plugins/datetimepicker/js/legacy.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datetimepicker/js/picker.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datetimepicker/js/picker.time.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datetimepicker/js/picker.date.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/js/moment.min.js') }}"></script>
    <script
        src="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js') }}">
    </script>

    {{-- date range --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <script>
        new PerfectScrollbar(".app-container")
    </script>
    @stack('script')



    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });


        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        $('.number').keypress(function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
                ((event.which < 48 || event.which > 57) &&
                    (event.which != 0 && event.which != 8))) {
                event.preventDefault();
            }

            var text = $(this).val();

            if ((text.indexOf('.') != -1) &&
                (text.substring(text.indexOf('.')).length > 2) &&
                (event.which != 0 && event.which != 8) &&
                ($(this)[0].selectionStart >= text.length - 2)) {
                event.preventDefault();
            }
        });
    </script>




</body>

</html>
