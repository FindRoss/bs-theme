class ExpiryDates {
  constructor() {
    this.pills = document.querySelectorAll('.info-pill-expiry');
    this.init();
  }

  init() {
    this.pills.forEach(pill => {
      const expiryDate = pill.dataset.expiry;

      const spanForText = pill.querySelector('.ends-in-text');

      let formattedExpiry = '';

      if (expiryDate == 'Expired') {
        formattedExpiry = 'Expired';
      } else {
        // Instantiate the ExpiryDateFormatter
        const expiryDateFormatter = new ExpiryDateFormatter(expiryDate);
        // Get the formatted expiry date
        formattedExpiry = expiryDateFormatter.getFormattedExpiry();
      }

      // Set the expiry text
      spanForText.textContent = formattedExpiry;

      // Add the appropriate class based on expiry status
      this.addExpiryClass(pill, formattedExpiry);
    });
  }

  addExpiryClass(pill, formattedExpiry) {
    // Remove any previous expiry status classes
    pill.classList.remove('seconds', 'expired', 'days', 'months', 'weeks');

    // Determine the appropriate class to add
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
  constructor(expiryDate) {
    this.expiryDate = new Date(expiryDate); // Assume expiryDate is in UTC format (e.g., '2025-01-28T00:00:00Z')
  }

  getFormattedExpiry() {
    const currentTime = new Date().toUTCString(); // Get current time in UTC
    const currentTimeUtc = new Date(currentTime); // Convert current time to UTC Date object

    const timeDifference = this.expiryDate - currentTimeUtc;

    if (timeDifference <= 0) {
      return 'Expired';
    }

    const seconds = Math.floor(timeDifference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const weeks = Math.floor(days / 7);
    const months = Math.floor(days / 30); // Rough approximation

    // Show "Ends in X Weeks" if it's less than 1 month but more than 1 week
    if (weeks > 0 && weeks < 4) {
      return `Ends in ${weeks} Week${weeks > 1 ? 's' : ''}`;
    }

    // Show "Ends in X Days" if it's less than 1 week
    if (days > 0 && days < 30) {
      return `Ends in ${days} Day${days > 1 ? 's' : ''}`;
    }

    // Show "Ends in X Hours" if it's less than 1 day
    if (hours > 0 && hours < 24) {
      return `Ends in ${hours} Hour${hours > 1 ? 's' : ''}`;
    }

    // Show exact date if it's 1 month or more
    if (months >= 1) {
      return `Ends ${this.formatExactDate()}`;
    }

    return 'Ends in less than a minute';
  }

  formatExactDate() {
    const options = { month: 'short', day: 'numeric' };
    return this.expiryDate.toLocaleDateString('en-US', options); // e.g., "Aug 17"
  }
}

export default ExpiryDates;
