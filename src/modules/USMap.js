class USMap {
	constructor() {
		this.maps = document.querySelectorAll('.us-map');
		this.init();
	}

	init() {
		this.maps.forEach((map) => this.setupMap(map));
	}

	setupMap(map) {
		const dataScript = map.querySelector('.us-map__data');
		const tooltip = map.querySelector('.us-map__tooltip');
		if (!dataScript || !tooltip) return;

		let data;
		try {
			data = JSON.parse(dataScript.textContent);
		} catch (e) {
			return;
		}

		const states = data.states || {};
		const statuses = data.statuses || {};

		map.querySelectorAll('.us-map__state').forEach((el) => {
			const state = states[el.id];
			if (!state) return;

			el.setAttribute('data-status', state.status);
			el.setAttribute('tabindex', '0');
			el.setAttribute('role', state.url ? 'link' : 'img');
			el.setAttribute('aria-label', state.name);

			const show = (event) => this.showTooltip(tooltip, state, statuses, event);
			const hide = () => {
				tooltip.hidden = true;
			};

			el.addEventListener('mouseenter', show);
			el.addEventListener('mousemove', show);
			el.addEventListener('mouseleave', hide);
			el.addEventListener('focus', show);
			el.addEventListener('blur', hide);

			if (state.url) {
				el.addEventListener('click', () => {
					window.location.href = state.url;
				});
				el.addEventListener('keydown', (event) => {
					if (event.key === 'Enter' || event.key === ' ') {
						event.preventDefault();
						window.location.href = state.url;
					}
				});
			}
		});
	}

	showTooltip(tooltip, state, statuses, event) {
		tooltip.textContent = '';

		const name = document.createElement('span');
		name.className = 'us-map__tooltip-name';
		name.textContent = state.name;
		tooltip.appendChild(name);

		const status = document.createElement('span');
		status.className = 'us-map__tooltip-status';
		status.style.setProperty('--dot-color', `var(--us-map-color-${state.status})`);
		status.textContent = statuses[state.status] || state.status;
		tooltip.appendChild(status);

		if (state.note) {
			const note = document.createElement('span');
			note.className = 'us-map__tooltip-note';
			note.textContent = state.note;
			tooltip.appendChild(note);
		}

		tooltip.hidden = false;

		const rect = tooltip.getBoundingClientRect();
		const targetRect = event.target.getBoundingClientRect();
		const x = event.clientX ?? targetRect.left;
		const y = event.clientY ?? targetRect.top;
		const offset = 16;

		let left = x + offset;
		let top = y + offset;

		if (left + rect.width > window.innerWidth) {
			left = x - rect.width - offset;
		}
		if (top + rect.height > window.innerHeight) {
			top = y - rect.height - offset;
		}

		tooltip.style.left = `${left}px`;
		tooltip.style.top = `${top}px`;
	}
}

export default USMap;
