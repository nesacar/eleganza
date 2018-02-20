@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Početna</a></li>
        <li><a href="{{ url('admin/newsletters') }}">Newsletters</a></li>
        <li><a href="{{ url('admin/statistics/'.$newsletter->id.'/dayNewsletter') }}">{{ $newsletter->title }}</a></li>
        <li class="active">Spisak pretplatnika</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="widget">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_table" data-toggle="tab"><i class="fa fa-envelope"></i> Pregled klikova</a></li>
                        </ul>
                        <div class="tab-content bottom-margin">
                            <a href="{{ url('admin/posts/create') }}" class="fa fa-plus-square fa-4x pull-right add" data-toggle="tooltip" data-placement="top" title="Dodaj članak"></a>
                            <div style="clear: both;"></div>
                            <div class="tab-pane active" id="tab_table">
                                <div class="padded">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Broj klikova</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($subscribers) > 0)
                                            @foreach($subscribers as $s)
                                                <tr>
                                                    <td>{{ $s->email }}</td>
                                                    <td>{{ $s->click }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        {!! str_replace('/?', '?', $subscribers->render()) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .row -->

@endsection

@section('footer')
    {!! HTML::script('admin/plugins/moment/moment.js') !!}
    {!! HTML::script('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('admin/plugins/select2/js/select2.min.js') !!}
    {!! HTML::script('admin/plugins/charts/Chart.min.js') !!}
@endsection

@section('footer_scripts')

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    @if (Session::has('save'))
        $.notify({
        message: '{{ \Session::get('save') }}'
        },{
        type: 'success'
        });
    @endif

    function save(){
    $.notify({
    message: 'Izmenjeno'
    },{
    type: 'success'
    });
    }
    function error(){
    $.notify({
    message: 'Proizvod nije pronadjen.'
    },{
    type: 'danger'
    });
    }
@endsection