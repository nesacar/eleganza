@extends('admin.index')

@section('header')
    {!! HTML::style('admin/plugins/select2/css/select2.min.css') !!}
    {!! HTML::style('admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@endsection

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/posts') }}">Članci</a></li>
        <li class="active">Izmena</li>
    </ol>
@endsection

@section('content')

    <div class="row">
        @include('admin.partials.errors')
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-file-text-o" style="margin-right: 5px"></i>Podaci o članku</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) !!}
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Naziv <span class="crvena-zvezdica">*</span></label>
                        <div class="col-sm-10">
                            {!! Form::text('title', $post->title, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="short" class="col-sm-2 control-label">SEO opis <span class="crvena-zvezdica">*</span></label>
                        <div class="col-sm-10">
                            {!! Form::textarea('short', $post->short, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="body" class="col-sm-2 control-label">Ceo opis</label>
                        <div class="col-sm-10">
                            {!! Form::textarea('body', $post->body, array('class' => 'form-control', 'id' => 'body')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publish_at" class="col-sm-3 control-label">Vreme publikovanja <span class="crvena-zvezdica">*</span></label>
                        <div class="col-sm-9">
                            {!! Form::text('publish_at', $post->publish_at, array('class' => 'form-control', 'id' => 'publish_at')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        @if($post->image != null && $post->image != '')
                            <div class="place">
                                <img src="{{ url($post->image) }}" alt="{{ $post->title }}" style="max-width: 250px;margin-bottom: 10px">
                                <a class="btn btn-danger remove" href="{{ url('admin/posts/'.$post->id.'/deleteimg') }}">Obriši sliku</a>
                            </div>
                        @else
                            <label for="image" class="col-sm-3 control-label">Slika</label>
                            <div class="col-sm-9">
                                {!! Form::file('image') !!}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="home" class="col-sm-3 control-label">Prikazuje se u početnoj strani</label>
                        <div class="col-sm-9">
                            {!! Form::checkbox('home', 1, $post->home, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="publish" class="col-sm-3 control-label">Vidljivo</label>
                        <div class="col-sm-9">
                            {!! Form::checkbox('publish', 1, $post->publish, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tag" class="col-sm-3 control-label">Tagovi</label>
                        <div class="col-sm-9">
                            {!! Form::select('tags[]', $tags, $tag_ids, ['id' => 'tag', 'class' => 'form-control', 'multiple']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-2 control-label">Kategorije <span class="crvena-zvezdica">*</span></label>
                        <div class="col-sm-10">
                            {!! \App\PCategory::getSortPCategoryCheckbox(false, $catids) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-success pull-right" value="Izmeni">
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div><!-- .col-md-12 -->

    </div>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div><!-- .row -->

@endsection

@section('footer')
    {!! HTML::script('admin/plugins/moment/moment.js') !!}
    {!! HTML::script('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('admin/ckeditor/ckeditor.js') !!}
    {!! HTML::script('admin/plugins/select2/js/select2.min.js') !!}
@endsection

@section('footer_scripts')

    $('.switch-state').bootstrapSwitch();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var sw = $('.switch-state');


    sw.bootstrapSwitch();

    window.onload = function () {
        CKEDITOR.replace('body', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}"
        });
    };

    $('#publish_at').datetimepicker({format: 'YYYY-MM-DD HH:mm'});

    $("#tag").select2({
        'placeholder': 'Izaberi tag',
        'tags': 'true'
    });

    $("#tag2").select2({
        'placeholder': 'Izaberi tag',
        'tags': 'true'
    });

    $('.remove').click(function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        var img = $(this).attr('data-img');
        var place = $(this).parent();
        if (confirm('Da li ste sigurni da hoćete da obrišete ovu sliku?')) {
            $.post(link, { _token: '{{ csrf_token() }}', img: img }, function(data){ place.html(data); });
        }
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