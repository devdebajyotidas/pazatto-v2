@extends("layouts.app")
@section("content")

    @if($mode == "sales")
        @include("reports.partials.sales")
    @endif

    @if($mode == "deliveries")
        @include("reports.partials.deliveries")
    @endif

@endsection