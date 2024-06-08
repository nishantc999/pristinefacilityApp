@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-12 col-lg-3">
                @include('clients.sidebar')
            </div>
            <div class="col-12 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h1>Dashboard</h1>
                        <!-- Dashboard content here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
