// Small UI helpers for the redesigned layout
// - Handles responsive adjustments and simple interactions

document.addEventListener('DOMContentLoaded', function(){
  // Make book action groups collapsible on very small screens
  document.querySelectorAll('.book-card').forEach(card=>{
    const actions = card.querySelector('.book-action');
    if(!actions) return;
    const toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.className = 'btn btn-secondary';
    toggle.style.padding = '6px 10px';
    toggle.style.fontSize = '0.95rem';
    toggle.textContent = 'Aksi';
    // only show toggle on small screens
    const mq = window.matchMedia('(max-width:480px)');
    function update(){
      if(mq.matches){
        if(!card.querySelector('.action-toggle')){
          toggle.classList.add('action-toggle');
          card.insertBefore(toggle, actions);
          actions.style.display = 'none';
          toggle.addEventListener('click', ()=>{
            actions.style.display = actions.style.display === 'none' ? 'flex' : 'none';
          });
        }
      } else {
        const t = card.querySelector('.action-toggle');
        if(t){ t.remove(); actions.style.display = 'flex'; }
      }
    }
    mq.addListener(update);
    update();
  });
});