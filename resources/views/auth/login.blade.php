<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome | ERP</title>
    <!-- plugins:css -->

    <link rel="stylesheet" href="css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Fav icon -->
    {{-- <link rel="shortcut icon" href="img/branding-sparrow-logo.jpg"> --}}
</head>

<body data-new-gr-c-s-check-loaded="14.1062.0" data-gr-ext-installed="">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        {{-- @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif --}}
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                                <div class="brand-logo">
                                    <center><label
                                            style="font-size: 40px;color:black;font-family: Georgia, serif;">ERP</label>
                                    </center>
                                </div>
                                <h4 style="text-align: center;">Hello! let's get started</h4>
                                <h6 class="font-weight-light" style="text-align: center;">Sign in to continue.</h6>
                                <form class="pt-3" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="email" type="email" style="border-radius: 10px;"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" placeholder="Username"required
                                            autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" style="border-radius: 10px;"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password"
                                            placeholder="Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <center>
                                            <button type="submit"
                                                style="color: #fff;margin-top: 5%;margin-bottom: 5%; border-radius:10px;background-color:black;"
                                                class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                                {{ __('SIGN IN') }}
                                            </button>
                                        </center>
                                    </div>


                                    {{-- <div class="text-center mt-4 font-weight-light">
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}"
                                                        style="color: #000;font-weight: 700;">{{ __('Forgot Your Password?') }}</a>
                                                @endif
                                            </div> --}}


                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="js/vendor.bundle.base.js.download"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="js/Chart.min.js.download"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js.download"></script>
    <script src="js/hoverable-collapse.js.download"></script>
    <script src="js/template.js.download"></script>
    <script src="js/settings.js.download"></script>
    <script src="jstodolist.js.download"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/dashboard.js.download"></script>
    <!-- End custom js for this page-->




</body>
<grammarly-desktop-integration data-grammarly-shadow-root="true"></grammarly-desktop-integration>

</html>


</div>
</body>

</html>
