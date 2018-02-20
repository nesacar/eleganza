$(function(){
    var ww = $(window).width();


    shopBarImageHolder(ww);

    $( window ).resize(function() {
        ww = $(window).width();
        shopBarImageHolder(ww);

    });

    // grab the initial top offset of the navigation
    var stickyNavTop = $('.stick').offset().top;
    var stickyOriginal = $('.stick');
    var stickyClone = stickyOriginal.clone().addClass('sticky');



    $(".dropdown").hover(
        function() { $('.dropdown-menu', this).fadeIn("fast");
        },
        function() { $('.dropdown-menu', this).fadeOut("fast");
        });

    $('#overlay').hide();
    $('.shopic').mouseenter(function () {
        $('#overlay').show();
    });
    $('#overlay').mouseenter(function () {
        $('#overlay').hide();
    });

  $('.shop-bar .text-holder .sh').each(function(){
        $(this).hover(
            function(){
                $(this).css({'clip': 'rect(0px,120px,40px,0px)', 'background-image': 'img/arrow-orange-2.jpg'});
            },
            function(){
                $(this).css({'clip': 'rect(0px,40px,40px,0px)', 'background-image': 'img/arrow-orange.jpg'});
            }
        );
    });   



 
    /***** search ********/

    $('html,body').click(function(e){
            if (e.target.id == 'klik') {
                $('#srch').css({'clip':'rect(0px,250px,40px,0px)'}).addClass('sjaj');
            } else {
                if (e.target.id == 'pretraga') {
                    // hold on
                }else{
                    $('#srch').css({'clip':'rect(0px,250px,40px,250px)'}).removeClass('sjaj');
                }
            }
        });


    /****** kockica navigacija ***********/

    /*$('#satovi').hover(function(){
        $('.kockica').css({'left':20});
        $('#aksesoari-menu').fadeOut();
        $('#posudje-menu').fadeOut();
        $('#satovi-menu').fadeIn(function(){
            stickyClone = $('.stick').clone().addClass('sticky');
        });

    }, function(){});

    $('#aksesoari').hover(function(){
        $('.kockica').css({'left':120});
        $('#satovi-menu').fadeOut();
        $('#posudje-menu').fadeOut();
        $('#aksesoari-menu').fadeIn(function(){
            stickyClone = $('.stick').clone().addClass('sticky');
        });

    }, function(){});

    $('#posudje').hover(function(){
        $('.kockica').css({'left':295});
        $('#satovi-menu').fadeOut();
        $('#aksesoari-menu').fadeOut();
        $('#posudje-menu').fadeIn(function(){
            stickyClone = $('.stick').clone().addClass('sticky');
        });

    }, function(){});*/

    /*$('.trig').click(function(e){
        e.preventDefault();
    });*/

    /***** mega menu - mega sat *******/

    $('.second').hover(
        function(){
            var img = $(this).attr('data-large');
            var desc = $(this).attr('data-desc');
            var title = $(this).text();
            var target = $('.megamenu-content').find('.mega-sat');
            var opis = $('.megamenu-content').find('.opis');
            var druga = $('.megamenu-content').find('.druga');
            var treca = $('.megamenu-content').find('.treca');
            target.attr('src', img);
            opis.text(desc);
            druga.text(title);
            treca.text('');
        },
        function(){}
    );

    $('.third').hover(
        function(){
            var img = $(this).attr('data-large');
            var desc = $(this).attr('data-desc');
            var title = $(this).text();
            var target = $('.megamenu-content').find('.mega-sat');
            var opis = $('.megamenu-content').find('.opis');
            var druga = $('.megamenu-content').find('.druga');
            var treca = $('.megamenu-content').find('.treca');
            var parent = $(this).attr('data-parent');
            target.attr('src', img);
            opis.text(desc);
            druga.text(parent);
            treca.text(title);
        },
        function(){}
    );

    /***** image mask *******/
    imageMask(ww);

    /****** fix nav ******/
    $(window).scroll(function(){
        var h = $(this).scrollTop();
        /*fixNav(h);*/
    });

    function imageMask(w){
        if(w > 768){
            $('.left .image-holder').each(function(){
                $(this).hover(
                    function(){
                        var w = $(this).css('width');
                        var h = $(this).css('height');
                        $(this).find('img').parent().append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
                    },
                    function(){
                        setTimeout(function(){
                            $(this).find('.mask-holder').remove();
                        }, 1000);
                    }
                );
            });

            $('.right .image-holder').each(function(){
                $(this).hover(
                    function(){
                        var w = $(this).css('width');
                        var h = $(this).css('height');
                        $(this).find('img').parent().append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
                    },
                    function(){
                        setTimeout(function(){
                            $(this).find('.mask-holder').remove();
                        }, 1000);
                    }
                );
            });

            $('.top-one li > a').hover(
                function(){
                    var w = $(this).parent().css('width');
                    var h = $(this).parent().css('height');
                    $(this).append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
                },
                function(){
                    setTimeout(function(){
                        $(this).find('.mask-holder').remove();
                    }, 1000);
                }
            );

            $('.pretragaTekst .image-holder').each(function(){
                $(this).hover(
                    function(){
                        console.log('hover');
                        var w = $(this).css('width');
                        var h = $(this).css('height');
                        $(this).find('img').parent().append('<div class="mask-holder" style="width: '+w+';height:'+h+'"></div>');
                    },
                    function(){
                        setTimeout(function(){
                            $(this).find('.mask-holder').remove();
                        }, 1000);
                    }
                );
            });
        }
    }




    // our function that decides weather the navigation bar should have "fixed" css position or not.
    var stickyNav = function(){
        var scrollTop = $(window).scrollTop(); // our current vertical position from the top

        // if we've scrolled more than the navigation, change its position to fixed to stick to top,
        // otherwise change it back to relative
        if (scrollTop > stickyNavTop) {
            $('.stick').addClass('sticky');
            //if(stickyClone.is(':hidden')) stickyClone.insertAfter(stickyOriginal);
        } else {
            $('.stick').removeClass('sticky');
            //stickyClone.remove();
        }
    };

    stickyNav();
    // and run it again every time you scroll
    $(window).scroll(function() {
        stickyNav();
    });



    function fixNav(h){
        if(h > 100){
            $('nav').css({'position':'fixed', 'top': 0, 'z-index': 100, 'margin': '0 auto', 'width': 100+'%'});
            $('body').css({'margin-top':40});
        }else{
            $('nav').css({'position':'relative'});
            $('body').css({'margin-top':0});
        }
    }


    function najvisaPod(dropField){
        var highest = null;
        var hi = 0;
        var pod = 0;
        dropField.find('ul.pod').each(function(){
            var h = $(this).height();
            if(h > hi){
                hi = h;
                highest = $(this);
            }
        });
        if(highest){
            pod = highest.height();
            $('.opis').css({
                'margin-top': pod + 29
            });
        }
    }

    function shopBarImageHolder(w){
        if(w > 768){
            $('.shop-bar .image-holder').each(function(){
                $(this).hover(
                    function(){
                        var img = $(this).css('background-image');
                        $(this).css({'clip':'rect(-10px,180px,306px,0px)', 'border-top': '10px solid white', 'border-bottom': '10px solid white'});
                        $(this).parent().parent().find('.sh').css({'clip': 'rect(0px,120px,40px,0px)', 'background-image': 'img/arrow-orange-2.jpg'});
                        $(this).parent().parent().find('.neki-okvir').css({'clip': 'rect(0px,360px,315px,0px)', '-webkit-transition-duration':0.3+'s', 'transition-duration':0.3+'s'});
                    },
                    function(img){
                        $(this).css({'clip':'rect(44px,180px,234px,0px)', 'background-image': img});
                        $(this).parent().parent().find('.sh').css({'clip': 'rect(0px,40px,40px,0px)', 'background-image': 'img/arrow-orange.jpg'});
                        $(this).parent().parent().find('.neki-okvir').css({'clip': 'rect(44px,360px,234px,0px)', '-webkit-transition-duration':0.8+'s', 'transition-duration':0.8+'s'});
                    }
                );
            });
        }
    }

    $('.shopic').hover(function(){
        var el = $(this).parent().find('.second').eq(0);
        $('.mega-sat').attr('src',el.attr('data-large'));
        $('.druga').text(el.attr('data-title'));
        $('.treca').text('');
    }, function(){

    });

});



