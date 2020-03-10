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
        return (
          <div className="performer-message message">
            <strong>Tu as gagné cette étape !</strong> Place à la finale !
          </div>
        );
      } else {
        return (
          <div className="performer-message message">
            Tu n'as pas gagné durant cette étape. Mais reste avec nous, on aura besoin de toi pour la finale !
          </div>
        );
      }
    }
    else if(!performance.title) {
      return (
        <div className="performer-message message">
          Vos instructions arrivent bientôt !
        </div>
      );
    } else {
      return (
        <>
          <div className="performer-message message">
            <p>Votre mission si vous l'acceptez sera de dessiner le mot ou expression qui sera dévoilée en cliquant ci-dessous.</p>
          </div>
          <span onClick={this.toggleMission} className="fake-btn btn">Dévoiler la mission.</span>
          <div className={"mission" + (mission ? ' message' : '' )}>
              { mission && performance.title}
            </div>
        </>

      )
    }
  }
}
// == Export
export default Performer;
