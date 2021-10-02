import React, { Component } from "react";


class AjaxButton extends Component {
  
  sendingMessage = (message) => {
    let spannedMessage = [];

    for (const letter of message) {
      if(letter === " ") {
        spannedMessage.push(letter);
      } else {
        spannedMessage.push(<span>{letter}</span>);
      }
    }
    
    return spannedMessage;
  }

  render() {
    const { app } = this.props;
    return (
      <button type="submit" className={(app.waiting_ajax) ? "waiting-button" : ""} disabled={app.waiting_ajax}>{ !app.waiting_ajax ? "Valider la réponse" : this.sendingMessage("Envoi en cours") }</button>
    )
  }

}

export default AjaxButton;
