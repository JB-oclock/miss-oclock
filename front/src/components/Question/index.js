// == Import : npm
import React, { Component } from 'react';

class Question extends Component {
  componentDidMount() {
    this.eventSource = '';
    this.listenQuestions();
  }

  listenQuestions = () => {
    const {app, setQuestion } = this.props;
    
    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}${process.env.MERCURE_QUESTIONS}${app.gameId}.jsonld`);
    const eventSource = new EventSource(url, { withCredentials: true });
    
    eventSource.onmessage = (event) => {
      const { questions } = JSON.parse(event.data);
      setQuestion(questions);
    };
  }

  componentWillUnmount(){

    if(typeof this.eventSource !== 'string') {
        this.eventSource.close();
    }
}

  render() {
    const { questions } = this.props;
    
    if(!questions.answered) {
        if(questions.questionId == 0) {
            return "La première question va bientôt arriver !";
        } else {
            return (
                <form>
                    <h2>{questions.question}</h2>
                    
                </form>
            );
        }
    }
    else {
        return "Merci d'avoir répondu, la prochaine question arrive bientôt !";
    }
  }
}
// == Export
export default Question;
