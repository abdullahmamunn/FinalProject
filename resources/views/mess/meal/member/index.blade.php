@extends('layouts.master')
@section('title','Member List')
@section('content')
    <div class="app-content content" id="app">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    {{Breadcrumbs::render('member_list')}}
                </div>
                @php
                    $permissionCheck =  Session::get('permission_menu');
                @endphp
                @if (in_array('mess-member.store',$permissionCheck))
                    <div class="content-header-right col-md-6 col-12">
                        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown" data-toggle="modal" data-target="#addModel">
                            <a href="javascript:void(0)" class="btn btn-social width-200 mb-1 mr-1 btn-primary">
                                <span class="ft-plus-circle font-medium-5"></span> <b>Add New Member</b></a>
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

                                <member-list
                                        :permissions="{{json_encode($permissionCheck)}}"
                                        :role-list="{{json_encode($roleList)}}">
                                </member-list>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@stop

@section('custom_js')
    <script src="{{ asset('js/manage-member.js') }}"></script>
@stop