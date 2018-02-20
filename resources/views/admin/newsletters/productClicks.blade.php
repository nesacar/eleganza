@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Početna</a></li>
        <li><a href="{{ url('admin/newsletters') }}">Newsletters</a></li>
        <li><a href="{{ url('admin/newsletters/'.$newsletter->id.'/preview') }}">{{ $newsletter->title }}</a></li>
        <li class="active">Pregled klikova</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Proizvod: <a href="{{ \App\Product::getProductLink($product->id) }}" target="_blank" style="color: #82403b;">{{ $product->title }}</a></h3>
                    <div class="panel-control">
                        <a href="{{ url('admin/newsletters/create') }}" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Kreiraj newsletter"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel-header-stats">
                        @if(count($clicks) > 0)
                            <div class="row">
                                <div class="col-md-9">
                                    <b>E-mail</b>
                                </div>
                                <div class="col-md-3">
                                    <b>Klikovi</b>
                                </div>
                            </div>
                            <hr>
                            @foreach($clicks as $c)
                                <div class="row">
                                    <div class="col-md-9 vcenter">
                                        {{ $c->email }}
                                    </div>
                                    <div class="col-md-3 vcenter">
                                        {{ $c->click }}
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    {!! str_replace('/?', '?', $clicks->render()) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.switch-state');


    sw.bootstrapSwitch();

    sw.on('switchChange.bootstrapSwitch', function (e, data) {

    $('#myswitch').bootstrapSwitch('state', !data, true);
        var id = $(this).attr('id');
        var link = 'posts/publish/' + id;
        $.get(link, {id: id, val:data}, function($stat){ if($stat=='da'){ save(); $('#'+id).parent().parent().parent().parent().toggleClass('crvena'); }else{ error(); } });
    });

    @if(Session::has('done'))
        toastr["success"]("{{ Session::get('done') }}");
    @endif

    @if(Session::has('error'))
        toastr["error"]("{{ Session::get('error') }}");
    @endif

    function save(){
        toastr["success"]("Izmenjeno");
    }

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

@endsection