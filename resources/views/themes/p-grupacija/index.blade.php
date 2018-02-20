<!DOCTYPE html>
<html lang="sr" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="author" content="pggrupa.rs" />
    <link rel="shortcut icon" href="{{ url('img/favicon.ico') }}">

    @yield('seo_social_stuff')

    {!! HTML::style($theme->slug.'/css/normalize.css') !!}
    {!! HTML::style($theme->slug.'/css/demo.css') !!}
    {!! HTML::style($theme->slug.'/css/icons.css') !!}
    {!! HTML::style($theme->slug.'/css/component.css') !!}
    {!! HTML::style($theme->slug.'/css/bootstrap.css') !!}
    {!! HTML::style($theme->slug.'/css/font-awesome.min.css') !!}
    {!! HTML::style($theme->slug.'/css/jquery.bxslider.css') !!}
    {!! HTML::style($theme->slug.'/css/select2.css') !!}
    {!! HTML::style($theme->slug.'/css/easyzoom.css') !!}
    {!! HTML::style('admin/plugins/toastr/toastr.min.css') !!}
    {!! HTML::style('admin/plugins/fontawesome/css/font-awesome.min.css') !!}
    @yield('header')
    {!! HTML::style($theme->slug.'/css/style.css') !!}

    {!! HTML::script($theme->slug.'/js/modernizr.custom.js') !!}
    {!! HTML::script($theme->slug.'/js/jquery-2.2.4.min.js') !!}

</head>
<body>
<div id="overlay" class="overlay"></div>
<div class="container-mp">
    <!-- Push Wrapper -->
    <div class="mp-pusher" id="mp-pusher">

        @include('themes.'.$theme->slug.'.partials.mobile-menu')

        <div class="scroller"><!-- this is for emulating position fixed of the nav -->
            <div class="scroller-inner">

                <div id="site" class="container">
                    @include('themes.'.$theme->slug.'.partials.header')
                </div>

                @include('themes.'.$theme->slug.'.partials.nav')

                <div class="container">
                    @yield('content')
                </div>
                <div class="container-fluid footer-bg">
                    <div class="container">
                        @include('themes.'.$theme->slug.'.partials.footer-up')
                    </div>
                </div>
                <div class="container-fluid footer-bg2">
                    <div class="container">
                        @include('themes.'.$theme->slug.'.partials.footer')
                    </div>
                </div>
            </div>
        </div><!-- /scroller-inner -->
    </div><!-- /scroller -->

</div><!-- /pusher -->
</div><!-- /container -->
{!! HTML::script($theme->slug.'/js/classie.js') !!}
{!! HTML::script($theme->slug.'/js/mlpushmenu.js') !!}
{!! HTML::script($theme->slug.'/js/bootstrap.min.js') !!}
{!! HTML::script($theme->slug.'/js/jquery.bxslider.js') !!}
{!! HTML::script($theme->slug.'/js/select2.min.js') !!}
{!! HTML::script($theme->slug.'/js/easyzoom.js') !!}
{!! HTML::script('admin/plugins/toastr/toastr.min.js') !!}
{!! HTML::script($theme->slug.'/js/scripts.js') !!}
@yield('footer')
<script>
    new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ) );
    $(function(){
        $('.bxslider').bxSlider();
        $('[data-toggle="tooltip"]').tooltip();

        @if(\Session::get('hide') != true)
        setTimeout(function(){
            var w = $(window).width();
            if(w > 991){
                $('.newsletter-popup').slideDown(2000);
            }
        }, 5000);
        @endif

        $('.nws').click(function(){
             if($(this).val() == ''){
                 $(this).val('Unesite Vašu email adresu');
             }
        });

        $('.nws').keydown(function(){
            if($(this).val() == 'Unesite Vašu email adresu'){
                $(this).val('');
            }
        });

        $('.close-btn').click(function(){
              $.post('{{ url("hide") }}', {_token: '{{ csrf_token() }}'}, function(data){ if(data == 'da'){ $('.newsletter-popup').slideUp(); } });
        });

        var www = $(window).width();

        if(www < 991){
            hideMenu();
        }else{
            @if(count($topCat))
                postaviKockicu();
            @endif
            }

        @if(count($topCat))

            $('.left-menu').find('a').click(
                function(){
                    hideMenu();
                    postaviKockicu($(this));
                }
              
            );

            $(window).resize(function(){
                var www = $(window).width();
                if(www < 991){
                    hideMenu();
                }else{
                    postaviKockicu();
                }
            });



        function postaviKockicu(id){
            if(id){
                var active = id;
                var activeId = active.attr('id');
                var levo = active.position().left;
                var duzina = active.width();

                hideMenu();
                $('.kockica').css({'left': (duzina/2 + levo) - duzina/6});
                $('#'+activeId+'-menu').fadeIn(function(){
                    stickyClone = $('.stick').clone().addClass('sticky');
                });

            }else{
                var active = $('.left-menu').find('.active');
                var activeId = active.attr('id');
                console.log(activeId);
                var levo = active.position().left;
                var duzina = active.width();

                @foreach($topCat as $c)
                    $('.left-menu').find('a').each(function(){
                            var param = $(this).attr('id');
                            if(param == '{{ $active }}'){
                                $('.kockica').css({'left': (duzina/2 + levo) - duzina/6});
                                $('#'+param+'-menu').fadeIn(function(){
                                    stickyClone = $('.stick').clone().addClass('sticky');
                                });
                            }
                        });
                @endforeach

                }

            }

            function hideMenu(){
                $('.navbar-nav').each(function(){
                    $(this).css({'display':'none'});
                });
            }

        @endif

        @if(!empty(\Session::get('done')))
            $.notify("{{ \Session::get('done') }}", {
                type: "info",
                animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutUp'
                }
            });
        @endif

            @yield('footer_scripts')

        });
</script>
@include('themes.'.$theme->slug.'.partials.addthis-body')
@include('themes.'.$theme->slug.'.partials.popup')
</body>
</html>