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
		const wrapper = group.querySelector('.wp-block-group__inner-container');
		const heading = wrapper.firstElementChild;

		return heading && heading.classList.contains('wp-block-heading');
	}

	setupToggleGroup(group) {
		const wrapper = group.querySelector('.wp-block-group__inner-container');
		const heading = wrapper.firstElementChild;
		heading.classList.add('heading-toggle__title');
		// console.log('heading', heading);

		const iconButton = document.createElement('button');
		iconButton.classList.add('round-icon');
		iconButton.innerHTML = svgIcons.chevronDown;
		heading.appendChild(iconButton);
		console.log(svgIcons);

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


// let groupContent = document.querySelectorAll('.wp-block-group');


// Filter groups to only those that have a heading as the first child
// let groupContentToToggle = Array.from(groupContent).filter((group) => {
//     const firstChild = group.firstElementChild;

//     // Check if the first child is a heading and has the class 'wp-block-heading'
//     return (
//         firstChild &&
//         firstChild.classList.contains('wp-block-heading')
//     );
// });

// Add a click event listener to each heading
// groupContentToToggle.map((group) => {
//     let heading = group.firstElementChild;
//     heading.classList.add('toggle-heading');

//     // Create a chevron icon element
//     const iconButton = document.createElement('button');
//     iconButton.classList.add('round-icon');
//     iconButton.innerHTML = svgIcons.chevronDown;

//     heading.appendChild(iconButton);

//     // Group all the content inside one div
//     const contentDiv = document.createElement('div');
//     contentDiv.classList.add('toggle-heading-content');
//     // Get all content after the heading and group it up

//     // Get all siblings after the heading
//     let sibling = heading.nextElementSibling;
//     while (sibling) {
//         const next = sibling.nextElementSibling; // Save reference before moving
//         contentDiv.appendChild(sibling);
//         sibling = next;
//     }

//     // Append the contentDiv to the group
//     group.appendChild(contentDiv);

//     heading.addEventListener('click', () => {
//         console.log('Heading clicked:', heading.textContent);
//         iconButton.classList.toggle('rotated');
//         contentDiv.classList.toggle('expanded');
//     });
// });