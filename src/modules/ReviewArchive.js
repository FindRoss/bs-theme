// Reviews index
let taxes = {
  'cryptocurrency': [],
  'game': [],
  'provider': [],
  'payment': []
};



// Get term and send to JS. 
const termSelects = document.querySelectorAll('.term-select');

// Iterate over each select element and add an event listener
termSelects.forEach(function (termSelect) {
  termSelect.addEventListener('change', function () {

    // Need term term_id
    const termValue = termSelect.value;

    // Traverse up the DOM tree to the grandparent with class "terms-container"
    const grandparent = termSelect.parentNode.parentNode;
    // Get the value of the "data-tax" attribute from the grandparent
    const taxValue = grandparent.getAttribute('data-tax');


    if (taxes[taxValue.contains])
      taxes[taxValue].push(termValue);

    fetchData(taxes);
  });
});


// Fetch review
async function fetchData(taxes) {

  try {
    // Replace these values with your actual values
    const postType = 'review';
    const taxonomies = ['game', 'cryptocurrency', 'payment', 'provider'];
    const increasedPerPage = '18';

    // Your existing API URL
    let apiUrl = `/wp-json/wp/v2/${postType}/`;

    // Create a URLSearchParams object
    const params = new URLSearchParams();

    // Add the query parameter(s)
    params.append('cryptocurrency', '16843');
    // params.append('tag', 'javascript');

    // Append the parameters to the API URL
    apiUrl += `?${params.toString()}`;

    // const apiUrl = `/wp-json/wp/v2/${postType}?per_page=${increasedPerPage}&${taxonomies.map(taxonomy => `${taxonomy}=${taxes[taxonomy].join(',')}`).join('&')}`;
    // const apiUrl = `/wp-json/wp/v2/${postType}?per_page=${increasedPerPage}&cryptocurrency=16843`;


    // Fetch the data
    const response = await fetch(apiUrl);
    const data = await response.json();
  } catch (error) {
    // Handle errors
    console.error('Error fetching data:', error);
  }
}




// Show more terms list. 
// Need to add a way to distinguish between the different terms.
// JavaScript function to show the first ten and hide the rest
//  function showFirstTen() {
//   var container = document.querySelector('.terms-container');
//   var checkboxes = container.querySelectorAll('.form-check');

//   checkboxes.forEach(function (checkbox, index) {
//       if (index < 10) {
//           checkbox.classList.remove('visually-hidden');
//       } else {
//           checkbox.classList.add('visually-hidden');
//       }
//   });

//   // Adjust the height of the container
//   container.style.height = 'auto';
// }

// // Call the function when the page loads
// document.addEventListener('DOMContentLoaded', function () {
//   showFirstTen();
// });