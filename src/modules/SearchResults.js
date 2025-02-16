// New York Times: https://www.nytimes.com/search?dropmab=false&query=asd&sort=best
import axios from "axios";

class SearchResultsNew {
  constructor() {
    this.query = '';
    this.type = 'all';
    this.order = 'DESC'
    this.orderby = 'relevance';
    this.postType = 'all';
    this.page = 1;
    this.websiteUrl = new URL(window.location.href);
    this.resultsCount = 0;
    this.resultsCountEl = document.getElementById('search-results-count-container');
    this.resultsContainer = document.getElementById('search-results-container');
    this.paginationContainer = document.getElementById('search-pagination-container');
    this.spinner = document.getElementById('spinner');
    this.form = document.getElementById('searchForm');
    this.input = this.form.querySelector('input[id="searchInput"]');
    this.select = document.getElementById('searchSelect');
    this.allCheckboxes = document.querySelectorAll('.form-check-input');

    this.applyFilterBtns = document.querySelectorAll('#filterApplyBtn');
    this.filterResetBtns = document.querySelectorAll('#filterResetBtn');
    this.filterCountEl = document.querySelector('.filter-count');
    this.filterCount = 0;
    this.filterDesktopWrapper = document.querySelector('.desktop-filter');
    this.sortResultsWrapper = document.querySelector('.search-sort-by');
    this.init();
  }

  // Initialize the component
  init() {
    const searchQuery = this.getQueryParam('s');

    if (!searchQuery) {
      this.hideLoader();
      this.paintNoResults();
      return;
    };

    this.query = this.sanitizeInput(searchQuery);

    this.input.value = this.query;

    this.fetchSearchResults();

    this.input.addEventListener('input', (event) => this.handleInputChange(event));
    this.form.addEventListener('submit', (event) => this.handleFormSubmit(event));
    this.select.addEventListener('change', (event) => this.handleSelectChange(event));
    [...this.applyFilterBtns].map(btn => btn.addEventListener('click', () => this.handleFilterApply()));
    [...this.filterResetBtns].map(btn => btn.addEventListener('click', () => this.resetAllFilters()));
    [...this.allCheckboxes].map(checkbox => checkbox.addEventListener('change', () => this.syncCheckboxes(checkbox)));
  }

  syncCheckboxes(changedCheckbox) {

    // Find all checkboxes with the same value
    const checkboxesToSync = document.querySelectorAll(`.form-check-input[value="${changedCheckbox.value}"]`);

    // Update their state to match the changed checkbox
    checkboxesToSync.forEach(checkbox => {
      if (checkbox !== changedCheckbox) {
        checkbox.checked = changedCheckbox.checked;
      }
    });
  }


  resetAllFilters() {
    const checkboxes = document.querySelectorAll('.form-check-input');
    checkboxes.forEach(checkbox => checkbox.checked = false);
    this.filterCount = 0;
    this.updateFilterCount();
  }


  handleFilterApply() {
    const checkboxes = document.querySelectorAll('.checkboxes'); // Select all checkbox containers

    [...checkboxes].forEach(checkbox => {
      const type = checkbox.getAttribute('data-checkbox-type'); // Get the type (e.g., 'postType')
      const checks = checkbox.querySelectorAll('.form-check-input'); // Select all checkboxes inside

      const allCheckedItems = [...checks] // Convert NodeList to Array
        .filter(check => check.checked) // Filter only checked checkboxes
        .map(check => check.value); // Map their values

      this.filterCount = allCheckedItems.length;

      if (type === 'postType') {
        this.type = allCheckedItems.length > 0 ? `[${allCheckedItems.map(item => `"${item}"`).join(', ')}]` : 'all'; // Add checked items or default to 'all'
      } // else if (type == 'crypto')
    });

    this.page = 1;
    this.clearResults();
    this.fetchSearchResults();
    this.updateFilterCount();
  }

  updateFilterCount() {
    if (this.filterCount == 0) {
      this.filterCountEl.classList.add('d-none');
    } else {
      this.filterCountEl.classList.remove('d-none');
    };

    this.filterCountEl.textContent = this.filterCount;
  }



  handleInputChange(event) {
    const input = event.target.value;
    if (!input) return;
    this.query = input;
  }

  handleFormSubmit(event) {
    event.preventDefault();

    if (this.query == '') return;

    const url = new URL(window.location);
    url.searchParams.set('s', this.query); // Update or add a query parameter
    window.history.pushState({}, '', url); // Push the updated URL to the browser history

    this.page = 1;
    this.clearResults();
    this.fetchSearchResults();
  }

  handleSelectChange(event) {
    switch (event.target.value) {
      case 'date_desc':
        this.order = 'DESC';
        this.orderby = 'date';
        break;
      case 'date_asc':
        this.order = 'ASC';
        this.orderby = 'date';
        break;
      default:
        this.order = 'DESC';
        this.orderby = 'relevance';
        break;
    };

    this.page = 1;
    this.clearResults();
    this.fetchSearchResults();
  }

