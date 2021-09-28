require('./bootstrap');


document.addEventListener('DOMContentLoaded', function () {
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


    let playersContainer = document.querySelector('.live-players');

    if(playersContainer !== null) {
        // Live display of players
        const url = new URL(playersContainer.dataset.mercure +'.well-known/mercure');
        url.searchParams.append('topic', playersContainer.dataset.subscribe);

        const eventSource = new EventSource(url , { withCredentials: true });
        eventSource.onmessage = function ({data}) {
            const noAnswer = document.querySelector('.no-players');
            if(noAnswer !== null) {
                noAnswer.remove();
            }

            data = JSON.parse(data);

            const newPlayer = document.createElement('li');
            newPlayer.className = "list-group-item w-50 border  p-2 px-3";
            newPlayer.textContent = data.player;

            playersContainer.append(newPlayer);


            const total = document.querySelector('.total-players');
           total.textContent = playersContainer.querySelectorAll('li').length;
        };
    }

    let answersContainer = document.querySelector('.live-questions');
    if(answersContainer !== null) {

        // Live display of the answers
        const url = new URL(answersContainer.dataset.mercure +'.well-known/mercure');
        url.searchParams.append('topic', answersContainer.dataset.subscribe);


        const eventSource = new EventSource(url , { withCredentials: true });

        // The callback will be called every time an update is published
        eventSource.onmessage = function ({data}) {
            const noAnswer = document.querySelector('.no-answer');
            if(noAnswer !== null) {
                noAnswer.remove();
            }

            data = JSON.parse(data);
            const template = document.importNode(document.querySelector('.answer-template').content, true);
            const newAnswer = template.querySelector('div');
            newAnswer.textContent = data.player;
            if(data.answer === true) {
                newAnswer.classList.add('alert-success');
            }
            answersContainer.append(newAnswer);

            const laterPlayer = document.querySelector(`div[data-later="${data.player}"`);
            laterPlayer.remove();
            const latersContainer = document.querySelector('.laters');
            if(latersContainer.childElementCount === 0) {
                latersContainer.textContent = "Tout le monde a répondu !";
            }

            const total = answersContainer.querySelectorAll('div');
            document.querySelector('.answers .current').textContent = total.length;
        };
    }


    let votesContainer = document.querySelector('.live-vote');
    if(votesContainer !== null) {
        // Live display of the performance votes
        const url = new URL(votesContainer.dataset.mercure +'.well-known/mercure');
        url.searchParams.append('topic', votesContainer.dataset.subscribe);

        const eventSource = new EventSource(url , { withCredentials: true });

        eventSource.onmessage = function () {

            let total = Number(votesContainer.querySelector('span').textContent);
            total++;
            votesContainer.querySelector('span').textContent = total;
        };

    }

    let finalContainer = document.querySelector('.live-final');
    if(finalContainer !== null) {
        console.log("Live final");
        // Live display of the final votes
        const url = new URL(finalContainer.dataset.mercure +'.well-known/mercure');
        url.searchParams.append('topic', finalContainer.dataset.subscribe);

        const eventSource = new EventSource(url , { withCredentials: true });

        eventSource.onmessage = function ({data}) {
            data = JSON.parse(data);


            const players = finalContainer.querySelectorAll('.name');
            for (const player of players) {
                if(player.textContent === data.vote) {
                    let scoreElement = player.closest('li').querySelector('.score');
                    scoreElement.textContent = Number(scoreElement.textContent) + 1;
                }
            }

            const scores = finalContainer.querySelectorAll('.score');
            let total = 0;

            for (const score of scores) {
                total += Number(score.textContent);
            }

            document.querySelector('.total span').textContent = total;
        };

    }


});

