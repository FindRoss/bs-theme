class Faqs {
	constructor() {
		this.toggles = document.querySelectorAll('.faq__toggle');
		this.init();
	}

	init() {
		this.toggles.forEach(btn => {
			btn.addEventListener('click', () => {
				const expanded = btn.getAttribute('aria-expanded') === 'true';
				btn.setAttribute('aria-expanded', String(!expanded));
				const answer = document.getElementById(btn.getAttribute('aria-controls'));
				answer.setAttribute('aria-hidden', String(expanded));
				answer.classList.toggle('expanded');
				btn.querySelector('.faq__icon').classList.toggle('rotated');
			});
		});
	}
}

export default Faqs;
