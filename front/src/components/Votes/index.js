// == Import : npm
import React, { Component } from 'react';
import { mercureSubscribe } from 'src/helpers';
import AjaxButton from '../AjaxButton';

class Votes extends Component {

  componentDidMount() {
    this.eventSource = '';
    this.listenProps();
  }


  state = {
    answer: '',
  }


  listenProps = () => {
    const {app,setVotes, setGameWinner} = this.props;
    
    this.eventSource = mercureSubscribe(`missoclock/votes/${app.gameId}`);
    
    this.eventSource.onmessage = (event) => {
        const { votes, winner } = JSON.parse(event.data);
        
        if(votes){
            setVotes(votes);
        }
        if(winner) {
          setGameWinner(winner);
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

    const { sendVote } = this.props;
    const {answer} = this.state;

    sendVote(answer);
    
  }


  componentWillUpdate(nextProps, nextState){
    
    const { answered } = nextProps.votes;
    const { answer} = this.state;
    
    if(answered && answer.length){
      this.setState({
        answer: '',
      })
    }
    
  }

  getAnswers = () => {
    const {answers} = this.props.votes;

    const inputs = [];

    answers.forEach((answer, id) => {
      inputs.push(<div className="fake-checkboxes"><input id={'answer_'+id} onChange={this.handleInput} type="radio" name="answer" value={answer.id} /><label className="input-btn" key={id} htmlFor={'answer_'+id}><span className='dot'></span><span>{answer.name}</span></label></div>);

    });
 
    return inputs;
  }

  render() {

    const {votes, app} = this.props;
    if(votes.ended) {
      return (
        <div className="vote-message message">
          Merci d'avoir participé ! On a encore besoin de toi pour la finale !
        </div>
      );
    }
    else if(!votes.answered) {
        if(!votes.started) {
          return (
            <div className="vote-message message">
              Écoute bien nos finalistes, tu pourras agir juste après !
            </div>
          );
        } else {
            return (
                <form onSubmit={this.handleSubmit}>
                    <h2 className="question">Qui devrait être Miss O'clock ?</h2>
                    { this.getAnswers() }
                    <AjaxButton app={app}></AjaxButton>
                </form>
            );
        }
    }

    else {
      return (
        <div className="vote-message message">
          Merci d'avoir répondu !
        </div>
      );
    }
  }
}
// == Export
export default Votes;
