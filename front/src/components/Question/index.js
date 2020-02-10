// == Import : npm
import React, { Component } from 'react';

// == Import : local

class Question extends Component {


  render() {
    const { questions } = this.props;
    console.log(questions);
    
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
