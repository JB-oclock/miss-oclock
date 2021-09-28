import React, { Component } from 'react';
import TextLoop from "react-text-loop";
import { mercureSubscribe } from 'src/helpers';


class Speech extends Component {
  constructor(props) {
    super(props);
    this.state = {roulette: false};
  }
  componentDidMount() {
          
      this.eventSource = '';
      this.listenEnd()

  }
  componentWillUnmount(){
    if(typeof this.eventSource !== 'string') {
        this.eventSource.close();
    }
  }


  listenEnd = () => {
    const { app, setGameWinner } = this.props;

    this.eventSource = mercureSubscribe(`missoclock/votes/${app.gameId}`);

    this.eventSource.onmessage = (event) => {
      const { winner, roulette } = JSON.parse(event.data);

      if(roulette) {
        this.setState(state => ({ roulette: true}));
      }
      if (winner) {
        setGameWinner(winner);
      }
    };
  }
  render() {

    return (
      <>
      { !this.state.roulette && <div className="global-view-title slideIn">Le débat</div>  }
      { this.state.roulette && 
        <div className="slideInUp roulette">

          <TextLoop className="slideInUp" interval="200">
            <span>Politique</span>
            <span>Santé</span>
            <span>Sécurité</span>
            <span>Immigration</span>
            <span>Emploi</span>
            <span>Chômage</span>
            <span>Avenir</span>
            <span>Environnement</span>
            <span>Ecologie</span>
          </TextLoop>  
        </div>
      }
      </>
    )
  }
}

export default Speech;
