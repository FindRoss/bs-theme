export function processExpiryPills(pills) {
  pills.forEach(pill => {
    const expiryAttr = pill.getAttribute('data-expiry');
    const spanForText = pill.querySelector('.ends-in-text');

    let formattedExpiry = '';

    if (expiryAttr === 'Expired') {
      formattedExpiry = 'Expired';
      setPillClass(pill, 'expired');
    } else {
      const expiryTimestamp = Number(expiryAttr);

      if (!Number.isNaN(expiryTimestamp)) {
        const formatter = new ExpiryDateFormatter(expiryTimestamp);
        formattedExpiry = formatter.getFormattedExpiry();
        setPillClass(pill, formatter.getUnit());
      } else {
        formattedExpiry = 'Invalid date';
      }
    }

    if (spanForText) {
      spanForText.innerHTML = formattedExpiry;
    }

    pill.dataset.expiryDone = '1';
  });
}

function setPillClass(pill, unit) {
  pill.classList.remove('seconds', 'expired', 'days', 'months', 'weeks', 'hours');
  pill.classList.add(unit);
}

class ExpiryDateFormatter {
  constructor(expiryTimestamp) {
    /** @type {number} */
    this.expiryTimestamp = expiryTimestamp;
  }

  getFormattedExpiry() {
    const timeDifference = this.expiryTimestamp - Date.now();

    if (timeDifference <= 0) return 'Expired';

    const seconds = Math.floor(timeDifference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours   = Math.floor(minutes / 60);
    const days    = Math.floor(hours / 24);
    const weeks   = Math.floor(days / 7);
    const months  = Math.floor(days / 30);

    if (weeks > 0 && weeks < 4) return `Ends in <span class="time">${weeks} week${weeks > 1 ? 's' : ''}</span>`;
    if (days > 0 && days < 30)  return `Ends in <span class="time">${days} day${days > 1 ? 's' : ''}</span>`;
    if (hours > 0 && hours < 24) return `Ends in <span class="time">${hours} hour${hours > 1 ? 's' : ''}</span>`;
    if (months >= 1) return `Ends <span class="time">${this.formatExactDate()}</span>`;

    return 'Ends in &lt; 1 min';
  }

  getUnit() {
    const timeDifference = this.expiryTimestamp - Date.now();
    if (timeDifference <= 0) return 'expired';
    const hours  = Math.floor(timeDifference / 1000 / 60 / 60);
    const days   = Math.floor(hours / 24);
    const weeks  = Math.floor(days / 7);
    const months = Math.floor(days / 30);
    if (weeks > 0 && weeks < 4) return 'weeks';
    if (days > 0 && days < 30)  return 'days';
    if (hours > 0 && hours < 24) return 'hours';
    if (months >= 1) return 'months';
    return 'hours';
  }

  formatExactDate() {
    const date = new Date(this.expiryTimestamp);
    const options = date.getFullYear() !== new Date().getFullYear()
      ? { month: 'short', day: 'numeric', year: 'numeric' }
      : { month: 'short', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
  }
}

class ExpiryDates {
  constructor() {
    processExpiryPills(document.querySelectorAll('.info-pill-expiry'));
  }
}

export default ExpiryDates;
