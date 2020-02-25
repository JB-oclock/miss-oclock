// == Import : npm
import React, { Component } from 'react';
class Voter extends Component {


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
    if(performance.ended) {
      if(app.step_2_winner){
        return "Tu as gagné cette étape ! Mais ne pense pas que tout est fini !";
      } else {
        return "Tu n'as pas gagné durant cette étape. Mais reste avec nous, on aura besoin de toi pour la suite !";
      }
    }
    else if(!performance.answered) {
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
      return "Merci d'avoir répondu ! C'était la dernière question, les résultats vont bientôt arriver !";
    }
    else {
        return "Merci d'avoir répondu, la prochaine question arrive bientôt !";
    }
  }
}
// == Export
export default Voter;
