@extends('admin.index')

@section('bredcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}">Home</a></li>
        <li class="active">Podešavanje</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Podešavanje sajta</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['action' => ['SettingsController@update', $setting->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Slogan sajta</label>
                        <div class="col-sm-9">
                            {!! Form::text('title', $setting->title, array('class' => 'form-control', 'id' => 'title')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keywords" class="col-sm-3 control-label">Ključne reči</label>
                        <div class="col-sm-9">
                            {!! Form::text('keywords', $setting->keywords, array('class' => 'form-control', 'id' => 'keywords')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="col-sm-3 control-label">Opis sajta</label>
                        <div class="col-sm-9">
                            {!! Form::textarea('desc', $setting->desc, array('class' => 'form-control', 'id' => 'desc')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="footer" class="col-sm-3 control-label">Tekst u footeru</label>
                        <div class="col-sm-9">
                            {!! Form::textarea('footer', $setting->footer, array('class' => 'form-control', 'id' => 'footer')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="course" class="col-sm-3 control-label">Kurs eura</label>
                        <div class="col-sm-9">
                            {!! Form::text('course', $setting->course, array('class' => 'form-control', 'id' => 'course')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Adresa</label>
                        <div class="col-sm-9">
                            {!! Form::text('address', $setting->address, array('class' => 'form-control', 'id' => 'address')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone1" class="col-sm-3 control-label">Telefon 1</label>
                        <div class="col-sm-9">
                            {!! Form::text('phone1', $setting->phone1, array('class' => 'form-control', 'id' => 'phone1')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone2" class="col-sm-3 control-label">Telefon 2</label>
                        <div class="col-sm-9">
                            {!! Form::text('phone2', $setting->phone2, array('class' => 'form-control', 'id' => 'phone2')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email1" class="col-sm-3 control-label">Email 1</label>
                        <div class="col-sm-9">
                            {!! Form::text('email1', $setting->email1, array('class' => 'form-control', 'id' => 'email1')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email2" class="col-sm-3 control-label">Email 2</label>
                        <div class="col-sm-9">
                            {!! Form::text('email2', $setting->email2, array('class' => 'form-control', 'id' => 'email2')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="facebook" class="col-sm-3 control-label">Facebook</label>
                        <div class="col-sm-9">
                            {!! Form::text('facebook', $setting->facebook, array('class' => 'form-control', 'id' => 'facebook')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="twitter" class="col-sm-3 control-label">Pinterest</label>
                        <div class="col-sm-9">
                            {!! Form::text('twitter', $setting->pinterest, array('class' => 'form-control', 'id' => 'pinterest')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="instagram" class="col-sm-3 control-label">Instagram</label>
                        <div class="col-sm-9">
                            {!! Form::text('instagram', $setting->instagram, array('class' => 'form-control', 'id' => 'instagram')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="google" class="col-sm-3 control-label">Google plus</label>
                        <div class="col-sm-9">
                            {!! Form::text('google', $setting->google, array('class' => 'form-control', 'id' => 'google')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="map" class="col-sm-3 control-label">Google mapa</label>
                        <div class="col-sm-9">
                            {!! Form::textarea('map', $setting->map, array('class' => 'form-control', 'id' => 'map')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="analytics" class="col-sm-3 control-label">Google analitika</label>
                        <div class="col-sm-9">
                            {!! Form::textarea('analytics', $setting->analytics, array('class' => 'form-control', 'id' => 'analytics')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="blog" class="col-sm-3 control-label">Sajt ima blog</label>
                        <div class="col-sm-9">
                            {!! Form::checkbox('blog', 1, $setting->blog, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shop" class="col-sm-3 control-label">Sajt ima shop</label>
                        <div class="col-sm-9">
                            {!! Form::checkbox('shop', 1, $setting->shop, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="materialDependence" class="col-sm-3 control-label">Prikaz slika proizvoda po materijalima</label>
                        <div class="col-sm-9">
                            {!! Form::checkbox('materialDependence', 1, $setting->materialDependence, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="colorDependence" class="col-sm-3 control-label">Prikaz slika proizvoda po bojama</label>
                        <div class="col-sm-9">
                            {!! Form::checkbox('colorDependence', 1, $setting->colorDependence, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newsletter" class="col-sm-3 control-label">Sajt ima Newsletter</label>
                        <div class="col-sm-9">
                            {!! Form::checkbox('newsletter', 1, $setting->newsletter, ['class' => 'switch-state', 'data-on-color' => 'success', 'data-off-color' => 'danger', 'data-on-text' => 'DA', 'data-off-text' => 'NE', 'id' => 'active']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="omot" class="col-sm-3 control-label">Cena omota</label>
                        <div class="col-sm-9">
                            {!! Form::text('omot', $setting->omot, array('class' => 'form-control', 'id' => 'omot')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-success pull-right" value="Izmeni">
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div><!-- .col-md-12 -->
    </div><!-- .row -->
@endsection

@section('footer_scripts')
    var br=0;

    $('.switch-state').bootstrapSwitch();

    $('.new').click(function(e){
        e.preventDefault();
        $('.hidden').first().removeClass('hidden');
    });

    $('.for').click(function(e){
        e.preventDefault();
        br++;
        $('.foreign').first().removeClass('foreign');
        if(br == 2){
            $('.for').fadeOut();
        }
    });

    @if (\Session::has('done'))
        toastr["success"]("{{ \Session::get('done') }}");

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