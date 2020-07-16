require('./bootstrap');


const deletebtns = document.getElementsByClassName('deletebtn');
const modalBtn = document.getElementById('confirm-delete-btn');
const titleCopy = document.getElementById('question-title-copy');
const messages = {
    'delete': 'Voulez-vous réellement supprimer cet élément : ',
    'reset': 'Voulez-vous vraiment réinitialiser : '
}
for (let btn of deletebtns) {
btn.addEventListener('click', function(e){
    let url = e.target.parentElement.dataset.href;
    let title = e.target.parentElement.dataset.title;
    
    modalBtn.href = url;
    titleCopy.innerHTML = messages[e.target.parentElement.dataset.action] + '<span class="font-weight-bold">"' + title + '"</span> ?';
});
          }