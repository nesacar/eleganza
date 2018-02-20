@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li><a href="{{ url('admin/sets') }}">Setovi</a></li>
        <li><a href="{{ url('admin/sets/'.$set->id.'/edit') }}">{{ $set->{'title:sr'} }}</a></li>
        <li class="active">Osobine</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><i class="fa fa-flask" style="margin-right: 5px"></i>Osobine</h4>
                </div>
                <div class="panel-body">
                    @include('admin.partials.errors')
                    <div class="col-md-12">
                        {{ $set->title }}
                    </div>
                    <hr>
                    {!! Form::open(['action' => ['SetsController@propertyUpdate', $set->id], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        <div class="col-md-12">
                            @if($properties)
                                <ul>
                                    @foreach($properties as $p)
                                        <li>
                                            <?php
                                            if(in_array($p->id, $propertyIds)){ ?>
                                            {!! Form::checkbox('properties[]', $p->id , 1) !!} id: {{ $p->id }} / {{ $p->{'title:sr'} }}
                                            <?php }else{ ?>
                                            {!! Form::checkbox('properties[]', $p->id, null) !!} id: {{ $p->id }} / {{ $p->{'title:sr'} }}
                                            <?php } ?>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <input type="submit" class="btn btn-success" value="Izmeni">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- .row -->
@endsection

@section('footer_scripts')
    var br=0;

    $('.switch-state').bootstrapSwitch();

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