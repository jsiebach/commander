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

            {!! Form::open(array('url' => $crud->route."/$id/run", 'method' => 'post')) !!}
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">Configuration</h3>
                </div>
                <div class="box-body row">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    @if(view()->exists('vendor.backpack.crud.form_content'))
                        @include('vendor.backpack.crud.form_content', [ 'fields' => $fields])
                    @else
                        @include('crud::form_content', [ 'fields' => $fields])
                    @endif
                </div><!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-success">
                        <span class="fa fa-play" role="presentation" aria-hidden="true"></span> &nbsp;
                        <span>Run</span>
                    </button>

                    <a href="{{ url($crud->route) }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
                </div><!-- /.box-footer-->

            </div><!-- /.box -->
            {!! Form::close() !!}
        </div>
    </div>

@endsection