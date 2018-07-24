$(document).ready(function () {
  const $controls = $('[data-e-controls]');

  if ($controls.length < 1) return;

  $controls.each((i, control) => {
    const targetIdentifier = control.getAttribute('data-e-controls');
    const $target = $(targetIdentifier);

    control.addEventListener('click', evt => {
      toggleNoScrollElement($target);
    });
  });
});

$(document).ready(function () {
  const $overlays = $('[data-e-is-overlay]');

  if ($overlays.length < 1) return;

  $overlays.each((i, overlay) => {
    overlay.addEventListener('click', evt => {
      let $closest = $(evt.target).closest('[data-e-is-surface]');

      if ($closest.length) return;

      toggleNoScrollElement(overlay);
    });
  });
});

function toggleNoScrollElement (el) {
  let $el = (el instanceof jQuery) ? el : $(el);
  
  $el.toggleClass('active');

  if ($el.hasClass('active')) {
    document.body.classList.add('no-scroll');
  }
  else {
    document.body.classList.remove('no-scroll');
  }
}

// emitter helpers.
$(document).ready(function() {
  $emitters = document.querySelectorAll('.js-emitter');
  $emitters.forEach(($emitter) => {
    $emitter.addEventListener('click', () => {
      dispatch($emitter);
    });
  });
});

function dispatch(el) {
  const type = el.dataset.event;
  const evt = new CustomEvent(type, {bubbles: true, detail: el});
  el.dispatchEvent(evt);
}
