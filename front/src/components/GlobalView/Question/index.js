// == Import : npm
import React, { Component } from 'react';
import { answerQuestion, endQuestions } from '../../../store/questionsReducer';

class Question extends Component {
  componentDidMount() {
    this.eventSource = '';
    this.listenQuestions();
  }

  state = {
    answer: '',
  }

  listenQuestions = () => {
    const {app, setQuestion, setWinner, endQuestions } = this.props;
    
    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}${process.env.MERCURE_QUESTIONS}${app.gameId}.jsonld`);
    const eventSource = new EventSource(url, { withCredentials: true });
    
    eventSource.onmessage = (event) => {
      const { questions, winners } = JSON.parse(event.data);
      if(questions){
        setQuestion(questions);
      }

      if(winners){
        // const isWinner = winners.indexOf(app.player.name) !== -1;
        
        // setWinner(isWinner);
        // endQuestions();
      }
    };
  }

  componentWillUnmount(){
    if(typeof this.eventSource !== 'string') {
        this.eventSource.close();
    }
  }



  componentWillUpdate(nextProps, nextState){
    
    // const { answered } = nextProps.question;
    // const { answer} = this.state;
    
    // if(answered && answer.length){
    //   this.setState({
    //     answer: '',
    //   })
    // }
    
  }
  render() {
    const { question } = this.props;
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
    }
  }
}
// == Export
export default Question;
