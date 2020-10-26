@extends('layouts.master')
@section('title','Balance Credit List')
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('app-assets/plugins/vue-multiselect/vue-multiselect.min.css') }}">
@stop
@section('content')
    <div class="app-content content" id="app">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
{{--                    {{Breadcrumbs::render('member_list')}}--}}
                </div>
                @php
                    $permissionCheck =  Session::get('permission_menu');
                @endphp
                @if (in_array('market.store',$permissionCheck))
                    <div class="content-header-right col-md-6 col-12">
                        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown" data-toggle="modal" data-target="#addModel">
                            <a href="javascript:void(0)" class="btn btn-social width-200 mb-1 mr-1 btn-primary">
                                <span class="ft-plus-circle font-medium-5"></span> <b>Add New Credit info</b></a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="content-body">
                <section id="configuration">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">@yield('title')</h4>
                                </div>

                                <balance-credit-list
                                        :permissions="{{json_encode($permissionCheck)}}"
                                        :members="{{json_encode($members)}}"
                                ></balance-credit-list>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop

@section('custom_js')
    <script src="{{ asset('js/balance-credit-list.js') }}"></script>
@stop