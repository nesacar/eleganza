/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 202);
/******/ })
/************************************************************************/
/******/ ({

/***/ 143:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__instashop_index_js__ = __webpack_require__(206);


(function () {
  __WEBPACK_IMPORTED_MODULE_0__instashop_index_js__["a" /* default */].init();
})();

/***/ }),

/***/ 202:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(143);


/***/ }),

/***/ 206:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_siema__ = __webpack_require__(207);


function init() {
  var slider = new __WEBPACK_IMPORTED_MODULE_0__components_siema__["a" /* default */]({
    perPage: 3
  });
  slider.addPagination();
}

/* harmony default export */ __webpack_exports__["a"] = ({
  init: init
});

/***/ }),

/***/ 207:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Hi :-) This is a class representing a Siema.
 */
var Siema = function () {
  /**
   * Create a Siema.
   * @param {Object} options - Optional settings object.
   */
  function Siema(options) {
    var _this = this;

    _classCallCheck(this, Siema);

    // Merge defaults with user's settings
    this.config = Siema.mergeSettings(options);

    // Resolve selector's type
    this.selector = typeof this.config.selector === 'string' ? document.querySelector(this.config.selector) : this.config.selector;

    // Early throw if selector doesn't exists
    if (this.selector === null) {
      throw new Error('Something wrong with your selector 😭');
    }

    // update perPage number dependable of user value
    this.resolveSlidesNumber();

    // Create global references
    this.selectorWidth = this.selector.offsetWidth;
    this.innerElements = [].slice.call(this.selector.children);
    this.currentSlide = this.config.loop ? this.config.startIndex % this.innerElements.length : Math.max(0, Math.min(this.config.startIndex, this.innerElements.length - this.perPage));
    this.transformProperty = Siema.webkitOrNot();

    // Bind all event handlers for referencability
    ['resizeHandler', 'touchstartHandler', 'touchendHandler', 'touchmoveHandler'].forEach(function (method) {
      _this[method] = _this[method].bind(_this);
    });

    // Build markup and apply required styling to elements
    this.init();
  }

  /**
   * Overrides default settings with custom ones.
   * @param {Object} options - Optional settings object.
   * @returns {Object} - Custom Siema settings.
   */


  _createClass(Siema, [{
    key: 'attachEvents',


    /**
     * Attaches listeners to required events.
     */
    value: function attachEvents() {
      // Resize element on window resize
      window.addEventListener('resize', this.resizeHandler);

      // If element is draggable / swipable, add event handlers
      if (this.config.draggable) {
        // Keep track pointer hold and dragging distance
        this.pointerDown = false;
        this.drag = {
          startX: 0,
          endX: 0,
          startY: 0,
          letItGo: null,
          preventClick: false
        };

        // Touch events
        this.selector.addEventListener('touchstart', this.touchstartHandler);
        this.selector.addEventListener('touchend', this.touchendHandler);
        this.selector.addEventListener('touchmove', this.touchmoveHandler);
      }
    }

    /**
     * Detaches listeners from required events.
     */

  }, {
    key: 'detachEvents',
    value: function detachEvents() {
      window.removeEventListener('resize', this.resizeHandler);
      this.selector.removeEventListener('touchstart', this.touchstartHandler);
      this.selector.removeEventListener('touchend', this.touchendHandler);
      this.selector.removeEventListener('touchmove', this.touchmoveHandler);
    }

    /**
     * Builds the markup and attaches listeners to required events.
     */

  }, {
    key: 'init',
    value: function init() {
      this.attachEvents();

      // hide everything out of selector's boundaries
      this.selector.style.overflow = 'hidden';

      // rtl or ltr
      this.selector.style.direction = this.config.rtl ? 'rtl' : 'ltr';

      // build a frame and slide to a currentSlide
      this.buildSliderFrame();

      this.config.onInit.call(this);
    }

    /**
     * Build a sliderFrame and slide to a current item.
     */

  }, {
    key: 'buildSliderFrame',
    value: function buildSliderFrame() {
      var widthItem = this.selectorWidth / this.perPage;
      var itemsToBuild = this.config.loop ? this.innerElements.length + 2 * this.perPage : this.innerElements.length;

      // Create frame and apply styling
      this.sliderFrame = document.createElement('div');
      this.sliderFrame.style.width = widthItem * itemsToBuild + 'px';
      this.enableTransition();

      if (this.config.draggable) {
        this.selector.style.cursor = '-webkit-grab';
      }

      // Create a document fragment to put slides into it
      var docFragment = document.createDocumentFragment();

      // Loop through the slides, add styling and add them to document fragment
      if (this.config.loop) {
        for (var i = this.innerElements.length - this.perPage; i < this.innerElements.length; i++) {
          var element = this.buildSliderFrameItem(this.innerElements[i].cloneNode(true));
          docFragment.appendChild(element);
        }
      }
      for (var _i = 0; _i < this.innerElements.length; _i++) {
        var _element = this.buildSliderFrameItem(this.innerElements[_i]);
        docFragment.appendChild(_element);
      }
      if (this.config.loop) {
        for (var _i2 = 0; _i2 < this.perPage; _i2++) {
          var _element2 = this.buildSliderFrameItem(this.innerElements[_i2].cloneNode(true));
          docFragment.appendChild(_element2);
        }
      }

      // Add fragment to the frame
      this.sliderFrame.appendChild(docFragment);

      // Clear selector (just in case something is there) and insert a frame
      this.selector.innerHTML = '';
      this.selector.appendChild(this.sliderFrame);

      // Go to currently active slide after initial build
      this.slideToCurrent();
    }
  }, {
    key: 'buildSliderFrameItem',
    value: function buildSliderFrameItem(elm) {
      var elementContainer = document.createElement('div');
      elementContainer.style.cssFloat = this.config.rtl ? 'right' : 'left';
      elementContainer.style.float = this.config.rtl ? 'right' : 'left';
      elementContainer.style.width = (this.config.loop ? 100 / (this.innerElements.length + this.perPage * 2) : 100 / this.innerElements.length) + '%';
      elementContainer.appendChild(elm);
      return elementContainer;
    }

    /**
     * Determinates slides number accordingly to clients viewport.
     */

  }, {
    key: 'resolveSlidesNumber',
    value: function resolveSlidesNumber() {
      if (typeof this.config.perPage === 'number') {
        this.perPage = this.config.perPage;
      } else if (_typeof(this.config.perPage) === 'object') {
        this.perPage = 1;
        for (var viewport in this.config.perPage) {
          if (window.innerWidth >= viewport) {
            this.perPage = this.config.perPage[viewport];
          }
        }
      }
    }

    /**
     * Go to previous slide.
     * @param {number} [howManySlides=1] - How many items to slide backward.
     * @param {function} callback - Optional callback function.
     */

  }, {
    key: 'prev',
    value: function prev() {
      var howManySlides = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      var callback = arguments[1];

      // early return when there is nothing to slide
      if (this.innerElements.length <= this.perPage) {
        return;
      }

      var beforeChange = this.currentSlide;

      if (this.config.loop) {
        var isNewIndexClone = this.currentSlide - howManySlides < 0;
        if (isNewIndexClone) {
          this.disableTransition();

          var mirrorSlideIndex = this.currentSlide + this.innerElements.length;
          var mirrorSlideIndexOffset = this.perPage;
          var moveTo = mirrorSlideIndex + mirrorSlideIndexOffset;
          var offset = (this.config.rtl ? 1 : -1) * moveTo * (this.selectorWidth / this.perPage);
          var dragDistance = this.config.draggable ? this.drag.endX - this.drag.startX : 0;

          this.sliderFrame.style[this.transformProperty] = 'translate3d(' + (offset + dragDistance) + 'px, 0, 0)';
          this.currentSlide = mirrorSlideIndex - howManySlides;
        } else {
          this.currentSlide = this.currentSlide - howManySlides;
        }
      } else {
        this.currentSlide = Math.max(this.currentSlide - howManySlides, 0);
      }

      if (beforeChange !== this.currentSlide) {
        this.slideToCurrent(this.config.loop);
        this.config.onChange.call(this);
        if (callback) {
          callback.call(this);
        }
      }
    }

    /**
     * Go to next slide.
     * @param {number} [howManySlides=1] - How many items to slide forward.
     * @param {function} callback - Optional callback function.
     */

  }, {
    key: 'next',
    value: function next() {
      var howManySlides = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      var callback = arguments[1];

      // early return when there is nothing to slide
      if (this.innerElements.length <= this.perPage) {
        return;
      }

      var beforeChange = this.currentSlide;

      if (this.config.loop) {
        var isNewIndexClone = this.currentSlide + howManySlides > this.innerElements.length - this.perPage;
        if (isNewIndexClone) {
          this.disableTransition();

          var mirrorSlideIndex = this.currentSlide - this.innerElements.length;
          var mirrorSlideIndexOffset = this.perPage;
          var moveTo = mirrorSlideIndex + mirrorSlideIndexOffset;
          var offset = (this.config.rtl ? 1 : -1) * moveTo * (this.selectorWidth / this.perPage);
          var dragDistance = this.config.draggable ? this.drag.endX - this.drag.startX : 0;

          this.sliderFrame.style[this.transformProperty] = 'translate3d(' + (offset + dragDistance) + 'px, 0, 0)';
          this.currentSlide = mirrorSlideIndex + howManySlides;
        } else {
          this.currentSlide = this.currentSlide + howManySlides;
        }
      } else {
        this.currentSlide = Math.min(this.currentSlide + howManySlides, this.innerElements.length - this.perPage);
      }
      if (beforeChange !== this.currentSlide) {
        this.slideToCurrent(this.config.loop);
        this.config.onChange.call(this);
        if (callback) {
          callback.call(this);
        }
      }
    }

    /**
     * Disable transition on sliderFrame.
     */

  }, {
    key: 'disableTransition',
    value: function disableTransition() {
      this.sliderFrame.style.webkitTransition = 'all 0ms ' + this.config.easing;
      this.sliderFrame.style.transition = 'all 0ms ' + this.config.easing;
    }

    /**
     * Enable transition on sliderFrame.
     */

  }, {
    key: 'enableTransition',
    value: function enableTransition() {
      this.sliderFrame.style.webkitTransition = 'all ' + this.config.duration + 'ms ' + this.config.easing;
      this.sliderFrame.style.transition = 'all ' + this.config.duration + 'ms ' + this.config.easing;
    }

    /**
     * Go to slide with particular index
     * @param {number} index - Item index to slide to.
     * @param {function} callback - Optional callback function.
     */

  }, {
    key: 'goTo',
    value: function goTo(index, callback) {
      if (this.innerElements.length <= this.perPage) {
        return;
      }
      var beforeChange = this.currentSlide;
      this.currentSlide = this.config.loop ? index % this.innerElements.length : Math.min(Math.max(index, 0), this.innerElements.length - this.perPage);
      if (beforeChange !== this.currentSlide) {
        this.slideToCurrent();
        this.config.onChange.call(this);
        if (callback) {
          callback.call(this);
        }
      }
    }

    /**
     * Moves sliders frame to position of currently active slide
     */

  }, {
    key: 'slideToCurrent',
    value: function slideToCurrent(enableTransition) {
      var _this2 = this;

      var currentSlide = this.config.loop ? this.currentSlide + this.perPage : this.currentSlide;
      var offset = (this.config.rtl ? 1 : -1) * currentSlide * (this.selectorWidth / this.perPage);

      if (enableTransition) {
        // This one is tricky, I know but this is a perfect explanation:
        // https://youtu.be/cCOL7MC4Pl0
        requestAnimationFrame(function () {
          requestAnimationFrame(function () {
            _this2.enableTransition();
            _this2.sliderFrame.style[_this2.transformProperty] = 'translate3d(' + offset + 'px, 0, 0)';
          });
        });
      } else {
        this.sliderFrame.style[this.transformProperty] = 'translate3d(' + offset + 'px, 0, 0)';
      }

      this._setActiveSlide();
    }

    /**
     * Recalculate drag /swipe event and reposition the frame of a slider
     */

  }, {
    key: 'updateAfterDrag',
    value: function updateAfterDrag() {
      var movement = (this.config.rtl ? -1 : 1) * (this.drag.endX - this.drag.startX);
      var movementDistance = Math.abs(movement);
      var howManySliderToSlide = this.config.multipleDrag ? Math.ceil(movementDistance / (this.selectorWidth / this.perPage)) : 1;

      var slideToNegativeClone = movement > 0 && this.currentSlide - howManySliderToSlide < 0;
      var slideToPositiveClone = movement < 0 && this.currentSlide + howManySliderToSlide > this.innerElements.length - this.perPage;

      if (movement > 0 && movementDistance > this.config.threshold && this.innerElements.length > this.perPage) {
        this.prev(howManySliderToSlide);
      } else if (movement < 0 && movementDistance > this.config.threshold && this.innerElements.length > this.perPage) {
        this.next(howManySliderToSlide);
      }
      this.slideToCurrent(slideToNegativeClone || slideToPositiveClone);
    }

    /**
     * When window resizes, resize slider components as well
     */

  }, {
    key: 'resizeHandler',
    value: function resizeHandler() {
      var _this3 = this;

      // Update after the resize 
      clearTimeout(this._resizeTimer);
      this._resizeTimer = setTimeout(function () {
        // update perPage number dependable of user value
        _this3.resolveSlidesNumber();

        // relcalculate currentSlide
        // prevent hiding items when browser width increases
        if (_this3.currentSlide + _this3.perPage > _this3.innerElements.length) {
          _this3.currentSlide = _this3.innerElements.length <= _this3.perPage ? 0 : _this3.innerElements.length - _this3.perPage;
        }

        _this3.selectorWidth = _this3.selector.offsetWidth;

        _this3.buildSliderFrame();
      }, 250);
    }

    /**
     * Clear drag after touchend and mouseup event
     */

  }, {
    key: 'clearDrag',
    value: function clearDrag() {
      this.drag = {
        startX: 0,
        endX: 0,
        startY: 0,
        letItGo: null,
        preventClick: this.drag.preventClick
      };
    }

    /**
     * touchstart event handler
     */

  }, {
    key: 'touchstartHandler',
    value: function touchstartHandler(e) {
      // Prevent dragging / swiping on inputs, selects and textareas
      var ignoreSiema = ['TEXTAREA', 'OPTION', 'INPUT', 'SELECT'].indexOf(e.target.nodeName) !== -1;
      if (ignoreSiema) {
        return;
      }

      e.stopPropagation();
      this.pointerDown = true;
      this.drag.startX = e.touches[0].pageX;
      this.drag.startY = e.touches[0].pageY;
    }

    /**
     * touchend event handler
     */

  }, {
    key: 'touchendHandler',
    value: function touchendHandler(e) {
      e.stopPropagation();
      this.pointerDown = false;
      this.enableTransition();
      if (this.drag.endX) {
        this.updateAfterDrag();
      }
      this.clearDrag();
    }

    /**
     * touchmove event handler
     */

  }, {
    key: 'touchmoveHandler',
    value: function touchmoveHandler(e) {
      e.stopPropagation();

      if (this.drag.letItGo === null) {
        this.drag.letItGo = Math.abs(this.drag.startY - e.touches[0].pageY) < Math.abs(this.drag.startX - e.touches[0].pageX);
      }

      if (this.pointerDown && this.drag.letItGo) {
        e.preventDefault();
        this.drag.endX = e.touches[0].pageX;
        this.sliderFrame.style.webkitTransition = 'all 0ms ' + this.config.easing;
        this.sliderFrame.style.transition = 'all 0ms ' + this.config.easing;

        var currentSlide = this.config.loop ? this.currentSlide + this.perPage : this.currentSlide;
        var currentOffset = currentSlide * (this.selectorWidth / this.perPage);
        var dragOffset = this.drag.endX - this.drag.startX;
        var offset = this.config.rtl ? currentOffset + dragOffset : currentOffset - dragOffset;
        this.sliderFrame.style[this.transformProperty] = 'translate3d(' + (this.config.rtl ? 1 : -1) * offset + 'px, 0, 0)';
      }
    }

    /**
     * Remove item from carousel.
     * @param {number} index - Item index to remove.
     * @param {function} callback - Optional callback to call after remove.
     */

  }, {
    key: 'remove',
    value: function remove(index, callback) {
      if (index < 0 || index >= this.innerElements.length) {
        throw new Error('Item to remove doesn\'t exist 😭');
      }

      // Shift sliderFrame back by one item when:
      // 1. Item with lower index than currenSlide is removed.
      // 2. Last item is removed.
      var lowerIndex = index < this.currentSlide;
      var lastItem = this.currentSlide + this.perPage - 1 === index;

      if (lowerIndex || lastItem) {
        this.currentSlide--;
      }

      this.innerElements.splice(index, 1);

      // build a frame and slide to a currentSlide
      this.buildSliderFrame();

      if (callback) {
        callback.call(this);
      }
    }

    /**
     * Insert item to carousel at particular index.
     * @param {HTMLElement} item - Item to insert.
     * @param {number} index - Index of new new item insertion.
     * @param {function} callback - Optional callback to call after insert.
     */

  }, {
    key: 'insert',
    value: function insert(item, index, callback) {
      if (index < 0 || index > this.innerElements.length + 1) {
        throw new Error('Unable to inset it at this index 😭');
      }
      if (this.innerElements.indexOf(item) !== -1) {
        throw new Error('The same item in a carousel? Really? Nope 😭');
      }

      // Avoid shifting content
      var shouldItShift = index <= this.currentSlide > 0 && this.innerElements.length;
      this.currentSlide = shouldItShift ? this.currentSlide + 1 : this.currentSlide;

      this.innerElements.splice(index, 0, item);

      // build a frame and slide to a currentSlide
      this.buildSliderFrame();

      if (callback) {
        callback.call(this);
      }
    }

    /**
     * Prepernd item to carousel.
     * @param {HTMLElement} item - Item to prepend.
     * @param {function} callback - Optional callback to call after prepend.
     */

  }, {
    key: 'prepend',
    value: function prepend(item, callback) {
      this.insert(item, 0);
      if (callback) {
        callback.call(this);
      }
    }

    /**
     * Append item to carousel.
     * @param {HTMLElement} item - Item to append.
     * @param {function} callback - Optional callback to call after append.
     */

  }, {
    key: 'append',
    value: function append(item, callback) {
      this.insert(item, this.innerElements.length + 1);
      if (callback) {
        callback.call(this);
      }
    }

    /**
     * Removes listeners and optionally restores to initial markup
     * @param {boolean} restoreMarkup - Determinants about restoring an initial markup.
     * @param {function} callback - Optional callback function.
     */

  }, {
    key: 'destroy',
    value: function destroy() {
      var restoreMarkup = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      var callback = arguments[1];

      this.detachEvents();

      this.selector.style.cursor = 'auto';

      if (restoreMarkup) {
        var slides = document.createDocumentFragment();
        for (var i = 0; i < this.innerElements.length; i++) {
          slides.appendChild(this.innerElements[i]);
        }
        this.selector.innerHTML = '';
        this.selector.appendChild(slides);
        this.selector.removeAttribute('style');
      }

      if (callback) {
        callback.call(this);
      }
    }
  }, {
    key: 'addPagination',
    value: function addPagination() {
      var _this4 = this;

      var n = Math.ceil(this.innerElements.length / this.perPage);
      var paggination = document.createElement('div');
      paggination.className = 'siema-pagination';

      var _loop = function _loop(i) {
        var bullet = document.createElement('button');
        bullet.className = 'siema-bullet';
        bullet.addEventListener('click', function () {
          return _this4.goTo(i * _this4.perPage);
        });
        paggination.appendChild(bullet);
      };

      for (var i = 0; i < n; i++) {
        _loop(i);
      }
      this.selector.parentNode.insertBefore(paggination, this.selector.nextSibling);

      this._setActiveSlide();
    }

    // apply 'active' class to currentSlide

  }, {
    key: '_setActiveSlide',
    value: function _setActiveSlide() {
      var bullets = document.querySelectorAll('.siema-bullet');
      var index = this.currentSlide;
      var bullet = Math.round(index / this.perPage);

      this.innerElements.forEach(function (el, i) {
        if (i === index) {
          el.classList.add('active');
        } else {
          if (el.classList.contains('active')) {
            el.classList.remove('active');
          }
        }
      });

      if (!bullets) {
        return;
      }

      Array.from(bullets).forEach(function (child, i) {
        if (i === bullet) {
          child.classList.add('active');
          return;
        }
        child.classList.remove('active');
      });
    }
  }], [{
    key: 'mergeSettings',
    value: function mergeSettings(options) {
      var settings = {
        selector: '.siema',
        duration: 200,
        easing: 'ease-out',
        perPage: 1,
        startIndex: 0,
        draggable: true,
        multipleDrag: true,
        threshold: 20,
        loop: false,
        rtl: false,
        onInit: function onInit() {},
        onChange: function onChange() {}
      };

      var userSttings = options;
      for (var attrname in userSttings) {
        settings[attrname] = userSttings[attrname];
      }

      return settings;
    }

    /**
     * Determine if browser supports unprefixed transform property.
     * Google Chrome since version 26 supports prefix-less transform
     * @returns {string} - Transform property supported by client.
     */

  }, {
    key: 'webkitOrNot',
    value: function webkitOrNot() {
      var style = document.documentElement.style;
      if (typeof style.transform === 'string') {
        return 'transform';
      }
      return 'WebkitTransform';
    }
  }]);

  return Siema;
}();

/* harmony default export */ __webpack_exports__["a"] = (Siema);

/***/ })

/******/ });