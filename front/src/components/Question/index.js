// == Import : npm
import React, { Component } from 'react';
import { mercureSubscribe } from 'src/helpers';
import AjaxButton from '../../containers/AjaxButton';


class Question extends Component {
  componentDidMount() {
    this.eventSource = '';
    this.listenQuestions();
  }

  state = {
    answer: '',
    notAnswered: true
  }

  listenQuestions = () => {
    const {app, setQuestion, setWinner, endQuestions, setAnswered } = this.props;
    
    this.eventSource = mercureSubscribe(`${process.env.MERCURE_QUESTIONS}${app.gameId}`);
    
    this.eventSource.onmessage = (event) => {
      const { questions, winners, endQuestion } = JSON.parse(event.data);
      if(questions){
        setQuestion(questions);
        this.setState({
          notAnswered: true,
        })
      }

      if(winners){
        const isWinner = winners.indexOf(app.player.name) !== -1;
        
        setWinner(isWinner);
        endQuestions();
      }

      if(endQuestion) {
        setAnswered();
      }
    };
  }

  componentWillUnmount(){
    if(typeof this.eventSource !== 'string') {
        this.eventSource.close();
    }
  }

  getAnswers = () => {
    const {answers} = this.props.question;

    const inputs = [];

    answers.forEach((answer, id) => {
      inputs.push(<div className="fake-checkboxes"><input id={'answer_'+id} onChange={this.handleInput} type="radio" name="answer" value={answer} /><label className="input-btn" key={id} htmlFor={'answer_'+id}><span className='dot'></span><span>{answer}</span></label></div>);
    });
 
    return inputs;
  }
  handleInput = (e) => {
    this.setState({
      answer: e.target.value,
    })
  }
  handleSubmit = (e) => {
    e.preventDefault(); 

    const {answerQuestion} = this.props;
    const {answer} = this.state;

    answerQuestion(answer);   
    this.setState({
      notAnswered: false,
    })
  }


  componentWillUpdate(nextProps, nextState){
    
    const { answered } = nextProps.question;
    const { answer} = this.state;
    
    if(answered && answer.length){
      this.setState({
        answer: '',
      })
    }
    
  }
  render() {
    const { question, app } = this.props;
    
    if(question.ended) {
      if(app.step_1_winner){
        return (
          <>
            <h2 className="success-title">Bravo !</h2>
            <div className="question-message message">
              <strong>Tu as gagné cette étape !</strong> <br/> Mais ne pense pas que tout est fini !
            </div>
          </>
        )
      } else {
        return (
          <>
            <h2 className="success-title">Dommage...</h2>
            <div className="question-message message">
              Tu n'as pas gagné durant cette étape.<br/> Mais reste avec nous, on aura besoin de toi pour la suite !
            </div>
          </>
        )
      }
    }
    else if(!question.answered) {
        if(question.questionId == 0) {
            return (
              <div className="question-message message">
                La première question va bientôt arriver !
              </div>
            )
        } else {
            return (
                <form onSubmit={this.handleSubmit}>
                    <h2 className="question">{question.question}</h2>
                    { this.getAnswers() }
                    <AjaxButton></AjaxButton>
                </form>
            );
        }
    }
    else if (question.last) {
      return (
        <div className="question-message message">
          C'était la dernière question, les résultats vont bientôt arriver !
        </div>
      )
    }
    else {
      let message;
      if(this.state.notAnswered) {
        message = "Dommage, essaie de répondre plus vite !"
      } else {
        message = "Merci d'avoir répondu, la prochaine question arrive tout bientôt !";
      }
      return (
        <div className="question-message message">
          {message}
        </div>
      )
    }
  }
}
// == Export
export default Question;
