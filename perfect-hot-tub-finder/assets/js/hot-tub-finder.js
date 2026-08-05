(function () {
	'use strict';

	window.PHTF_PRODUCT_SOURCES = window.PHTF_PRODUCT_SOURCES || {};


	var PHTF_SPECIAL_ROOT_SELECTOR = [
		'[data-phtf-widget]',
		'[data-phtf-explore]',
		'[data-phtf-spa-colors]',
		'[data-phtf-delight]',
		'[data-phtf-reviews]',
		'[data-phtf-compare]',
		'.phtc-widget',
		'.phtf-spa-models',
		'.phtf-model-specs',
		'.phtf-specs'
	].join(',');

	function applySpecialCharSuperscripts(root) {
		var scope = root || document;
		var containers = [];

		if (scope.nodeType === 1 && scope.matches && scope.matches(PHTF_SPECIAL_ROOT_SELECTOR)) {
			containers.push(scope);
		}

		if (scope.querySelectorAll) {
			containers = containers.concat(Array.prototype.slice.call(scope.querySelectorAll(PHTF_SPECIAL_ROOT_SELECTOR)));
		}

		containers = containers.filter(function (container, index) {
			return container && containers.indexOf(container) === index;
		});

		containers.forEach(function (container) {
			var walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT, {
				acceptNode: function (node) {
					var value = node.nodeValue || '';
					var parent = node.parentNode;

					if (!/[®™℠]/.test(value) || !parent || parent.nodeType !== 1) {
						return NodeFilter.FILTER_REJECT;
					}

					if (parent.closest('.phtf-special-char, sup, script, style, textarea, input, select, option, svg, canvas')) {
						return NodeFilter.FILTER_REJECT;
					}

					return NodeFilter.FILTER_ACCEPT;
				}
			});
			var nodes = [];
			var node;

			while ((node = walker.nextNode())) {
				nodes.push(node);
			}

			nodes.forEach(function (textNode) {
				var text = textNode.nodeValue || '';
				var frag = document.createDocumentFragment();
				var lastIndex = 0;

				text.replace(/[®™℠]/g, function (match, offset) {
					if (offset > lastIndex) {
						frag.appendChild(document.createTextNode(text.slice(lastIndex, offset)));
					}

					var sup = document.createElement('sup');
					sup.className = 'phtf-special-char';
					sup.textContent = match;
					frag.appendChild(sup);
					lastIndex = offset + match.length;
					return match;
				});

				if (lastIndex < text.length) {
					frag.appendChild(document.createTextNode(text.slice(lastIndex)));
				}

				if (textNode.parentNode) {
					textNode.parentNode.replaceChild(frag, textNode);
				}
			});
		});
	}

	function escapeHtml(value) {
		return String(value == null ? '' : value)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#039;');
	}

	function collectProductSources() {
		Array.prototype.slice.call(document.querySelectorAll('script.phtf-product-source-json[data-phtf-product-source]')).forEach(function (script) {
			var source = script.getAttribute('data-phtf-product-source') || 'main';
			try {
				window.PHTF_PRODUCT_SOURCES[source] = JSON.parse(script.textContent || '[]');
			} catch (error) {
				window.PHTF_PRODUCT_SOURCES[source] = [];
			}
		});
	}

	function renderRating(rating) {
		var value = parseFloat(rating || 0);
		if (isNaN(value)) {
			value = 0;
		}
		value = Math.max(0, Math.min(5, value));
		var full = Math.floor(value);
		var half = value - full >= 0.5;
		var html = '<span class="screen-reader-text">' + escapeHtml(value + ' out of 5 stars') + '</span>';

		for (var i = 1; i <= 5; i += 1) {
			var className = 'phtf-star';
			if (i <= full) {
				className += ' is-full';
			} else if (half && i === full + 1) {
				className += ' is-half';
			}
			html += '<span class="' + className + '" aria-hidden="true">★</span>';
		}

		return html;
	}

	function makeSeriesLabel(product) {
		if (product.explore_series_label) {
			return product.explore_series_label;
		}
		if (product.series) {
			return String(product.series).replace(/\s*series\s*$/i, '');
		}
		return '';
	}

	function makeReviewsLabel(product) {
		if (!product.reviews) {
			return '';
		}
		var match = String(product.reviews).match(/\d+/);
		return match ? '(' + match[0] + ')' : product.reviews;
	}

	function makeSeatsLabel(product) {
		if (!product.seating) {
			return '';
		}
		var match = String(product.seating).match(/\d+(?:\s*-\s*\d+)?/);
		return match ? 'Seats ' + match[0].replace(/\s+/g, '') : product.seating;
	}

	function makeCategoryAttr(product) {
		var categories = [];
		if (product.seat) {
			categories.push(String(product.seat).trim());
		}
		if (product.explore_categories) {
			String(product.explore_categories).split(',').forEach(function (cat) {
				cat = cat.trim();
				if (cat) {
					categories.push(cat);
				}
			});
		}
		return categories.filter(function (cat, index) {
			return cat && categories.indexOf(cat) === index;
		}).join(',');
	}

	function renderExploreCard(product) {
		var seriesLabel = makeSeriesLabel(product);
		var reviewsLabel = makeReviewsLabel(product);
		var seatsLabel = makeSeatsLabel(product);
		var categories = makeCategoryAttr(product);
		var image = product.product_image || '';
		var brand = product.brand || '';

		return [
			'<article class="phtf-explore-card" data-phtf-explore-item data-phtf-explore-cats="' + escapeHtml(categories) + '">',
				'<div class="phtf-explore-image-wrap">',
					'<img class="phtf-explore-image" src="' + escapeHtml(image) + '" alt="' + escapeHtml(brand) + '">',
				'</div>',
				seriesLabel ? '<div class="phtf-explore-card-series">' + escapeHtml(seriesLabel) + '</div>' : '',
				'<h3 class="phtf-explore-card-title">' + escapeHtml(brand) + '</h3>',
				'<div class="phtf-explore-rating"><span class="phtf-stars">' + renderRating(product.rating) + '</span>' + (reviewsLabel ? '<span class="phtf-explore-reviews">' + escapeHtml(reviewsLabel) + '</span>' : '') + '</div>',
				'<div class="phtf-explore-meta">' + (seatsLabel ? '<span>' + escapeHtml(seatsLabel) + '</span>' : '') + (product.msrp ? '<span>MSRP: <strong>' + escapeHtml(product.msrp) + '</strong></span>' : '') + '</div>',
			'</article>'
		].join('');
	}

	function syncDynamicExplore(explore) {
		if (explore.getAttribute('data-phtf-explore-dynamic') !== 'true') {
			return true;
		}

		collectProductSources();

		var source = explore.getAttribute('data-phtf-explore-source') || 'main';
		var products = window.PHTF_PRODUCT_SOURCES[source] || [];
		var track = explore.querySelector('[data-phtf-explore-track]') || explore.querySelector('.phtf-explore-track');
		var empty = explore.querySelector('[data-phtf-explore-empty-message]');
		var prev = explore.querySelector('[data-phtf-explore-prev]');
		var next = explore.querySelector('[data-phtf-explore-next]');

		if (!track) {
			return false;
		}

		track.innerHTML = products.map(renderExploreCard).join('');
		applySpecialCharSuperscripts(track);

		if (!products.length) {
			if (empty) {
				empty.hidden = false;
			}
			if (prev) {
				prev.disabled = true;
			}
			if (next) {
				next.disabled = true;
			}
			return false;
		}

		if (empty) {
			empty.hidden = true;
		}

		return true;
	}

	function initExplore(root) {
		var explore = root && root.matches && root.matches('[data-phtf-explore]') ? root : (root ? root.querySelector('[data-phtf-explore]') : null);
		if (!explore) {
			return;
		}

		if (explore.getAttribute('data-phtf-explore-initialized') === 'true') {
			return;
		}

		if (!syncDynamicExplore(explore)) {
			return;
		}

		explore.setAttribute('data-phtf-explore-initialized', 'true');

		var items = Array.prototype.slice.call(explore.querySelectorAll('[data-phtf-explore-item]'));
		var tabs = Array.prototype.slice.call(explore.querySelectorAll('[data-phtf-explore-tab]'));
		var prev = explore.querySelector('[data-phtf-explore-prev]');
		var next = explore.querySelector('[data-phtf-explore-next]');
		var empty = explore.querySelector('[data-phtf-explore-empty-message]');
		var activeFilter = tabs.length ? (tabs[0].getAttribute('data-phtf-explore-tab') || 'all') : 'all';
		var startIndex = 0;
		var visibleItems = [];

		function getCssInteger(name, fallback) {
			var value = window.getComputedStyle(explore).getPropertyValue(name);
			var parsed = parseInt(value, 10);
			return !isNaN(parsed) && parsed > 0 ? parsed : fallback;
		}

		function getPerPage() {
			var fallback = 3;
			if (window.matchMedia('(max-width: 640px)').matches) {
				fallback = 1;
			} else if (window.matchMedia('(max-width: 980px)').matches) {
				fallback = 2;
			}
			return getCssInteger('--phtf-explore-per-page', fallback);
		}

		function itemMatches(item) {
			if (activeFilter === 'all') {
				return true;
			}

			var categories = (item.getAttribute('data-phtf-explore-cats') || '')
				.split(',')
				.map(function (cat) {
					return cat.trim();
				})
				.filter(Boolean);

			return categories.indexOf(activeFilter) !== -1;
		}

		function updateControls(perPage) {
			var disabled = visibleItems.length <= perPage;
			if (prev) {
				prev.disabled = disabled;
			}
			if (next) {
				next.disabled = disabled;
			}
		}

		function render() {
			var perPage = getPerPage();

			visibleItems = items.filter(itemMatches);

			if (startIndex < 0) {
				startIndex = Math.max(visibleItems.length - perPage, 0);
			}

			if (startIndex >= visibleItems.length) {
				startIndex = 0;
			}

			items.forEach(function (item) {
				item.hidden = true;
			});

			visibleItems.slice(startIndex, startIndex + perPage).forEach(function (item) {
				item.hidden = false;
			});

			if (empty) {
				empty.hidden = visibleItems.length > 0;
			}

			updateControls(perPage);
		}

		function flashExploreArrowState(button) {
			if (!button) {
				return;
			}
			button.classList.add('is-active');
			window.setTimeout(function () {
				button.classList.remove('is-active');
			}, 180);
		}

		function move(direction) {
			var perPage = getPerPage();

			if (visibleItems.length <= perPage) {
				return;
			}

			startIndex += direction * perPage;

			if (startIndex >= visibleItems.length) {
				startIndex = 0;
			}

			if (startIndex < 0) {
				startIndex = Math.max(visibleItems.length - perPage, 0);
			}

			render();
		}

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				tabs.forEach(function (otherTab) {
					otherTab.classList.remove('is-active');
				});

				tab.classList.add('is-active');
				activeFilter = tab.getAttribute('data-phtf-explore-tab') || 'all';
				startIndex = 0;
				render();
			});
		});

		if (prev) {
			prev.addEventListener('click', function () {
				flashExploreArrowState(prev);
				move(-1);
			});
		}

		if (next) {
			next.addEventListener('click', function () {
				flashExploreArrowState(next);
				move(1);
			});
		}

		window.addEventListener('resize', render);
		render();
	}

	function initFinder(widget) {
		collectProductSources();

		if (widget.getAttribute('data-phtf-initialized') === 'true') {
			initExplore(widget);
			document.dispatchEvent(new CustomEvent('phtfProductSourcesReady'));
			return;
		}
		widget.setAttribute('data-phtf-initialized', 'true');

		var products = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-item]'));
		var count = widget.querySelector('[data-phtf-count]');
		var empty = widget.querySelector('[data-phtf-empty]');
		var prevButtons = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-prev]'));
		var nextButtons = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-next]'));
		var filters = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-filter]'));
		var filterOpenButtons = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-filter-open]'));
		var filterCloseButtons = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-filter-close]'));
		var filterShowResultsButtons = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-filter-show-results]'));
		var filterResetButtons = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-filter-reset]'));
		var filterOverlay = widget.querySelector('[data-phtf-filter-overlay]');
		var filterDrawer = widget.querySelector('.phtf-filters');
		var filterGroupToggles = Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-filter-group-toggle]'));
		var currentIndex = 0;
		var visibleProducts = [];

		function isMobileFilters() {
			return window.matchMedia('(max-width: 1024px)').matches;
		}

		function setImportantStyle(element, property, value) {
			if (element && element.style) {
				element.style.setProperty(property, value, 'important');
			}
		}

		function clearDrawerViewportLock() {
			if (!filterDrawer || !filterDrawer.style) {
				return;
			}

			[
				'position',
				'z-index',
				'top',
				'right',
				'bottom',
				'left',
				'width',
				'max-width',
				'min-width',
				'height',
				'max-height',
				'margin',
				'border',
				'border-radius',
				'transform',
				'overflow-x',
				'overflow-y',
				'box-sizing'
			].forEach(function (property) {
				filterDrawer.style.removeProperty(property);
			});
		}

		function lockDrawerToViewport() {
			if (!filterDrawer) {
				return;
			}

			var viewportWidth = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
			var viewportHeight = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);
			var width = viewportWidth ? viewportWidth + 'px' : '100vw';
			var height = viewportHeight ? viewportHeight + 'px' : '100vh';

			setImportantStyle(filterDrawer, 'position', 'fixed');
			setImportantStyle(filterDrawer, 'z-index', '10001');
			setImportantStyle(filterDrawer, 'top', '0');
			setImportantStyle(filterDrawer, 'right', '0');
			setImportantStyle(filterDrawer, 'bottom', '0');
			setImportantStyle(filterDrawer, 'left', '0');
			setImportantStyle(filterDrawer, 'width', width);
			setImportantStyle(filterDrawer, 'max-width', width);
			setImportantStyle(filterDrawer, 'min-width', '0');
			setImportantStyle(filterDrawer, 'height', height);
			setImportantStyle(filterDrawer, 'max-height', height);
			setImportantStyle(filterDrawer, 'margin', '0');
			setImportantStyle(filterDrawer, 'border', '0');
			setImportantStyle(filterDrawer, 'border-radius', '0');
			setImportantStyle(filterDrawer, 'transform', 'translateX(0)');
			setImportantStyle(filterDrawer, 'overflow-x', 'hidden');
			setImportantStyle(filterDrawer, 'overflow-y', 'auto');
			setImportantStyle(filterDrawer, 'box-sizing', 'border-box');
		}

		function setFilterDrawerState(isOpen) {
			widget.classList.toggle('is-filters-open', isOpen);
			if (document.body) {
				document.body.classList.toggle('phtf-drawer-open', isOpen);
			}
			if (isOpen) {
				lockDrawerToViewport();
			} else {
				clearDrawerViewportLock();
			}
			if (filterOverlay) {
				filterOverlay.hidden = !isOpen;
			}
			filterOpenButtons.forEach(function (button) {
				button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			});
		}

		function closeFiltersDrawer() {
			setFilterDrawerState(false);
		}

		function openFiltersDrawer() {
			if (!isMobileFilters()) {
				return;
			}
			setFilterDrawerState(true);
		}

		function resetFilterGroups() {
			Array.prototype.slice.call(widget.querySelectorAll('[data-phtf-filter-group]')).forEach(function (group) {
				group.classList.remove('is-collapsed');
			});
			filterGroupToggles.forEach(function (button) {
				button.setAttribute('aria-expanded', 'true');
			});
		}

		function activeValues(type) {
			return filters
				.filter(function (filter) {
					return filter.checked && filter.getAttribute('data-phtf-filter') === type;
				})
				.map(function (filter) {
					return filter.value;
				});
		}

		function productValueMatches(product, type, value) {
			var attr = type === 'seat' ? 'data-seat' : 'data-price';
			var raw = product.getAttribute(attr) || '';
			var values = raw.split(',').map(function (item) {
				return item.trim();
			}).filter(Boolean);

			return values.indexOf(value) !== -1;
		}

		function productMatchesSelections(product, seats, prices, overrideType, overrideValue) {
			var effectiveSeats = overrideType === 'seat' ? [overrideValue] : seats;
			var effectivePrices = overrideType === 'price' ? [overrideValue] : prices;
			var seatMatch = !effectiveSeats.length || effectiveSeats.some(function (seat) {
				return productValueMatches(product, 'seat', seat);
			});
			var priceMatch = !effectivePrices.length || effectivePrices.some(function (price) {
				return productValueMatches(product, 'price', price);
			});

			return seatMatch && priceMatch;
		}

		function productMatches(product, seats, prices) {
			return productMatchesSelections(product, seats, prices);
		}

		function updateFilterAvailability(seats, prices) {
			filters.forEach(function (filter) {
				var type = filter.getAttribute('data-phtf-filter');
				var label = filter.closest ? filter.closest('.phtf-checkbox') : null;
				var value = filter.value;
				var available = products.some(function (product) {
					return productMatchesSelections(product, seats, prices, type, value);
				});
				var disabled = !available && !filter.checked;

				filter.disabled = disabled;
				filter.setAttribute('aria-disabled', disabled ? 'true' : 'false');
				if (label) {
					label.classList.toggle('is-unavailable', disabled);
					label.setAttribute('aria-disabled', disabled ? 'true' : 'false');
				}
			});
		}

		function updateCounter() {
			if (!count) {
				return;
			}

			var label = count.getAttribute('data-label') || 'Results';
			if (!visibleProducts.length) {
				count.textContent = label + ' (0 of 0)';
				return;
			}

			count.textContent = label + ' (' + (currentIndex + 1) + ' of ' + visibleProducts.length + ')';
		}

		function setControlsState() {
			var disabled = visibleProducts.length <= 1;
			prevButtons.forEach(function (button) {
				button.disabled = disabled;
			});
			nextButtons.forEach(function (button) {
				button.disabled = disabled;
			});
		}

		function flashArrowState(button) {
			if (!button) {
				return;
			}
			button.classList.add('is-active');
			window.setTimeout(function () {
				button.classList.remove('is-active');
			}, 180);
		}

		function showCurrent() {
			products.forEach(function (product) {
				product.classList.remove('is-active');
			});

			if (!visibleProducts.length) {
				if (empty) {
					empty.hidden = false;
				}
				updateCounter();
				setControlsState();
				return;
			}

			if (empty) {
				empty.hidden = true;
			}

			if (currentIndex < 0) {
				currentIndex = visibleProducts.length - 1;
			}
			if (currentIndex >= visibleProducts.length) {
				currentIndex = 0;
			}

			visibleProducts[currentIndex].classList.add('is-active');
			updateCounter();
			setControlsState();
		}

		function applyFilters() {
			var seats = activeValues('seat');
			var prices = activeValues('price');
			updateFilterAvailability(seats, prices);
			visibleProducts = products.filter(function (product) {
				return productMatches(product, seats, prices);
			});
			currentIndex = 0;
			showCurrent();
		}

		function resetFilters() {
			filters.forEach(function (filter) {
				filter.checked = false;
				filter.disabled = false;
			});
			applyFilters();
		}

		filters.forEach(function (filter) {
			filter.addEventListener('change', applyFilters);
		});

		prevButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				flashArrowState(button);
				currentIndex -= 1;
				showCurrent();
			});
		});

		nextButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				flashArrowState(button);
				currentIndex += 1;
				showCurrent();
			});
		});

		filterOpenButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				openFiltersDrawer();
			});
		});

		filterCloseButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				closeFiltersDrawer();
			});
		});

		filterShowResultsButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				closeFiltersDrawer();
			});
		});

		filterResetButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				resetFilters();
			});
		});

		if (filterOverlay) {
			filterOverlay.addEventListener('click', function () {
				closeFiltersDrawer();
			});
		}

		filterGroupToggles.forEach(function (button) {
			button.addEventListener('click', function () {
				if (!isMobileFilters()) {
					return;
				}

				var group = button.closest('[data-phtf-filter-group]');
				if (!group) {
					return;
				}

				var collapsed = group.classList.toggle('is-collapsed');
				button.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
			});
		});

		window.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && widget.classList.contains('is-filters-open')) {
				closeFiltersDrawer();
			}
		});

		window.addEventListener('resize', function () {
			if (!isMobileFilters()) {
				closeFiltersDrawer();
				resetFilterGroups();
			} else if (widget.classList.contains('is-filters-open')) {
				lockDrawerToViewport();
			}
		});

		resetFilterGroups();
		applyFilters();
		initPricePopups(widget);
		initExplore(widget);
		document.dispatchEvent(new CustomEvent('phtfProductSourcesReady'));
	}


	function initSpaColors(root) {
		var customizer = root && root.matches && root.matches('[data-phtf-spa-colors]') ? root : (root ? root.querySelector('[data-phtf-spa-colors]') : null);
		if (!customizer || customizer.getAttribute('data-phtf-spa-initialized') === 'true') {
			return;
		}

		customizer.setAttribute('data-phtf-spa-initialized', 'true');

		var mainImage = customizer.querySelector('[data-phtf-spa-main-image]');
		var swatches = Array.prototype.slice.call(customizer.querySelectorAll('[data-phtf-spa-swatch]'));

		function activate(button) {
			var group = button.getAttribute('data-phtf-spa-group') || '';
			var image = button.getAttribute('data-phtf-spa-image') || '';

			Array.prototype.slice.call(customizer.querySelectorAll('[data-phtf-spa-swatch-wrap="' + group + '"]')).forEach(function (wrap) {
				wrap.classList.remove('is-active');
			});

			var wrapper = button.closest ? button.closest('[data-phtf-spa-swatch-wrap]') : button.parentNode;
			if (wrapper) {
				wrapper.classList.add('is-active');
			}

			if (mainImage && image) {
				mainImage.classList.add('is-changing');
				window.setTimeout(function () {
					mainImage.src = image;
					mainImage.classList.remove('is-changing');
				}, 120);
			}
		}

		swatches.forEach(function (button) {
			button.addEventListener('click', function () {
				activate(button);
			});
		});
	}



	function initDelight(root) {
		var delight = root && root.matches && root.matches('[data-phtf-delight]') ? root : (root ? root.querySelector('[data-phtf-delight]') : null);
		if (!delight || delight.getAttribute('data-phtf-delight-initialized') === 'true') {
			return;
		}

		delight.setAttribute('data-phtf-delight-initialized', 'true');

		var tabs = Array.prototype.slice.call(delight.querySelectorAll('[data-phtf-delight-tab]'));
		var panels = Array.prototype.slice.call(delight.querySelectorAll('[data-phtf-delight-panel]'));
		var prev = delight.querySelector('[data-phtf-delight-prev]');
		var next = delight.querySelector('[data-phtf-delight-next]');
		var index = 0;

		panels.forEach(function (panel, i) {
			if (panel.classList.contains('is-active')) {
				index = i;
			}
		});

		function setActive(newIndex) {
			if (!panels.length) {
				return;
			}
			if (newIndex < 0) {
				newIndex = panels.length - 1;
			}
			if (newIndex >= panels.length) {
				newIndex = 0;
			}
			index = newIndex;

			tabs.forEach(function (tab, i) {
				tab.classList.toggle('is-active', i === index);
				tab.setAttribute('aria-selected', i === index ? 'true' : 'false');
			});

			panels.forEach(function (panel, i) {
				panel.classList.toggle('is-active', i === index);
				if (i === index) {
					panel.removeAttribute('hidden');
				} else {
					panel.setAttribute('hidden', 'hidden');
				}
			});
		}

		function flash(button) {
			if (!button) {
				return;
			}
			button.classList.add('is-active');
			window.setTimeout(function () {
				button.classList.remove('is-active');
			}, 180);
		}

		tabs.forEach(function (tab, i) {
			tab.setAttribute('aria-selected', i === index ? 'true' : 'false');
			tab.addEventListener('click', function () {
				setActive(i);
			});
		});

		if (prev) {
			prev.addEventListener('click', function () {
				flash(prev);
				setActive(index - 1);
			});
		}

		if (next) {
			next.addEventListener('click', function () {
				flash(next);
				setActive(index + 1);
			});
		}
	}


	function initReviews(root) {
		var reviews = root && root.matches && root.matches('[data-phtf-reviews]') ? root : (root ? root.querySelector('[data-phtf-reviews]') : null);
		if (!reviews || reviews.getAttribute('data-phtf-reviews-initialized') === 'true') {
			return;
		}

		reviews.setAttribute('data-phtf-reviews-initialized', 'true');

		var slides = Array.prototype.slice.call(reviews.querySelectorAll('[data-phtf-reviews-slide]'));
		var dots = Array.prototype.slice.call(reviews.querySelectorAll('[data-phtf-reviews-dot]'));
		var prev = reviews.querySelector('[data-phtf-reviews-prev]');
		var next = reviews.querySelector('[data-phtf-reviews-next]');
		var index = 0;
		var timer = null;
		var autoplay = reviews.getAttribute('data-phtf-reviews-autoplay') === 'yes';
		var speed = parseInt(reviews.getAttribute('data-phtf-reviews-speed') || '5000', 10);

		if (!slides.length) {
			return;
		}

		slides.forEach(function (slide, i) {
			if (slide.classList.contains('is-active')) {
				index = i;
			}
		});

		function setActive(newIndex) {
			if (newIndex < 0) {
				newIndex = slides.length - 1;
			}
			if (newIndex >= slides.length) {
				newIndex = 0;
			}
			index = newIndex;

			slides.forEach(function (slide, i) {
				slide.classList.toggle('is-active', i === index);
				if (i === index) {
					slide.removeAttribute('hidden');
				} else {
					slide.setAttribute('hidden', 'hidden');
				}
			});

			dots.forEach(function (dot, i) {
				dot.classList.toggle('is-active', i === index);
				dot.setAttribute('aria-current', i === index ? 'true' : 'false');
			});
		}

		function flash(button) {
			if (!button) {
				return;
			}
			button.classList.add('is-active');
			window.setTimeout(function () {
				button.classList.remove('is-active');
			}, 180);
		}

		function restartAutoplay() {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}
			if (autoplay && slides.length > 1) {
				timer = window.setInterval(function () {
					setActive(index + 1);
				}, isNaN(speed) || speed < 1000 ? 5000 : speed);
			}
		}

		dots.forEach(function (dot, i) {
			dot.addEventListener('click', function () {
				setActive(i);
				restartAutoplay();
			});
		});

		if (prev) {
			prev.addEventListener('click', function () {
				flash(prev);
				setActive(index - 1);
				restartAutoplay();
			});
		}

		if (next) {
			next.addEventListener('click', function () {
				flash(next);
				setActive(index + 1);
				restartAutoplay();
			});
		}

		setActive(index);
		restartAutoplay();
	}


	function initCompareSpaModels(root) {
		var compare = root && root.matches && root.matches('[data-phtf-compare]') ? root : (root ? root.querySelector('[data-phtf-compare]') : null);
		if (!compare || compare.getAttribute('data-phtf-compare-initialized') === 'true') {
			return;
		}

		compare.setAttribute('data-phtf-compare-initialized', 'true');

		var json = compare.querySelector('.phtf-compare-json');
		var models = [];
		try {
			models = JSON.parse(json ? json.textContent || '[]' : '[]');
		} catch (error) {
			models = [];
		}

		var byId = {};
		var byLookup = {};
		function addModelLookup(value, model) {
			if (value === undefined || value === null) {
				return;
			}
			value = String(value).trim();
			if (!value) {
				return;
			}
			byLookup[value.toLowerCase()] = model;
		}
		models.forEach(function (model) {
			byId[String(model.id)] = model;
			addModelLookup(model.id, model);
			addModelLookup(model.spa_id, model);
			addModelLookup(model.slug, model);
		});

		function resolveModelId(value) {
			if (value === undefined || value === null) {
				return '';
			}
			var key = String(value).trim().toLowerCase();
			var model = key ? byLookup[key] : null;
			return model && model.id !== undefined ? String(model.id) : '';
		}

		function getUrlParam(name) {
			name = String(name || 'spaID');
			try {
				var params = new URLSearchParams(window.location.search || '');
				var direct = params.get(name);
				if (direct !== null) {
					return direct;
				}
				var found = '';
				params.forEach(function (value, key) {
					if (!found && String(key).toLowerCase() === name.toLowerCase()) {
						found = value;
					}
				});
				return found;
			} catch (error) {
				return '';
			}
		}

		function nl2br(value) {
			return escapeHtml(value || '').replace(/\n/g, '<br>');
		}

		function findSpecValue(model, key) {
			if (!model) {
				return '';
			}
			if (key === 'price') {
				return model.price || '';
			}
			if (model.specs && model.specs[key]) {
				return model.specs[key].value || '';
			}
			return model[key] || '';
		}

		function updateColumn(column, modelId) {
			var model = byId[String(modelId)] || null;
			var image = compare.querySelector('[data-phtf-compare-image][data-phtf-compare-column="' + column + '"]');
			if (image) {
				if (model && model.image) {
					image.src = model.image;
					image.alt = model.title || '';
					image.hidden = false;
				} else {
					image.removeAttribute('src');
					image.alt = '';
					image.hidden = true;
				}
			}

			Array.prototype.slice.call(compare.querySelectorAll('[data-phtf-compare-spec][data-phtf-compare-column="' + column + '"]')).forEach(function (cell) {
				var key = cell.getAttribute('data-phtf-compare-spec') || '';
				cell.innerHTML = nl2br(findSpecValue(model, key));
				applySpecialCharSuperscripts(cell);
			});
		}

		var selects = Array.prototype.slice.call(compare.querySelectorAll('[data-phtf-compare-select]'));
		if ((compare.getAttribute('data-phtf-compare-auto-url') || 'yes') === 'yes') {
			var urlValue = getUrlParam(compare.getAttribute('data-phtf-compare-url-param') || 'spaID');
			var urlModelId = resolveModelId(urlValue);
			if (urlModelId) {
				var targetColumn = String(parseInt(compare.getAttribute('data-phtf-compare-url-column') || '0', 10) || 0);
				var clearOtherColumns = (compare.getAttribute('data-phtf-compare-clear-other-url-columns') || 'yes') === 'yes';
				selects.forEach(function (select) {
					var column = select.getAttribute('data-phtf-compare-column') || '0';
					if (column === targetColumn) {
						select.value = urlModelId;
					} else if (clearOtherColumns) {
						select.value = '';
					}
				});
			}
		}

		selects.forEach(function (select) {
			var column = select.getAttribute('data-phtf-compare-column') || '0';
			updateColumn(column, select.value);
			select.addEventListener('change', function () {
				updateColumn(column, select.value);
			});
		});
	}


	function initPricePopups(root) {
		var scope = root || document;
		var wraps = Array.prototype.slice.call(scope.querySelectorAll ? scope.querySelectorAll('.phtf-price-note-wrap') : []);
		var closeDelay = 520;
		var openDelay = 100;
		var safeBuffer = 34;

		function getPopup(wrap) {
			return wrap ? wrap.phtfDetachedPopup || wrap.querySelector('.phtf-price-note-popup') : null;
		}

		function copyPopupVars(wrap, popup) {
			var widget = wrap && wrap.closest ? wrap.closest('.phtf-widget') : null;
			if (!widget || !popup || !window.getComputedStyle) {
				return;
			}
			var styles = window.getComputedStyle(widget);
			['--phtf-price-popup-width', '--phtf-price-popup-max-height', '--phtf-price-info-title-color', '--phtf-price-info-text-color', '--phtf-price-info-accent-color', '--phtf-primary', '--phtf-secondary', '--phtf-text'].forEach(function (name) {
				var value = styles.getPropertyValue(name);
				if (value) {
					popup.style.setProperty(name, value.trim());
				}
			});
		}

		function detachPopup(wrap) {
			var popup = getPopup(wrap);
			if (!popup) {
				return null;
			}

			wrap.phtfDetachedPopup = popup;
			popup.phtfOwnerWrap = wrap;
			popup.classList.add('phtf-popup-detached');
			copyPopupVars(wrap, popup);

			if (popup.parentNode !== document.body) {
				document.body.appendChild(popup);
			}

			return popup;
		}

		function updatePopupActiveState() {
			Array.prototype.slice.call(document.querySelectorAll('.phtf-widget.phtf-price-popup-active')).forEach(function (widget) {
				if (!widget.querySelector('.phtf-price-note-wrap.is-open')) {
					widget.classList.remove('phtf-price-popup-active');
				}
			});
		}

		function clearWrapTimers(wrap) {
			if (!wrap) {
				return;
			}
			clearTimeout(wrap.phtfCloseTimer);
			clearTimeout(wrap.phtfOpenTimer);
		}

		function setPointer(wrap, event) {
			if (!wrap || !event) {
				return;
			}
			wrap.phtfPointerX = event.clientX;
			wrap.phtfPointerY = event.clientY;
		}

		function pointInRect(x, y, rect, buffer) {
			return rect && x >= rect.left - buffer && x <= rect.right + buffer && y >= rect.top - buffer && y <= rect.bottom + buffer;
		}

		function pointerIsInsideSafeArea(wrap) {
			if (!wrap || typeof wrap.phtfPointerX !== 'number' || typeof wrap.phtfPointerY !== 'number') {
				return false;
			}
			var trigger = wrap.querySelector('.phtf-price-note-trigger');
			var popup = getPopup(wrap);
			if (!trigger || !popup || !trigger.getBoundingClientRect || !popup.getBoundingClientRect) {
				return false;
			}

			var x = wrap.phtfPointerX;
			var y = wrap.phtfPointerY;
			var triggerRect = trigger.getBoundingClientRect();
			var popupRect = popup.getBoundingClientRect();

			if (pointInRect(x, y, triggerRect, safeBuffer) || pointInRect(x, y, popupRect, safeBuffer)) {
				return true;
			}

			// Smooth bridge between the superscript and the popup. This prevents the
			// popover from closing/reopening while the cursor crosses the small gap.
			var bridgeLeft = Math.min(triggerRect.left, popupRect.left) - safeBuffer;
			var bridgeRight = Math.max(triggerRect.right, popupRect.right) + safeBuffer;
			var bridgeTop = Math.min(triggerRect.bottom, popupRect.top) - safeBuffer;
			var bridgeBottom = Math.max(triggerRect.bottom, popupRect.top) + safeBuffer;
			return x >= bridgeLeft && x <= bridgeRight && y >= bridgeTop && y <= bridgeBottom;
		}

		function positionPopup(wrap) {
			var trigger = wrap ? wrap.querySelector('.phtf-price-note-trigger') : null;
			var popup = detachPopup(wrap);
			if (!trigger || !popup || !trigger.getBoundingClientRect) {
				return;
			}

			copyPopupVars(wrap, popup);

			// Use fixed viewport positioning so opening the popup never adds to
			// document height, toggles the browser scrollbar, or shifts the slider.
			var rect = trigger.getBoundingClientRect();
			var viewportWidth = document.documentElement.clientWidth || window.innerWidth || 0;
			var gutter = 16;
			var popupWidth = popup.offsetWidth || 540;
			var naturalLeft = rect.left + (rect.width / 2) - (popupWidth / 2);
			var maxLeft = Math.max(gutter, viewportWidth - popupWidth - gutter);
			var left = Math.min(Math.max(naturalLeft, gutter), maxLeft);
			var arrowLeft = rect.left + (rect.width / 2) - left;
			var top = rect.bottom + 14;

			popup.style.left = Math.round(left) + 'px';
			popup.style.top = Math.round(top) + 'px';
			popup.style.setProperty('--phtf-popup-arrow-left', Math.max(18, Math.min(popupWidth - 18, arrowLeft)) + 'px');
		}

		function closeWrap(wrap) {
			if (!wrap) {
				return;
			}
			var trigger = wrap.querySelector('.phtf-price-note-trigger');
			var popup = getPopup(wrap);
			clearWrapTimers(wrap);
			wrap.phtfLockedOpen = false;
			wrap.phtfIsOverTrigger = false;
			wrap.phtfIsOverPopup = false;
			wrap.classList.remove('is-open');
			if (popup) {
				popup.classList.remove('is-open');
				popup.classList.remove('phtf-is-positioning');
				popup.style.visibility = '';
				popup.style.opacity = '';
				popup.style.pointerEvents = '';
			}
			if (trigger) {
				trigger.setAttribute('aria-expanded', 'false');
			}
			updatePopupActiveState();
		}

		function scheduleClose(wrap) {
			if (!wrap || wrap.phtfLockedOpen) {
				return;
			}
			clearTimeout(wrap.phtfCloseTimer);
			wrap.phtfCloseTimer = setTimeout(function () {
				var trigger = wrap.querySelector('.phtf-price-note-trigger');
				var triggerHasFocus = trigger && document.activeElement === trigger;
				if (!wrap.phtfLockedOpen && !wrap.phtfIsOverTrigger && !wrap.phtfIsOverPopup && !triggerHasFocus && !pointerIsInsideSafeArea(wrap)) {
					closeWrap(wrap);
				}
			}, closeDelay);
		}

		function closeOtherWraps(currentWrap) {
			Array.prototype.slice.call(document.querySelectorAll('.phtf-price-note-wrap.is-open')).forEach(function (open) {
				if (open !== currentWrap) {
					closeWrap(open);
				}
			});
		}

		function openWrap(wrap, mode) {
			var trigger = wrap.querySelector('.phtf-price-note-trigger');
			var popup = detachPopup(wrap);
			if (!trigger || !popup) {
				return;
			}

			clearWrapTimers(wrap);
			closeOtherWraps(wrap);
			positionPopup(wrap);
			wrap.classList.add('is-open');
			popup.classList.add('is-open');
			popup.classList.remove('phtf-is-positioning');
			if (mode === 'click') {
				wrap.phtfLockedOpen = true;
			}

			// Popup is detached to body with fixed positioning, so there is no need
			// to change the slider/container overflow when hovering. Keeping the
			// widget untouched prevents slide/content movement.
			trigger.setAttribute('aria-expanded', 'true');
		}

		function scheduleOpen(wrap, mode) {
			clearTimeout(wrap.phtfCloseTimer);
			clearTimeout(wrap.phtfOpenTimer);
			if (wrap.classList.contains('is-open')) {
				openWrap(wrap, mode);
				return;
			}
			wrap.phtfOpenTimer = setTimeout(function () {
				openWrap(wrap, mode);
			}, openDelay);
		}

		function toggleLockedPopup(wrap) {
			if (wrap.classList.contains('is-open') && wrap.phtfLockedOpen) {
				closeWrap(wrap);
				return;
			}
			openWrap(wrap, 'click');
		}

		wraps.forEach(function (wrap) {
			if (wrap.getAttribute('data-phtf-price-popup-initialized') === 'true') {
				return;
			}
			wrap.setAttribute('data-phtf-price-popup-initialized', 'true');

			var trigger = wrap.querySelector('.phtf-price-note-trigger');
			var popup = detachPopup(wrap);
			var close = popup ? popup.querySelector('.phtf-price-note-close') : wrap.querySelector('.phtf-price-note-close');

			if (trigger) {
				trigger.addEventListener('mouseenter', function (event) {
					setPointer(wrap, event);
					wrap.phtfIsOverTrigger = true;
					scheduleOpen(wrap, 'hover');
				});
				trigger.addEventListener('mousemove', function (event) {
					setPointer(wrap, event);
				});
				trigger.addEventListener('mouseleave', function (event) {
					setPointer(wrap, event);
					wrap.phtfIsOverTrigger = false;
					scheduleClose(wrap);
				});
				trigger.addEventListener('focus', function () {
					openWrap(wrap, 'focus');
				});
				trigger.addEventListener('blur', function () {
					scheduleClose(wrap);
				});
				trigger.addEventListener('click', function (event) {
					event.preventDefault();
					event.stopPropagation();
					setPointer(wrap, event);
					toggleLockedPopup(wrap);
				});
			}

			if (popup) {
				popup.addEventListener('mouseenter', function (event) {
					setPointer(wrap, event);
					wrap.phtfIsOverPopup = true;
					clearTimeout(wrap.phtfCloseTimer);
				});
				popup.addEventListener('mousemove', function (event) {
					setPointer(wrap, event);
				});
				popup.addEventListener('mouseleave', function (event) {
					setPointer(wrap, event);
					wrap.phtfIsOverPopup = false;
					scheduleClose(wrap);
				});
			}

			if (close) {
				close.addEventListener('click', function (event) {
					event.preventDefault();
					event.stopPropagation();
					closeWrap(wrap);
					if (trigger) {
						trigger.blur();
					}
				});
			}
		});

		if (!window.phtfPricePopupPositionListenersAdded) {
			window.phtfPricePopupPositionListenersAdded = true;
			var repositionQueued = false;
			function queueReposition() {
				if (repositionQueued) {
					return;
				}
				repositionQueued = true;
				(window.requestAnimationFrame || window.setTimeout)(function () {
					repositionQueued = false;
					Array.prototype.slice.call(document.querySelectorAll('.phtf-price-note-wrap.is-open')).forEach(positionPopup);
				}, 16);
			}
			window.addEventListener('resize', queueReposition, true);
			document.addEventListener('mousemove', function (event) {
				Array.prototype.slice.call(document.querySelectorAll('.phtf-price-note-wrap.is-open')).forEach(function (wrap) {
					setPointer(wrap, event);
					if (!wrap.phtfLockedOpen && !wrap.phtfIsOverTrigger && !wrap.phtfIsOverPopup && !pointerIsInsideSafeArea(wrap)) {
						scheduleClose(wrap);
					}
				});
			}, true);
		}
	}


	document.addEventListener('keydown', function (event) {
		if (event.key !== 'Escape') {
			return;
		}
		Array.prototype.slice.call(document.querySelectorAll('.phtf-price-note-wrap.is-open')).forEach(function (wrap) {
			var trigger = wrap.querySelector('.phtf-price-note-trigger');
			var popup = wrap.phtfDetachedPopup || wrap.querySelector('.phtf-price-note-popup');
			wrap.phtfLockedOpen = false;
			wrap.phtfIsOverTrigger = false;
			wrap.phtfIsOverPopup = false;
			clearTimeout(wrap.phtfCloseTimer);
			clearTimeout(wrap.phtfOpenTimer);
			wrap.classList.remove('is-open');
			if (popup) {
				popup.classList.remove('is-open');
				popup.classList.remove('phtf-is-positioning');
				popup.style.left = '';
				popup.style.top = '';
				popup.style.visibility = '';
				popup.style.opacity = '';
				popup.style.pointerEvents = '';
			}
			if (trigger) {
				trigger.setAttribute('aria-expanded', 'false');
			}
		});
		Array.prototype.slice.call(document.querySelectorAll('.phtf-widget.phtf-price-popup-active')).forEach(function (widget) {
			widget.classList.remove('phtf-price-popup-active');
		});
	});


	function initAll() {
		collectProductSources();
		Array.prototype.slice.call(document.querySelectorAll('[data-phtf-widget]')).forEach(initFinder);
		Array.prototype.slice.call(document.querySelectorAll('[data-phtf-explore]')).forEach(initExplore);
		Array.prototype.slice.call(document.querySelectorAll('[data-phtf-spa-colors]')).forEach(initSpaColors);
		Array.prototype.slice.call(document.querySelectorAll('[data-phtf-delight]')).forEach(initDelight);
		Array.prototype.slice.call(document.querySelectorAll('[data-phtf-reviews]')).forEach(initReviews);
		Array.prototype.slice.call(document.querySelectorAll('[data-phtf-compare]')).forEach(initCompareSpaModels);
		applySpecialCharSuperscripts(document);
		initPricePopups(document);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAll);
	} else {
		initAll();
	}

	document.addEventListener('phtfProductSourcesReady', function () {
		Array.prototype.slice.call(document.querySelectorAll('[data-phtf-explore]')).forEach(initExplore);
		applySpecialCharSuperscripts(document);
	});

	document.addEventListener('click', function (event) {
		if (event.target && event.target.closest && (event.target.closest('.phtf-price-note-wrap') || event.target.closest('.phtf-price-note-popup'))) {
			return;
		}
		Array.prototype.slice.call(document.querySelectorAll('.phtf-price-note-wrap.is-open')).forEach(function (wrap) {
			wrap.phtfLockedOpen = false;
			wrap.phtfIsOverTrigger = false;
			wrap.phtfIsOverPopup = false;
			clearTimeout(wrap.phtfCloseTimer);
			clearTimeout(wrap.phtfOpenTimer);
			wrap.classList.remove('is-open');
			var popup = wrap.phtfDetachedPopup || wrap.querySelector('.phtf-price-note-popup');
			if (popup) {
				popup.classList.remove('is-open');
				popup.classList.remove('phtf-is-positioning');
				popup.style.left = '';
				popup.style.top = '';
				popup.style.visibility = '';
				popup.style.opacity = '';
				popup.style.pointerEvents = '';
			}
			var trigger = wrap.querySelector('.phtf-price-note-trigger');
			if (trigger) {
				trigger.setAttribute('aria-expanded', 'false');
			}
		});
		Array.prototype.slice.call(document.querySelectorAll('.phtf-widget.phtf-price-popup-active')).forEach(function (widget) {
			widget.classList.remove('phtf-price-popup-active');
		});
	});


	window.addEventListener('elementor/frontend/init', function () {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			function refreshSpecialChars($scope) {
				var root = $scope && $scope[0] ? $scope[0] : document;
				applySpecialCharSuperscripts(root);
			}
			window.elementorFrontend.hooks.addAction('frontend/element_ready/phtf_hot_tub_finder.default', function ($scope) {
				var root = $scope && $scope[0] ? $scope[0].querySelector('[data-phtf-widget]') : null;
				if (root) {
					initFinder(root);
					initPricePopups(root);
				}
			});
			window.elementorFrontend.hooks.addAction('frontend/element_ready/phtf_explore_models.default', function ($scope) {
				var root = $scope && $scope[0] ? $scope[0].querySelector('[data-phtf-explore]') : null;
				if (root) {
					initExplore(root);
				}
			});
			window.elementorFrontend.hooks.addAction('frontend/element_ready/phtf_spa_colors.default', function ($scope) {
				var root = $scope && $scope[0] ? $scope[0].querySelector('[data-phtf-spa-colors]') : null;
				if (root) {
					initSpaColors(root);
				}
			});
			window.elementorFrontend.hooks.addAction('frontend/element_ready/phtf_spa_series_delight.default', function ($scope) {
				var root = $scope && $scope[0] ? $scope[0].querySelector('[data-phtf-delight]') : null;
				if (root) {
					initDelight(root);
				}
			});
			window.elementorFrontend.hooks.addAction('frontend/element_ready/phtf_reviews.default', function ($scope) {
				var root = $scope && $scope[0] ? $scope[0].querySelector('[data-phtf-reviews]') : null;
				if (root) {
					initReviews(root);
				}
			});
			window.elementorFrontend.hooks.addAction('frontend/element_ready/phtf_compare_spa_models.default', function ($scope) {
				var root = $scope && $scope[0] ? $scope[0].querySelector('[data-phtf-compare]') : null;
				if (root) {
					initCompareSpaModels(root);
				}
			});

			[
				'phtf_hot_tub_finder',
				'phtf_explore_models',
				'phtf_spa_colors',
				'phtf_spa_series_models',
				'phtf_spa_series_delight',
				'phtf_reviews',
				'phtf_spa_model_specifications',
				'phtf_compare_spa_models',
				'phtf_series_comparison'
			].forEach(function (widgetName) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/' + widgetName + '.default', function ($scope) {
					setTimeout(function () {
						refreshSpecialChars($scope);
					}, 0);
				});
			});
		}
	});
}());
