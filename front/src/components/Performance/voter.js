// == Import : npm
import React, { Component } from 'react';
import { mercureSubscribe } from 'src/helpers';

class Voter extends Component {

  componentDidMount() {
    this.eventSource = '';
    this.listenProps();
  }


  state = {
    answer: '',
    answered: false

  }


  listenProps = () => {
    const {app, setPerformance, endPerformance} = this.props;
    
    this.eventSource = mercureSubscribe(`missoclock/performances/${app.gameId}/props`);
    
    this.eventSource.onmessage = (event) => {
      const { performance, ended } = JSON.parse(event.data);

      if(performance ){
        setPerformance(performance);
        if(this.state.answered == true) {
          this.setState({
            answered: performance.answered,
          })
        }
      }

      if(ended) {
        endPerformance();
      }
    };
  }

  componentWillUnmount(){
    if(typeof this.eventSource !== 'string') {
        this.eventSource.close();
    }
  }


  handleInput = (e) => {
    this.setState({
      answer: e.target.value,
    })
  }

  handleSubmit = (e) => {
    e.preventDefault(); 

    const {answerPerformance} = this.props;
    const {answer} = this.state;

    answerPerformance(answer);
    this.setState({
      answered: true,
    })
    
  }


  componentWillUpdate(nextProps, nextState){
    
    const { answered } = nextProps.performance;
    const { answer} = this.state;
    
    if(answered && answer.length){
      this.setState({
        answer: '',
      })
    }
    
  }

  getAnswers = () => {
    const {answers} = this.props.performance;

    const inputs = [];

    answers.forEach((answer, id) => {
      inputs.push(<div className="fake-checkboxes"><input id={'answer_'+id} onChange={this.handleInput} type="radio" name="answer" value={answer} /><label className="input-btn" key={id} htmlFor={'answer_'+id}><span className='dot'></span><span>{answer}</span></label></div>);
      
    });
 
    return inputs;
  }

  render() {

    const {performance} = this.props;
    if(performance.ended) {
      return (
        <div className="voter-message message">
          Merci d'avoir participé ! <br />On a encore besoin de toi pour la finale !
        </div>
      );
    }
    else if(!performance.answered) {
        if(performance.performanceId == 0) {
          return (
            <div className="voter-message message">
              Un peu de patience, tu vas bientôt pouvoir voter !
            </div>
          );
        } else {
            return (
                <form onSubmit={this.handleSubmit}>
                    <h2 className="question">{performance.performance}</h2>
                    { this.getAnswers() }
                    <button type="submit">Valider la réponse</button>
                </form>
            );
        }
    }
    else if (performance.last) {
      return (
        <div className="voter-message message">
          Merci d'avoir participé ! Les résultats vont bientôt arriver !
        </div>
      );
    }
    else {
      let message;
      if(this.state.answered) {
        message = "Merci d'avoir répondu !";
      } else {
        message = "Dommage, essaie de répondre plus vite !"
      }

      return (
        <div className="voter-message message">
          {message}
        </div>
      );
    }
  }
}
// == Export
export default Voter;
