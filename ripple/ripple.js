/**
 * This is the only function that provides a ripple effect (hover or click)
 * on elements with classes 'ripple-hover' and 'ripple-click'.
 * The function is self-invoked. To make it work include this
 * file in the page's HTML content directly.
 * You can also import it into your other script file
 * like this const ripple = require('path to this file').
 *
 * Script require also CSS styles to be included into page,
 * othwerwise you will not see effects.
 *
 * @author Outcomer <773021792e@gmail.com>
 *
 * @return void
 */
const rippleFn = (() => {
	/**
	 * @param {WeakMap}
	 */
	const elementDataMap = new WeakMap()

	/**
	 * Save anything regarding to element into element itself.
	 *
	 * @param {Element} element HTML element.
	 * @param {Object}  data    Data to save.
	 */
	const setElementData = (element, data) => {
		elementDataMap.set(element, data)
	}

	/**
	 * Get saved data from an element.
	 *
	 * @param {Element} element HTML element.
	 *
	 * @return {Object} Saved data or an empty object.
	 */
	const getElementData = (element) => {
		if ('undefined' === typeof elementDataMap.get(element, 'data')) {
			setElementData(element, {})
		}

		return elementDataMap.get(element, 'data')
	}

	/**
	 * Bases on event coordinates and target size
	 * function calculates size of circle and it's
	 * position so that this circle cover target.
	 *
	 * @param {MouseEvent} event  Browser event.
	 * @param {Element}    target HTML element.
	 *
	 * @return {Object} A set of calculated coordinates for ripple.
	 */
	const prepareRipple = function (event, target) {
		// Get width and height that will 100% cover target on ripple.
		const client = target.getBoundingClientRect(),
			x = event.clientX,
			y = event.clientY,
			toLeft = x - client.left,
			toRight = client.right - x,
			toTop = y - client.top,
			toBottom = client.bottom - y,
			maxX = Math.max(toLeft, toRight),
			maxY = Math.max(toTop, toBottom),
			deltaRadius = Math.hypot(maxX, maxY) - Math.max(maxX, maxY)

		const buttonWidth = (Math.max(maxX, maxY) + deltaRadius) * 2
		const buttonHeight = buttonWidth

		return {
			height: buttonHeight,
			width: buttonWidth,
			left: event.pageX - target.getBoundingClientRect().left - buttonWidth / 2,
			top:
				event.pageY -
				(target.getBoundingClientRect().top +
					document.documentElement.scrollTop) -
				buttonHeight / 2,
		}
	}

	/**
	 * Ripple runner.
	 * Inject ripple element into DOM and apply
	 * CSS styles and classes needed for animation.
	 *
	 * @param {MouseEvent} event  Browser event.
	 * @param {Element}    target HTML element.
	 *
	 * @return {Promise} Promise will be resolved once animation finished.
	 */
	const doRippleClick = async function (event, target) {
		setElementData(target, { licketySplitDoRipleClick: true })
		const ripples = target.querySelector('.ripple')

		if (ripples !== null) {
			ripples.remove()
		}

		const ripple = document.createElement('span')
		const rippleData = prepareRipple(event, target)

		ripple.classList.add('ripple', 'ripple-effect-click')
		ripple.style.height = `${rippleData.height}px`
		ripple.style.width = `${rippleData.width}px`
		ripple.style.left = `${rippleData.left}px`
		ripple.style.top = `${rippleData.top}px`

		target.appendChild(ripple)

		// eslint-disable-next-line no-unused-vars
		return await new Promise((resolve, reject) => {
			const transition = window.getComputedStyle(ripple).transitionDuration
			const delay =
				Math.max.apply(Math, transition.split(',').map(parseFloat)) * 1000

			setTimeout(
				function (timerTarget) {
					setElementData(target, { licketySplitDoRipleClick: false })
					ripple.remove()
					resolve([event, timerTarget])
				},
				delay,
				target,
				ripple
			)
		})
	}

	/**
	 * Callback for hover IN event.
	 * Inject ripple element into DOM and apply
	 * CSS styles and classes needed for animation.
	 *
	 * @param {MouseEvent} event Browser event.
	 *
	 * @return {Promise} Promise resolved immediately.
	 */
	const doRippleHoverIn = async function (event) {
		const target = event.target.closest('.ripple-hover')
		const relatedTarget = event.relatedTarget
			? event.relatedTarget.closest('.ripple-hover')
			: null

		if (!target || target === relatedTarget) {
			return
		}

		clearTimeout(getElementData(target).rippleHoverOutTimer)

		let ripple = document.createElement('span')
		const rippleData = prepareRipple(event, target)
		const currentRipple = target.querySelector('.ripple')

		ripple.classList.add('ripple', 'ripple-effect-hover-in')
		ripple.style.height = `${rippleData.height}px`
		ripple.style.width = `${rippleData.width}px`
		ripple.style.left = `${rippleData.left}px`
		ripple.style.top = `${rippleData.top}px`

		if (currentRipple === null) {
			target.appendChild(ripple)
		} else {
			currentRipple.style.height = `${rippleData.height}px`
			currentRipple.style.width = `${rippleData.width}px`
			currentRipple.style.left = `${rippleData.left}px`
			currentRipple.style.top = `${rippleData.top}px`
			currentRipple.classList.remove('ripple-effect-hover-out')
			currentRipple.classList.add('ripple-effect-hover-in')

			ripple = currentRipple
		}

		return Promise.resolve([event, target])
	}

	/**
	 * Callback for hover OUT event.
	 * Inject ripple element into DOM and apply
	 * CSS styles and classes needed for animation.
	 *
	 * @param {MouseEvent} event Browser event.
	 *
	 * @return {Promise} Promise will be resolved once animation finished.
	 */
	const doRippleHoverOut = async function (event) {
		const target = event.target.closest('.ripple-hover')
		const relatedTarget = event.relatedTarget
			? event.relatedTarget.closest('.ripple-hover')
			: null

		if (!target || target === relatedTarget) {
			return
		}

		let ripple = document.createElement('span')
		const rippleData = prepareRipple(event, target)
		const currentRipple = target.querySelector('.ripple')

		ripple.classList.add('ripple', 'ripple-effect-hover-out')
		ripple.style.height = `${rippleData.height}px`
		ripple.style.width = `${rippleData.width}px`
		ripple.style.left = `${rippleData.left}px`
		ripple.style.top = `${rippleData.top}px`

		if (currentRipple === null) {
			target.appendChild(ripple)
		} else {
			currentRipple.style.height = `${rippleData.height}px`
			currentRipple.style.width = `${rippleData.width}px`
			currentRipple.style.left = `${rippleData.left}px`
			currentRipple.style.top = `${rippleData.top}px`
			currentRipple.classList.remove('ripple-effect-hover-in')
			currentRipple.classList.add('ripple-effect-hover-out')

			ripple = currentRipple
		}

		// eslint-disable-next-line no-unused-vars
		return await new Promise((resolve, reject) => {
			const transition = window.getComputedStyle(ripple).transitionDuration
			const delay =
				Math.max.apply(Math, transition.split(',').map(parseFloat)) * 1000

			const rippleHoverOutTimer = setTimeout(
				function (timerTarget) {
					ripple.remove()
					resolve([event, timerTarget])
				},
				delay,
				target,
				ripple
			)

			setElementData(target, { rippleHoverOutTimer })
		})
	}

	/**
	 * Callback for click event.
	 * Validates that no ripple currently in progress
	 * and if no - run new.
	 *
	 * @param {MouseEvent} event Browser event.
	 */
	const rippleClick = function (event) {
		if (!event.target.closest('.ripple-click')) {
			return
		}

		if (getElementData(event.target).licketySplitDoRipleClick) {
			return
		}

		doRippleClick(event, event.target).then(function (args) {
			const eventNew = new Event('licketySplitClickRipleDone')
			args[1].dispatchEvent(eventNew)
		})
	}

	document.querySelector('body').addEventListener('click', rippleClick)

	if ('ontouchstart' in window === false) {
		document
			.querySelector('body')
			.addEventListener('mouseover', doRippleHoverIn)
		document
			.querySelector('body')
			.addEventListener('mouseout', doRippleHoverOut)
	}
})()
