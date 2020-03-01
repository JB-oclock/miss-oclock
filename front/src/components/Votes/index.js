// == Import : npm
import React, { Component } from 'react';
class Votes extends Component {

  componentDidMount() {
    this.eventSource = '';
    this.listenProps();
  }


  state = {
    answer: '',
  }


  listenProps = () => {
    const {app,setVotes} = this.props;
    
    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}missoclock/votes/${app.gameId}.jsonld`);
    const eventSource = new EventSource(url, { withCredentials: true });
    
    eventSource.onmessage = (event) => {
        const { votes } = JSON.parse(event.data);
        
        if(votes){
            setVotes(votes);
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
      inputs.push(<label  key={id} htmlFor={'answer_'+id}><input id={'answer_'+id} onChange={this.handleInput} type="radio" name="answer" value={answer.id} />{answer.name}</label>);
    });
 
    return inputs;
  }

  render() {

    const {votes} = this.props;
    if(votes.ended) {
      return "Merci d'avoir participé ! On a encore besoin de toi pour la finale !";
    }
    else if(!votes.answered) {
        if(!votes.started) {
            return "Écoute bien nos finalistes, tu pourras agir juste après !";
        } else {
            return (
                <form onSubmit={this.handleSubmit}>
                    <h2>Qui devrait être Miss O'clock ?</h2>
                    { this.getAnswers() }
                    <button type="submit">Valider la réponse</button>
                </form>
            );
        }
    }

    else {
        return "Merci d'avoir répondu !";
    }
  }
}
// == Export
export default Votes;
