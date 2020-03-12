import { Draggable, Sortable } from '@shopify/draggable';

const sortable = new Sortable(document.querySelectorAll('.draggable-container'), {
  draggable: 'li'
});

sortable.on('sortable:start', () => console.log('sortable:start'));
sortable.on('sortable:sort', () => console.log('sortable:sort'));
sortable.on('sortable:sorted', () => console.log('sortable:sorted'));
sortable.on('sortable:stop', () => console.log('sortable:stop'));

const asyncBtn = document.querySelectorAll('.async');
asyncBtn.forEach(function(item) {
  item.addEventListener('click', setOrderThenSend)
});

function setOrderThenSend(e) {
  e.preventDefault();
  let target = document.getElementById('savable');
  let children = Array.from(target.children);
  // on va construire l'array à envoyer en récupérant les id dans le dom et numérotant à la volée
  let selectedQuestions = [];
  children.forEach((item, i) => {
    selectedQuestions[i] = item.id;
  });
}
