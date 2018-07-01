@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/newsletters') }}">Newsletteri</a></li>
        <li class="active">Izmena</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-envelope" style="margin-right: 5px"></i>Podaci o Newsletteru</h4>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    {!! Form::open(['action' => ['NewslettersController@update', $newsletter->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Naziv</label>
                            <div class="col-sm-10">
                                {!! Form::text('title', $newsletter->title, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <label for="posts" class="col-sm-2 control-label">1 članak</label>
                            <div class="col-sm-10">
                                {!! Form::select('posts[]', $posts, $postIds[0], array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">1 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[0], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">2 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[1], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">3 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[2], array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="posts" class="col-sm-2 control-label">2 članak</label>
                            <div class="col-sm-10">
                                {!! Form::select('posts[]', $posts, $postIds[1], array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">4 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[3], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">5 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[4], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">6 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[5], array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="posts" class="col-sm-2 control-label">3 članak</label>
                            <div class="col-sm-10">
                                {!! Form::select('posts[]', $posts, $postIds[2], array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">7 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[6], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">8 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[7], array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="products" class="col-sm-2 control-label">9 Proizvod</label>
                            <div class="col-sm-10">
                                {!! Form::select('products[]', $products, $productIds[8], array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="send" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-success" value="Potvrdi">
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- .row -->

@endsection

@section('footer')
    {!! HTML::script('admin/plugins/moment/moment.js') !!}
    {!! HTML::script('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('admin/plugins/select2/js/select2.min.js') !!}
@endsection

@section('footer_scripts')

    $('.switch-state').bootstrapSwitch();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.switch-state');

    sw.bootstrapSwitch();

    $('#publish_at').datetimepicker({format: 'YYYY-MM-DD HH:mm'});

    $("select").select2();

    $(".tag").select2({
        'placeholder': 'Izaberi tag',
        'tags': 'true'
    });

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


    @if (Session::has('done'))
        toastr["success"]("{{ Session::get('done') }}");

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
    @endif

    $('.potvrdi').click(function(e){
        e.preventDefault();
        var place = $('.place');
        var count = $('.number').val();
        var locale = $('#locale').val();
        if(count != '' && count > 0){
            $.get('{{ url("admin/newsletters/append") }}', {count: count, locale: locale}, function(data){ place.html(data); })
        }else{
            console.log('pogresan format');
        }
    });
@endsection