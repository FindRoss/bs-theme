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
		heading.appendChild(iconButton);

		const contentDiv = document.createElement('div');
		contentDiv.classList.add('heading-toggle__content');

		let sibling = heading.nextElementSibling;
		while (sibling) {
			const next = sibling.nextElementSibling;
			contentDiv.appendChild(sibling);
			sibling = next;
		}

		group.appendChild(contentDiv);

		heading.addEventListener('click', () => {
			iconButton.classList.toggle('rotated');
			contentDiv.classList.toggle('expanded');
		});
	}
}

export default Patterns;