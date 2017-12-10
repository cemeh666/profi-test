@extends('layouts.front')

@section('content')

    <div class="tab-content">
        <div id="auth" class="tab-pane fade in active">
            @include('_auth')
        </div>
        <div id="category" class="tab-pane fade">
            @include('_category')
        </div>
        <div id="goods" class="tab-pane fade">
            @include('_goods')
        </div>
    </div>

@endsection
