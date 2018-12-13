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
    @if ($crud->hasAccess('list'))
        <a href="{{ starts_with(URL::previous(), url($crud->route)) ? URL::previous() : url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a>
    @endif
    <div class="row m-t-20">
        <div class="{{ $crud->getEditContentClass() }}">
            @include('crud::inc.grouped_errors')
            <form method="post"
                  action="{{ url($crud->route."/$id/run") }}"
            >
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}
                <div class="col-md-12">
                    <div class="row display-flex-wrap">
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->
                        @if(view()->exists('vendor.backpack.crud.form_content'))
                            @include('vendor.backpack.crud.form_content', ['fields' => $fields, 'action' => 'edit'])
                        @else
                            @include('crud::form_content', ['fields' => $fields, 'action' => 'edit'])
                        @endif
                    </div><!-- /.box-body -->
                    <div class="">

                        <button type="submit" class="btn btn-success">
                            <span class="fa fa-play" role="presentation" aria-hidden="true"></span> &nbsp;
                            <span>Run</span>
                        </button>

                        <a href="{{ url($crud->route) }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
                    </div><!-- /.box-footer-->
                </div><!-- /.box -->
            </form>
        </div>
    </div>
@endsection
