const options = {
  responsiveClass: true,
  nav: false,
  navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
  responsive: {
    0: {
      items: 2
    },
    768: {
      items: 3
    },
    992: {
      items: 4,
      nav: true
    }
  }
};

$(document).ready(function(){
  const $carousels = $('.owl-carousel[data-is-carousel="true"]');

  if ($carousels.length < 1) return;

  $carousels.each((i, courusel) => {
    $(courusel).owlCarousel(options);
  });
});