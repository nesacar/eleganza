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
                        {!! Form::hidden('language_id', $newsletter->language_id) !!}
                        {!! Form::hidden('types', $newsletter->types) !!}
                        {!! Form::hidden('numbers', $newsletter->numbers) !!}
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Naziv</label>
                            <div class="col-sm-10">
                                {!! Form::text('title', $newsletter->title, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lang" class="col-sm-2 control-label">Jezik</label>
                            <div class="col-sm-10">
                                {!! Form::text('lang', $newsletter->language->name, array('class' => 'form-control', 'disabled' => true)) !!}
                            </div>
                        </div>
                        <hr>
                        @php $productbr=0; $bannerbr=0; $postbr=0; @endphp
                        @for($i=0;$i<count($types);$i++)
                            @if($types[$i] == 1)
                                @for($j=0;$j<$numbers[$i];$j++)
                                    <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Proizvodi</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('products[]', $products, $productIds[$productbr], array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    @php $productbr++; @endphp
                                @endfor
                            @elseif($types[$i] == 2)
                                @for($j=0;$j<$numbers[$i];$j++)
                                    <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Baneri</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('banners[]', $banners, $bannerIds[$bannerbr], array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    @php $bannerbr++; @endphp
                                @endfor
                            @elseif($types[$i] == 3)
                                @for($j=0;$j<$numbers[$i];$j++)
                                    <div class="form-group">
                                        <label for="number" class="col-sm-2 control-label">Članci</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('posts[]', $posts, $postIds[$postbr], array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    @php $postbr++; @endphp
                                @endfor
                            @endif
                        @endfor
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

@endsection