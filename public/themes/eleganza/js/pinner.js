const pinner = (function() {
    // Pin radius.
    const R = 16;
    let $pinner;
    let state;

    /**
     * Sets everything up.
     *
     * @param {Array} initialState - Initial pins to render.
     * @param {Function} onAdd - Called when pin is created.
     */
    function init(initialState=[], onAdd=function() {}) {
        _onAdd = onAdd;
        $pinner = document.querySelector('.js-pinner');
        $pinner.addEventListener('click', _handleClick);
        // Pass the initial state.
        _setState({
            pins: initialState,
        });
    }

    /**
     * Adds new pin to the state.
     * @public
     *
     * @param {Object} coords - Coordinates of the pin.
     * @property {Number} coords.x - X coordinate.
     * @property {Number} coords.y - Y coordinate.
     */
    function addPin(coords) {
        _setState({
            pins: state.pins.concat(coords),
        });
        _onAdd(coords);
    }

    /**
     * Removes the pin with the given index from the state.
     * @public
     *
     * @param {Number} index - Index to remove pin from.
     */
    function removePin(index) {
        _setState({
            pins: state.pins.slice(0, index).concat(state.pins.slice(index + 1)),
        });
    }

    /**
     * Handles click events.
     * @private
     *
     * @param {Event} evt - Event object.
     */
    function _handleClick(evt) {
        const {offsetX, offsetY} = evt;
        const {width, height} = $pinner.getBoundingClientRect();
        // Coordinates in percentage.
        const coords = {
            x: ((offsetX - R) * 100) / width,
            y: ((offsetY - R) * 100) / height,
        };

        addPin(coords);
    }

    /**
     * Creates a new pin element.
     * @private
     *
     * @param {Object} coords - Coordinates of the pin.
     * @property {Number} coords.x - X coordinate.
     * @property {Number} coords.y - Y coordinate.
     * @param {Number} i - Index of the point in the pins collection.
     * @return {HTMLElement} - The pin element.
     */
    function _createPin(coords, i) {
        const pin = document.createElement('span');
        pin.className = 'pin';
        pin.innerText = i;
        pin.style.left = `${coords.x}%`;
        pin.style.top = `${coords.y}%`;
        return pin;
    }

    /**
     * Renders all the pinns.
     * @private
     */
    function _render() {
        // Clear the container.
        $pinner.innerHTML = '';
        const fragment = document.createDocumentFragment();

        state.pins.forEach((coords, i) => {
            const pin = _createPin(coords, i);
            fragment.appendChild(pin);
        });

        $pinner.appendChild(fragment);
    }

    /**
     * Updates the state and re-renders the view.
     * @private
     *
     * @param {Object} obj - State update.
     */
    function _setState(obj) {
        state = Object.assign({}, state, obj);
        _render();
    }

    return {
        init,
        addPin,
        removePin,
    };
}());