$('#movado-div').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.luminox-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
         $('.tgheuer').fadeOut();

        $('.movado-div').fadeIn();
    });



    $('#victorinox-div').click(function () {
        $('.gaga-milano-div').fadeOut();
        $('.luminox-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.movado-div').fadeOut();

        $('.victorinox-div').fadeIn();
    });




    $('#tgheuer').click(function () {
         $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.luminox-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.movado-div').fadeOut();

        $('.tgheuer').fadeIn();
    });

    $('#gaga-milano-div').click(function () {
         $('.victorinox-div').fadeOut();
        $('.luminox-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.movado-div').fadeOut();

        $('.gaga-milano-div').fadeIn();
    });

    $('#luminox-div').click(function () {
         $('.victorinox-div').fadeOut();
         $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.movado-div').fadeOut();

       $('.luminox-div').fadeIn();
    });

    $('#nixon-div').click(function () {
         $('.victorinox-div').fadeOut();
         $('.gaga-milano-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();

       $('.nixon-div').fadeIn();
    });

    $('#sevenFriday').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();

       $('.sevenFriday').fadeIn();
    });

    $('#mondain-div').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();

       $('.mondain-div').fadeIn();
    });

    $('#perelet-div').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();

       $('.perelet-div').fadeIn();
    });

    $('#caran-div').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();

       $('.caran-div').fadeIn();
    });

    $('#bogner').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();

       $('.bogner').fadeIn();
    });

    $('#victorinox-travel').click(function () {
         $('.victorinox-div').fadeOut();
         $('.gaga-milano-div').fadeOut();
         $('.nixon-div').fadeOut();
         $('.sevenFriday').fadeOut();
         $('.mondain-div').fadeOut();
         $('.perelet-div').fadeOut();
         $('.caran-div').fadeOut();
         $('.bogner').fadeOut();
         $('.staub').fadeOut();
         $('.zwilling').fadeOut();
         $('.epicurean').fadeOut();
         $('.tgheuer').fadeOut();
         $('.luminox-div').fadeOut();
         $('.movado-div').fadeOut();

       $('.victorinox-travel').fadeIn();
    });

    $('#staub').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.zwilling').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();
       

       $('.staub').fadeIn();
    });

    $('#zwilling').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.epicurean').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();        

       $('.zwilling').fadeIn();
    });

    $('#epicurean').click(function () {
        $('.victorinox-div').fadeOut();
        $('.gaga-milano-div').fadeOut();
        $('.nixon-div').fadeOut();
        $('.sevenFriday').fadeOut();
        $('.mondain-div').fadeOut();
        $('.perelet-div').fadeOut();
        $('.caran-div').fadeOut();
        $('.bogner').fadeOut();
        $('.victorinox-travel').fadeOut();
        $('.staub').fadeOut();
        $('.zwilling').fadeOut();
        $('.tgheuer').fadeOut();
        $('.luminox-div').fadeOut();
        $('.movado-div').fadeOut();
       
        
         

       $('.epicurean').fadeIn();
    });


    $('.choose').click(function () {
        $('.prodajnaCro').slideToggle();
    });


 $('.prodajnaCro').find('li').each(function (){
    var el = $(this);
  
    el.click(function () {
          var ele = $('.prodajnaCro').find('.active');
        ele.removeClass('active');
        $(this).addClass('active');
    });
 });