  clearResults() {
    this.resultsCountEl.innerHTML = "";
    this.resultsContainer.innerHTML = "";
    this.paginationContainer.innerHTML = "";
  }

  // Get query parameter by name
  getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  }

  sanitizeInput(input) {
    input = input.replace(/[\\"'&<>]/g, ''); // Remove dangerous characters
    input = input.replace(/[^a-zA-Z0-9 _.-]/g, ''); // Allow only alphanumeric, spaces, hyphens, underscores, periods
    return input;
  }


  async fetchSearchResults() {
    try {
      this.showLoader();

      const response = await axios.get(`${this.websiteUrl.origin}/wp-json/chaser/v2/search`, {
        params: {
          term: this.query,
          type: this.type,
          page: this.page,
          order: this.order,
          orderby: this.orderby
        }
      });

      const { terms, results, currentPage, totalPages, totalPosts } = response.data;


      this.page = currentPage;

      if (results.length > 0) {
        this.showInputElements();
        this.paintResults(results, terms);
        this.paintCount(totalPosts);
        this.paintPagination(currentPage, totalPages);
      } else {
        this.hideInputElements();
        this.paintNoResults();
      }
    } catch (error) {
      this.hideInputElements();
      this.paintNoResults();
    } finally {
      this.hideLoader();
    }
  }

  paintResults(results, terms) {

    if (terms.length !== 0) {
      let randomHTML = '';
      randomHTML = `
        <div class="search-topics">
          <span class="subtitle">Topics</span>
        <div class="search-topics__layout">
      `;
      terms.forEach(term => {
        const { title, link, image } = term;

        randomHTML += ` 
          <div class="tax-pill sort-focus">

            ${image ? `  
              <div class="tax-pill__media">
                <img src="${image}" width="45" height="45" alt="" aria-hidden="true" />
              </div> 
            ` : ''}

            <div class="tax-pill__content">
              <h3 class="h6 m-0">
                <a class="tax-pill__link" href="${link}">${title}</a>
              </h3>
            </div>
          </div>
        `;

      });

      randomHTML += `
                </div>
          </div>
        `;

      const randomFragment = document.createRange().createContextualFragment(randomHTML);
      this.resultsContainer.appendChild(randomFragment);

    }

    results.forEach(r => {
      const { title, image, link, excerpt, postType } = r;

      const postTypeDisplay = postType == "post" ? "Article" : postType;

      const cardHTML = `
        <div class= "search-card-wrapper">
          <a class="h-100" href="${link}">
            <div class="search-card h-100">
              <div class="search-card__body">
                <span class="subtitle">${postTypeDisplay}</span>
                <h3 class="title">${title}</h3>
                ${excerpt ? `<p class="excerpt">${excerpt}</p>` : ''}
              </div>
              <div class="search-card__media">
                ${image ? `<img src="${image}" width="135" height="135"/>` : ''}
              </div>
            </div>
          </a>
        </div>
        `;
      const fragment = document.createRange().createContextualFragment(cardHTML);
      this.resultsContainer.appendChild(fragment);
    });
  }

  showInputElements() {
    // this.filterDesktopWrapper.classList.remove('d-none');
    this.sortResultsWrapper.classList.remove('d-none');
    this.sortResultsWrapper.classList.add('d-flex');
  }

  hideInputElements() {
    // this.filterDesktopWrapper.classList.add('d-none');
    this.sortResultsWrapper.classList.remove('d-flex');
    this.sortResultsWrapper.classList.add('d-none');
  }

  showLoader() {
    this.spinner.style.display = 'flex';
  }

  hideLoader() {
    this.spinner.style.display = 'none';
  }

  paintNoResults() {
    const note = `<div style = "text-align: center;" > No results found for the query < strong > ${this.query}</strong ></div> `;
    const fragment = document.createRange().createContextualFragment(note);
    this.resultsCountEl.replaceChildren(fragment);

  }

  paintCount(totalPosts) {
    const note = `${totalPosts} results.`;
    const fragment = document.createRange().createContextualFragment(note);
    this.resultsCountEl.replaceChildren(fragment);
  }

  paintPagination(page, totalPages) {
    if (totalPages === 0) return;

    const wrapper = document.createElement("div");
    wrapper.className = "d-flex flex-column align-items-center";

    if (page < totalPages) {
      const button = document.createElement("button");
      button.className = "button button__primary";
      button.textContent = "Load More";
      button.addEventListener("click", (event) => this.handleLoadMoreClick(event, button));
      wrapper.appendChild(button);
    }

    this.paginationContainer.replaceChildren(wrapper);
  }

  async handleLoadMoreClick(event, button) {
    button.textContent = "Loading";
    button.disabled = true;
    this.page++;
    await this.fetchSearchResults();
  }
}

export default SearchResultsNew;