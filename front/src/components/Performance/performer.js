// == Import : npm
import React, { Component } from 'react';
class Performer extends Component {
  componentDidMount() {
    this.eventSource = '';
    this.listenPerformances();
  }

  state = {
    mission: false,
  }

  listenPerformances = () => {
    const {app, setPerformance, setWinner, endPerformance} = this.props;
    
    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}missoclock/performances/${app.gameId}/performer/${app.player.playerId}.jsonld`);
    const eventSource = new EventSource(url, { withCredentials: true });
    
    eventSource.onmessage = (event) => {
      const { performance, winner } = JSON.parse(event.data);
      
      if(performance){
        setPerformance(performance);
        this.setState({
          mission:false,
        })
      }

      if(winner){
        setWinner(winner);
        endPerformance();
      }
    };
  }

  toggleMission = () => {
    this.setState(prevState => ({
      mission: !prevState.mission,
    }))
  }
  componentWillUnmount(){
    if(typeof this.eventSource !== 'string') {
      this.eventSource.close();
    }
  }
  render() {
    const { performance, app } = this.props;
    const { mission } = this.state;

    if(performance.ended) {
      if(app.step_2_winner){
        return "Tu as gagné cette étape ! Place à la finale !";
      } else {
        return "Tu n'as pas gagné durant cette étape. Mais reste avec nous, on aura besoin de toi pour la finale !";
      }
    }
    else if(!performance.title) {
      return (
        "Vos instructions arrivent bientôt !"
      );
    } else {
      return (
        <>
          <p>Votre mission si vous l'acceptez sera de dessiner le mot ou expression qui sera dévoilé en cliquant ci-dessous.</p>
          <span onClick={this.toggleMission} className="fake-btn btn">Dévoiler la mission.</span>
          <div className="mission">
            { mission && performance.title}
          </div>
        </>
      )
    }
  }
}
// == Export
export default Performer;