$('.more').find('img').each(function() {
        var el = $(this);
        var div = $(this).parent();
        el.hover(function(){
          div.css({'color': '#f3ac3f'});
        }, function(){
          div.css({'color': '#7B7D7D'});
        });
    });

$('.more').hover(function(){
          $(this).css({'color': '#f3ac3f'});
        }, function(){
            $(this).css({'color': '#7B7D7D'});
        });
  


 $('.more-more').find('img').each(function() {
          var ele = $(this);
          var divv = $('more-posts');
          ele.hover(function(){
            divv.css({'color': '#f3ac3f'});
          }, function(){
            divv.css({'color': '#7B7D7D'});
          });
      });

 $('.more-more').hover(function (){

 $('.more-posts').css({'color': '#f4ac40'});
}, function(){
$('.more-posts').css({'color': '#7B7D7D'});
});


$('.slider-box .caption').each(function () {
 var el = $(this);
 var naslov = el.find('h2');
 var strelica = el.find('.caption-arrow');
 el.hover(function(){
 strelica.css({'background-image': 'url(../img/caption-arrow-hover.png)'});
 el.css({'background': 'rgba(38, 39, 43, 1)'});
 naslov.css({'color': '#7b7d7b'});
}, function(){
 strelica.css({'background-image': 'url(../img/caption-arrow.png)'});
el.css({'background': 'rgba(38, 39, 43, 0.7)'});
naslov.css({'color': '#fff'});
});

if($(window).width < 600) {
el.css({'background': 'rgba(38, 39, 43, 0)'});
}
});


$('.slider-box .caption-left').each(function () {
 var el = $(this);
 var strelica = el.find('.caption-arrow');
 var naslov = el.find('h2');
 el.hover(function(){
 strelica.css({'background-image': 'url(../img/caption-arrow-hover.png)'});
 el.css({'background': 'rgba(38, 39, 43, 1)'});
naslov.css({'color': '#7b7d7b'});
 
}, function(){
 strelica.css({'background-image': 'url(../img/caption-arrow.png)'});
el.css({'background': 'rgba(38, 39, 43, 0.7)'});
naslov.css({'color': '#fff'});
});
if($(window).width < 600) {
el.css({'background': 'rgba(38, 39, 43, 0)'});
}
});





$('.shop-bar-flex').find('.img-holder').find('a').find('img').each(function() {
        var el = $(this);
        el.hover(function(){
            $(this).addClass('transition2');
          
        }, function(){
            $(this).removeClass('transition2');
          
        });
    });

$('.category-products-3').find('.img-zoom').each(function () {
  var el = $(this);
 el.hover(function() {
  el.addClass('transition2');
}, function(){
  el.removeClass('transition2');
});

});
