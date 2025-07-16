class ReviewArchive {
  constructor() {
    this.taxes = {
      'review_type': [],
      'cryptocurrency': [],
      'game': [],
      'provider': [],
      'payment': []
    };

    this.checkboxLists = document.querySelectorAll('ul.checkboxes');
    this.checkboxes = document.querySelectorAll('.term-checkbox');
    this.totalPostsFound = document.querySelector('.tax-query-posts-found');
    this.showMoreTerms = document.querySelectorAll('.term-box__show-more');
    this.clearFilterBtn = document.querySelector('.tax-query-clear-btn');

    // Get the filter overlay and its content
    this.pageOverlay = document.getElementById('page-overlay');
    this.filterOverlay = document.getElementById('filter-overlay');
    this.filterOverlayResults = document.querySelector('.filter-overlay__results');
    this.filterOverlayClose = document.getElementById('filter-overlay-close');
    this.filterOverlayTitle = this.filterOverlay.querySelector('.title');
    this.filterOverlayApplyBtn = document.getElementById('filter-apply-btn');
    this.filterOverlayResetBtn = document.getElementById('filter-reset-btn');

    this.spinner = document.getElementById('spinner-wrapper');

    this.init();
  }
  

  init(){
    this.checkboxes.forEach(checkbox => checkbox.addEventListener('change', (event) => this.handleCheckboxClick(event)));
    this.showMoreTerms.forEach(showMore => showMore.addEventListener('click', (event) => this.handleShowMoreClick(event)));
    this.filterOverlayClose.addEventListener('click', () => this.closeFilterModal());
    this.filterOverlay.addEventListener('click', (event) => this.handleFilterOverlayClick(event));
    this.clearFilterBtn.addEventListener('click', () => this.handleClearFilter());
    this.filterOverlayApplyBtn.addEventListener('click', () => this.handleFilterOverlayApplyClick());
  }

  reorderCheckboxes() {
    // Reorder the checkboxes in each list based on their checked state
    this.checkboxLists.forEach(list => {
      // Get all checkboxes in the list
      const checkboxes = Array.from(list.querySelectorAll('.term-checkbox'));
      // Sort checkboxes based on their checked state
      const sortedCheckboxes = checkboxes.sort((a, b) => {
        const aChecked = a.querySelector('input[type="checkbox"]').checked;
        const bChecked = b.querySelector('input[type="checkbox"]').checked;
        // Sort checked items first, then unchecked
        return (bChecked - aChecked);
      });
      // Clear the list and append sorted checkboxes
      list.innerHTML = '';
      sortedCheckboxes.forEach(checkbox => list.appendChild(checkbox));
    });
  }

  handleFilterOverlayApplyClick() {
    // Update the state
    [...this.filterOverlayResults.querySelectorAll('.checkbox__input')].forEach(checkbox => {
      const termValue = checkbox.value;
      const termTax = checkbox.getAttribute('data-term-tax');
      const termName = checkbox.getAttribute('data-term-name');
      
  

      // Check if the term is already in the array
      if (checkbox.checked) {
        // If it is, add it
        if (!this.taxes[termTax].includes(termValue)) {
          this.taxes[termTax].push(termValue);
        }
      } else {
        // If it isn't, remove it
        this.taxes[termTax] = this.taxes[termTax].filter(value => value !== termValue);
      }
      // Reorder the checkboxes based on the current state of the taxes
      this.reorderCheckboxes();
      // Update the results
      this.paintResults();
      // Close the filter modal
      this.closeFilterModal();

      console.log('Updated taxes:', this.taxes);
  });

  // Update the UI for the rest of the checkboxes
  this.checkboxes.forEach(checkbox => {
    const termValue = checkbox.querySelector('input[type="checkbox"]').value;
    const termTax = checkbox.querySelector('input[type="checkbox"]').getAttribute('data-term-tax');
    // Check if the term is already in the array
    if (this.taxes[termTax].includes(termValue)) {
      checkbox.querySelector('input[type="checkbox"]').checked = true;
    } else {
      checkbox.querySelector('input[type="checkbox"]').checked = false;
    }
  });

  // Reorder the checkoxes based on the current state of the taxes
  
  // Fetch the data with the updated taxes
  this.fetchData();
}

  handleClearFilter() {
    this.taxes = {
      'review_type': [],
      'cryptocurrency': [],
      'game': [],
      'provider': [],
      'payment': []
    };
    // Uncheck all checkboxes
    this.checkboxes.forEach(checkbox => {
      checkbox.querySelector('input[type="checkbox"]').checked = false;
    });
    // Clear the results
    this.fetchData();
  }

  handleFilterOverlayClick(event) {
    if (event.target === this.filterOverlay) {
      this.closeFilterModal();
    }
  } 

  handleCheckboxClick(event) {
    const termValue = event.target.value;
    const termTax = event.target.getAttribute('data-term-tax');
    const termName = event.target.getAttribute('data-term-name');

    // Check if the term is already in the array
    const exists = this.taxes[termTax].some(item => item.id === termValue);
    if (!exists) {
      // Add new term 
      this.taxes[termTax].push({
        id: termValue,
        name: termName,
        taxonomy: termTax
      });

    } else {
      // Remove existing term
      this.taxes[termTax] = this.taxes[termTax].filter(value => value.id !== termValue);
    }

    // Update the results
    this.fetchData();
  }

  async fetchData() {
    this.showLoader(); 
    
    try {
      const perPage = '10';

      const taxParams = Object.entries(this.taxes)
        .filter(([, ids]) => ids.length > 0)
        .map(([taxonomy, ids]) => `${taxonomy}=${ids.join(',')}`)
        .join('&');

      // Your existing API URL
      let apiUrl = `/wp-json/wp/v2/review/?${taxParams}&per_page=${perPage}`;

      // Fetch the data
      const response = await fetch(apiUrl);
      const data = await response.json();
      const totalResults = response.headers.get('X-WP-Total');
      // const totalPages = response.headers.get('X-WP-TotalPages');
      
      this.paintResults(data);
      this.totalPostsFound.innerHTML = totalResults;
    } catch (error) {
      // Handle errors
      console.error('Error fetching data:', error);
    } finally {
      this.hideLoader(); 
    }
  }

  async handleShowMoreClick(event) {
    const tax = event.target.getAttribute('data-term-tax');
    const apiUrl = `/wp-json/wp/v2/${tax}?per_page=50&hide_empty=true&orderby=count&order=desc`;

    try {
      const response = await fetch(apiUrl);
      if (!response.ok) throw new Error('Failed to fetch terms');
      const data = await response.json();
      
      const selectedTerms = this.taxes[tax];
      
      const checkboxes = data.map(term => {
        const isChecked = selectedTerms.includes(String(term.id)) ? 'checked' : '';
        return `
          <li class="term-checkbox checkbox">
            <input class="checkbox__input" type="checkbox" value="${term.id}" data-term-tax="${tax}" id="checkbox-${term.id}" ${isChecked}>
            <label class="checkbox__label" for="checkbox-${term.id}">${term.name}</label>
          </li>
        `;
      }).join('');

      // Wrap in a container
      const wrappedCheckboxes = `<ul class="checkboxes">${checkboxes}</ul>`;

      // Add the terms to the checkboxes
      this.filterOverlayResults.innerHTML = wrappedCheckboxes;
      this.filterOverlayTitle.innerHTML = tax;

      // Show the filter overlay
      this.openFilterModal();
      
    } catch (error) {
      console.error('Error loading more terms:', error);
    }
  }

  paintResults(data) {
    // console.log('paintResults', data);
  }

  openFilterModal() {
    this.pageOverlay.classList.add('active');
    this.filterOverlay.classList.add('active');
    document.body.style.overflow = 'hidden'; 
  }

  closeFilterModal() {
    this.pageOverlay.classList.remove('active');
    this.filterOverlay.classList.remove('active');
    document.body.style.overflow = 'auto';
  }

  showLoader() {
    this.spinner.style.display = 'flex';
  }

  hideLoader() {
    this.spinner.style.display = 'none';
  }
}

export default ReviewArchive;