import { Draggable, Sortable } from '@shopify/draggable';

const sortable = new Sortable(document.querySelectorAll('.draggable-container'), {
  draggable: 'li'
});

// sortable.on('sortable:start', () => console.log('sortable:start'));
// sortable.on('sortable:sort', () => console.log('sortable:sort'));
// sortable.on('sortable:sorted', () => console.log('sortable:sorted'));
// sortable.on('sortable:stop', () => console.log('sortable:stop'));

const asyncBtn = document.querySelectorAll('.async');
asyncBtn.forEach(function(item) {
  item.addEventListener('click', setOrderThenSend)
});

function setOrderThenSend(e) {
  e.preventDefault();
  let targetName = e.target.dataset.type;
  let target = document.querySelector(`.container-${targetName}`);
  let children = Array.from(target.children);
  // on va construire l'array à envoyer en récupérant les id dans le dom et numérotant à la volée
  let selectedElements = [];
  children.forEach((item, i) => {
    selectedElements.push(item.dataset.id);
  });

  let input = document.querySelector(`.${targetName}`);
  input.value = selectedElements;
  let form = document.querySelector('.edit-form');
  
  form.submit();
}
