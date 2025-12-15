class ExpiryDates {
  constructor() {
    this.pills = document.querySelectorAll('.info-pill-expiry');
    this.init();
  }

  init() {
    this.pills.forEach(pill => {
      const expiryAttr = pill.getAttribute('data-expiry');
      const spanForText = pill.querySelector('.ends-in-text');

      let formattedExpiry = '';

      if (expiryAttr === 'Expired') {
        formattedExpiry = 'Expired';
      } else {
        // Convert attribute to number (ms timestamp)
        const expiryTimestamp = Number(expiryAttr);

        if (!Number.isNaN(expiryTimestamp)) {
          const expiryDateFormatter = new ExpiryDateFormatter(expiryTimestamp);
          formattedExpiry = expiryDateFormatter.getFormattedExpiry();
        } else {
          formattedExpiry = 'Invalid date';
        }
      }

      if (spanForText) {
        spanForText.innerHTML = formattedExpiry;
      }

      this.addExpiryClass(pill, formattedExpiry);
    });
  }

  addExpiryClass(pill, formattedExpiry) {
    pill.classList.remove('seconds', 'expired', 'days', 'months', 'weeks', 'hours');

    if (formattedExpiry === 'Expired') {
      pill.classList.add('expired');
    } else if (formattedExpiry.includes('Hour')) {
      pill.classList.add('hours');
    } else if (formattedExpiry.includes('Day')) {
      pill.classList.add('days');
    } else if (formattedExpiry.includes('Week')) {
      pill.classList.add('weeks');
    } else {
      pill.classList.add('months');
    }
  }
}

class ExpiryDateFormatter {
  constructor(expiryTimestamp) {
    /** @type {number} */
    this.expiryTimestamp = expiryTimestamp;
  }

  getFormattedExpiry() {
    const currentTime = Date.now(); // number in ms
    const timeDifference = this.expiryTimestamp - currentTime;

    // console.log("type currentTime: " + typeof currentTime);        
    // console.log("type expiryTimestamp: " + typeof this.expiryTimestamp); 
    // console.log("type timeDifference: " + typeof timeDifference);  

    if (timeDifference <= 0) {
      return 'Expired';
    }

    const seconds = Math.floor(timeDifference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const weeks = Math.floor(days / 7);
    const months = Math.floor(days / 30); // rough

    if (weeks > 0 && weeks < 4) return `<span class="text">ends in</span> <span class="time">${weeks} week${weeks > 1 ? 's' : ''}</span>`;

    if (days > 0 && days < 30) return `<span class="text">ends in</span> <span class="time">${days} day${days > 1 ? 's' : ''}</span>`;

    if (hours > 0 && hours < 24) return `<span class="text">ends in</span> <span class="time">${hours} hour${hours > 1 ? 's' : ''}</span>`;

    if (months >= 1) return `<span class="text">ends</span> <span class="time">${this.formatExactDate()}</span>`;

    return 'ends in less than a minute';
  }

  formatExactDate() {
    const options = { month: 'short', day: 'numeric' };
    return new Date(this.expiryTimestamp).toLocaleDateString('en-US', options);
  }
}

export default ExpiryDates;
