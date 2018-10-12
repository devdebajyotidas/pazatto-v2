@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <!-- row -->
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="white-box">
                    <div class="page-aside">

                        <div class="row">
                            <div class="col-md-3">
                                <form action="{{ url('settings/' . $settings->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <div class="form-group">
                                        <label for="">Pazatto Commission</label>
                                        <input type="number" name="pazatto_commission" class="form-control" value="{{ $settings->pazatto_commission }}">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection