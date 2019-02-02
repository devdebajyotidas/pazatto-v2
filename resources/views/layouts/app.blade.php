<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pazatto') }}</title>

    <!-- Styles -->
    @include('includes.css')
</head>
<body id="{{ $page }}" class="content-wrapper no-sidebar">
    <div id="wrapper">
        <!-- Preloader -->
        <div class="preloader" style="display: none;">
            <div class="cssload-speeding-wheel"></div>
        </div>
        @include('includes.header')
        @include('includes.main-menu')
{{--        @include('includes.sidebar')--}}

        <!-- Page Content -->
        <div id="page-wrapper">
            @if(session('role') == 'vendor')
                <div class="row">
                    <div class="col-md-12 text-center m-t-20">
                        <div class="card bg-white">
                            <form method="post" action="{{ url("vendors/" . auth()->user()->account->id . '/take-orders' ) }}">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <div class="form-group m-0">
                                    <label for="">Taking Orders</label>
                                </div>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn  @if(auth()->user()->account->is_taking_orders == 1) {{ 'btn-primary active' }} @else {{ 'btn-secondary' }} @endif">
                                        <input type="radio" name="vendor[is_taking_orders]" value="1"  autocomplete="off" @if(auth()->user()->account->is_taking_orders == 1) {{ 'checked' }} @endif  onchange="this.form.submit()"> Yes
                                    </label>
                                    <label class="btn @if(auth()->user()->account->is_taking_orders == 0) {{ 'btn-primary active' }} @else {{ 'btn-secondary' }} @endif">
                                        <input type="radio" name="vendor[is_taking_orders]" value="0" autocomplete="off" @if(auth()->user()->account->is_taking_orders == 0) {{ 'checked' }} @endif onchange="this.form.submit()"> No
                                    </label>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            @endif

            @yield('content')
            @include('includes.footer')
        </div>
        @include('includes.right-sidebar')
    </div>

<!-- Scripts -->
@include('includes.js')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/bootstrap-select.min.js"></script>


    <script>
        $(document).ready(function () {
            @if($errors->any())
                @foreach($errors->all() as $error)
                    showToast("Error", "{{ $error }}", "error");
                @endforeach
            @endif

            @if(session()->has('success'))
                showToast("Success", "{{ session()->get('success') }}", "success");
            @endif
        });
    </script>
</body>
</html>
