class Patterns {
	constructor() {
		this.headingTogglePats = document.querySelectorAll('.pattern.heading-toggle');
		this.init();
	}

	init() {
		const validGroups = Array.from(this.headingTogglePats).filter(this.isValidGroup);

		validGroups.forEach((group) => {
			this.setupToggleGroup(group);
		});
	}

	isValidGroup(group) {
		// Only works if we have the heading available
		const heading = group.querySelector('h1, h2, h3, h4, h5, h6');
		return heading && heading.classList.contains('wp-block-heading');
	}

	setupToggleGroup(group) {
		const heading = group.querySelector('h1, h2, h3, h4, h5, h6');
		heading.classList.add('heading-toggle__title');

		const iconButton = document.createElement('button');
		iconButton.classList.add('round-icon');
		iconButton.innerHTML = svgIcons.chevronDown;

		// Accessibility: link button to content
		const contentDiv = document.createElement('div');
		const contentId = `toggle-content-${Math.random().toString(36).substr(2, 9)}`;
		contentDiv.id = contentId;
		contentDiv.classList.add('heading-toggle__content');
		contentDiv.setAttribute('aria-hidden', 'true');

		iconButton.setAttribute('aria-expanded', 'false');
		iconButton.setAttribute('aria-controls', contentId);

		heading.appendChild(iconButton);

		let sibling = heading.nextElementSibling;
		while (sibling) {
			const next = sibling.nextElementSibling;
			contentDiv.appendChild(sibling);
			sibling = next;
		}

		group.appendChild(contentDiv);

		heading.addEventListener('click', () => {
			const expanded = iconButton.getAttribute('aria-expanded') === 'true';
			iconButton.setAttribute('aria-expanded', String(!expanded));
			contentDiv.setAttribute('aria-hidden', String(expanded));
			iconButton.classList.toggle('rotated');
			contentDiv.classList.toggle('expanded');
		});
	}

}

export default Patterns;