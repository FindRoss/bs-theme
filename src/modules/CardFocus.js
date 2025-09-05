// class CardFocus {
//   constructor() {
//     this.cards = document.querySelectorAll('.sort-focus');
//     this.events()
//   }

//   events() {
//     this.cards.forEach(card => {
//       const button = card.querySelector('.button');

//       if (button) {

//         button.addEventListener('focus', () => {
//           card.classList.add('no-focus-within');
//         });

//         button.addEventListener('blur', () => {
//           card.classList.remove('no-focus-within');
//         });
//       }
//     });
//   }
// }

// export default CardFocus;