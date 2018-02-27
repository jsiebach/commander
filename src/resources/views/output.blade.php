@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{$title}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li class="active">{{$title}}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            @if ($crud->hasAccess('list'))
                <a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
            @endif

            @include('crud::inc.grouped_errors')

            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">Output</h3>
                </div>
                <div class="box-body row">
                    <div class="col-xs-12">
                        Exit Code: {{$exitCode}}
                        <pre>{{$output}}</pre>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ url($crud->route) }}" class="btn btn-success"><span class="fa fa-sign-out"></span> &nbsp;Return</a>
                </div><!-- /.box-footer-->

            </div><!-- /.box -->
        </div>
    </div>

@endsection