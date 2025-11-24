const tableToggle = () => {
  const tables: NodeListOf<Element> = document.querySelectorAll('#toggle-table')

  Array.from(tables).map(table => {
    const btn = table.querySelector('.toggle-table-button') as HTMLButtonElement;

    if (btn) {
      console.log(btn)
      console.log(typeof btn)

      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-toggle-target');
        const contentRow = document.querySelector(`[data-toggle-content="${targetId}"]`);
        const chevron = btn.querySelector('svg');

        if (contentRow) {
          contentRow.classList.toggle('d-none');
          chevron?.classList.toggle('rotate');
        }
      })

    }

  })

  return (
    console.log('returning somethin from tabletoggle')
  )

  // .toggle-table-button 
  // its a button

}

export default tableToggle;