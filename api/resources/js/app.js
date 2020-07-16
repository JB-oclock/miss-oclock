require('./bootstrap');


(function () {
    const deletebtns = document.getElementsByClassName('deletebtn');
    const modalBtn = document.getElementById('confirm-delete-btn');
    const titleCopy = document.getElementById('question-title-copy');
    const messages = {
        'delete': 'Voulez-vous réellement supprimer cet élément : ',
        'reset': 'Voulez-vous vraiment réinitialiser : ',
        'next-step': 'Voulez-vous vraiment passer à l\'étape suivante',
        'next-question': 'Voulez-vous vraiment passer à la question suivante',
        'display-answer': 'Voulez-vous vraiment afficher la réponse',
        'valid-winners': 'Voulez-vous vraiment valider les vainqueurs',
    }
    for (let btn of deletebtns) {
        btn.addEventListener('click', function (e) {
            let url = e.target.dataset.href;
            let title = e.target.dataset.title;

            modalBtn.href = url;
            titleCopy.innerHTML = messages[e.target.dataset.action] + '<span class="font-weight-bold">' + title + '</span> ?';
        });
    }
})();
