@extends('layouts.master')
@section('title','App Settings')
@section('custom_css')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <style>
        .card-header .heading-elements, .card-header .heading-elements-toggle {
            top: 2px;
            right: 1px;
        }
    </style>
@stop
@section('content')
    <div class="app-content content" id="auko-app">
        <div class="content-wrapper">
            <div class="content-header row">

            </div>
            <div class="content-body">
                <settings></settings>
            </div>
        </div>
    </div>
@stop
@section('custom_js')
    <script src="{{ asset('js/settings.js') }}"></script>
@stop
