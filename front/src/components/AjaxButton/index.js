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
    const { app, disabled, textContent } = this.props;
    return (
      <button type="submit" className={(app.waiting_ajax) ? "waiting-button" : ""} disabled={app.waiting_ajax || disabled}>{ !app.waiting_ajax ? textContent : this.sendingMessage("Envoi en cours") }</button>
    )
  }

}

AjaxButton.defaultProps = {
  disabled: false,
  textContent: "Valider la réponse"
}

export default AjaxButton;
