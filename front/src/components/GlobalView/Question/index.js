// == Import : npm
import React, { Component } from 'react';
import { answerQuestion, endQuestions } from '../../../store/questionsReducer';

class Question extends Component {
  componentDidMount() {
    this.eventSourceQuestions = '';
    this.eventSourceAnswers = '';
    this.listenQuestions();
    this.listenAnswers();
  }

  state = {
    answer: '',
    winners: '',
  }

  listenQuestions = () => {
    const {app, setQuestion, setWinner, endQuestions } = this.props;
    
    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}${process.env.MERCURE_QUESTIONS}${app.gameId}.jsonld`);
    this.eventSourceQuestions = new EventSource(url, { withCredentials: true });
    
    this.eventSourceQuestions.onmessage = (event) => {
      const { questions, winners } = JSON.parse(event.data);
      if(questions){
        setQuestion(questions);
      }

      if(winners){
        
        this.setState({
          winners
        });
        endQuestions();
        
      }
    }; 
  }

  listenAnswers = () => {
    const {app, setAnswered } = this.props;

    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}${process.env.MERCURE_ANSWERS}${app.gameId}.jsonld`);
    this.eventSourceAnswers = new EventSource(url, { withCredentials: true });

    this.eventSourceAnswers.onmessage = (event) => {
      const { answer } = JSON.parse(event.data);
      
      if(answer) {
        setAnswered();
        this.setState({
          answer
        });
      }
       
    };
  }

  componentWillUnmount(){
    if(typeof this.eventSourceQuestions !== 'string') {
        this.eventSourceQuestions.close();
    }
    if(typeof this.eventSourceAnswers !== 'string') {
        this.eventSourceAnswers.close();
    }
  }



  render() {
    const { question } = this.props;
    const {answer, winners} = this.state;
    if(question.ended &&  winners) {
      
      return (
        <>
          <p className="question-tag">Nos vainqueurs sont :</p>
          <div className="winners-global">
            {winners.map((winner,i) => {
              return (
                <>
                  <div className={`slideIn winners-global-view delay-${i}`} key={i.toString()}>{winner}</div>
                </>
              )
            })}
          </div>
        </> 
      )
    }
    if(!question.question) {
      return (
        <div className="question-global-message slideIn">
          La première question va bientôt arriver !
        </div>
      )
    }
    if(!question.answered) {
      return (
        <>
          <p className="question-tag">Question :</p>
          <p className="question-global slideIn">{question.question}</p>
        </>
      )
    } else {
      return (
        <>
          <p className="question-tag">Réponse :</p>
          {/* // The key is here to force the render of a new p, hence the css animation refresh */}
          <p className="question-global slideIn" key={+new Date()}>{ answer }</p>
        </>
      )
    }
  }
}
// == Export
export default Question;
