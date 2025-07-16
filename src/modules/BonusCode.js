class BonusCode {
  constructor() {
    this.bonusCodeBtns = document.querySelectorAll('.bonus-code');
    this.bonusCopied = false;
    this.copyIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z" /></svg>'
    this.successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" /></svg>'
    this.events();
  }

  events() {
    // If there are no elements on the page then return
    if (this.bonusCodeBtns.length === 0) return;

    // Loop through 
    this.bonusCodeBtns.forEach(node => {
      node.addEventListener('click', () => {
        let bonusText = node.querySelector('.bonus-code__code').textContent;
        this.copyTextToClipboard(bonusText);

        if (this.bonusCopied = true) this.handleSuccess(node);
      });
    });
  }


  handleSuccess(el) {
    let svgSpan = el.querySelector('.bonus-code__icon');
    svgSpan.innerHTML = '';
    svgSpan.innerHTML = this.successIcon;

    setTimeout(() => {
      svgSpan.innerHTML = '';
      svgSpan.innerHTML = this.copyIcon;
      this.bonusCopied = false;
    }, 2500);
  }


  copyTextToClipboard(text) {
    navigator.clipboard.writeText(text).then(function () {
      this.bonusCopied = true;
    }).catch(function (err) {
      console.error('Failed to copy text: ', err);
    });
  }
}

export default BonusCode;
