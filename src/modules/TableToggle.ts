const tableToggle = () => {
  const tables: NodeListOf<Element> = document.querySelectorAll('#toggle-table')
  console.log('tables is an array of 1 i am guessing', tables)

  Array.from(tables).map(table => {
    const rows = table.querySelectorAll('.main-row') as NodeListOf<HTMLTableRowElement>;

    if (!rows) return;

    Array.from(rows).map(row => {

      row.addEventListener('click', () => {
        const rowID = row.getAttribute('data-toggle-row');

        const contentRow = document.querySelector(`[data-toggle-content="${rowID}"]`);
        if (contentRow) {
          contentRow.classList.toggle('d-none');
        }
      })
    })
  })
}

export default tableToggle;