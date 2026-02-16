// live_books.js
// Polls `api/get_latest_books.php` and replaces the `.book-list` content
(function(){
  const POLL_INTERVAL = 8000; // ms
  const LIMIT = 20;
  const endpoint = 'api/get_latest_books.php?limit=' + LIMIT;

  async function fetchBooks(){
    try{
      const res = await fetch(endpoint, {cache: 'no-store'});
      if(!res.ok) throw new Error('Network response not ok');
      const data = await res.json();
      if(data && data.ok){
        renderBooks(data.books);
      }
    }catch(err){
      console.error('live_books fetch error', err);
    }
  }

  function renderBooks(books){
    const container = document.querySelector('.book-list');
    if(!container) return;
    // build cards similar to server-side markup
    container.innerHTML = '';
    let no = 1;
    books.forEach(b => {
      const card = document.createElement('div');
      card.className = 'book-card';
      card.innerHTML = `
        <div class="book-title">#${no++} - <a href="detail_buku.php?id=${b.id_buku}">${escapeHtml(b.judul)}</a></div>
        <div class="book-img"><a href="detail_buku.php?id=${b.id_buku}"><img src="upload/${escapeHtml(b.foto || '')}" alt="${escapeHtml(b.judul)}" width="140"></a></div>
        <div class="book-info">
          <div><span class="book-label">Penulis:</span> ${escapeHtml(b.penulis)}</div>
          <div><span class="book-label">Penerbit:</span> ${escapeHtml(b.penerbit)}</div>
          <div><span class="book-label">Stok:</span> ${b.stok}</div>
          <div><span class="book-label">Status:</span> <span class="badge-status ${b.stok==0 ? 'habis' : (b.status? b.status.toLowerCase() : '')}">${escapeHtml(b.status ? b.status : '')}</span></div>
          <div><span class="book-label">Rak:</span> ${escapeHtml(b.rak)}</div>
          <div class="book-action">
            ${b.status === 'Tersedia' && b.stok > 0 ? `<a class="action-btn primary" href="pinjam.php?id=${b.id_buku}">Pinjam</a>` : `<a class="action-btn disabled">Pinjam</a>`}
            <a class="action-btn ghost" href="detail_buku.php?id=${b.id_buku}">Detail</a>
            ${window.IS_ADMIN ? `<a class="action-btn ghost" href="edit_buku.php?id=${b.id_buku}">Edit</a>` : ''}
          </div>
        </div>
      `;
      container.appendChild(card);
    });
  }

  function escapeHtml(str){
    if(!str && str !== 0) return '';
    return String(str).replace(/[&<>"']/g, function(ch){
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[ch];
    });
  }

  // initial fetch + interval
  document.addEventListener('DOMContentLoaded', ()=>{
    fetchBooks();
    setInterval(fetchBooks, POLL_INTERVAL);
  });
})();
