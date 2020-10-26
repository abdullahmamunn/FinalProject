@extends('layouts.master')
@section('title','Dashboard')
@section('content')
    <!--Main content-->
    <div class="app-content content" id="app">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><strong>Dashboard</strong></a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Stats -->
                <meal-dashboard></meal-dashboard>

                </div>
            </div>
        </div>
    </div>
@stop
@section('custom_js')
    <script src="{{ asset('js/meal-dashboard.js') }}"></script>
@stop
