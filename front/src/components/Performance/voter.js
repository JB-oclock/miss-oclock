// == Import : npm
import React, { Component } from 'react';
class Voter extends Component {

  componentDidMount() {
    this.eventSource = '';
    this.listenProps();
  }



  listenProps = () => {
    const {app, setPerformance} = this.props;
    
    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}missoclock/performances/${app.gameId}/props.jsonld`);
    const eventSource = new EventSource(url, { withCredentials: true });
    
    eventSource.onmessage = (event) => {
      const { performance } = JSON.parse(event.data);
      
      if(performance){
        setPerformance(performance);
      }
    };
  }

  getAnswers = () => {
    const {answers} = this.props.performance;

    const inputs = [];

    answers.forEach((answer, id) => {
      inputs.push(<label  key={id} htmlFor={'answer_'+id}><input id={'answer_'+id} onChange={this.handleInput} type="radio" name="answer" value={answer} />{answer}</label>);
    });
 
    return inputs;
  }

  render() {

    const {performance} = this.props;
    if(!performance.answered) {
        if(performance.performanceId == 0) {
            return "La première épreuve va bientôt arriver !";
        } else {
            return (
                <form onSubmit={this.handleSubmit}>
                    <h2>{performance.performance}</h2>
                    { this.getAnswers() }
                    <button type="submit">Valider la réponse</button>
                </form>
            );
        }
    }
    else if (performance.last) {
      return "Merci d'avoir répondu ! Les résultats vont bientôt arriver !";
    }
    else {
        return "Merci d'avoir répondu, la prochaine épreuve arrive bientôt !";
    }
  }
}
// == Export
export default Voter;
