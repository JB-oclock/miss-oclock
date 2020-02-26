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
    const {app, setPerformance} = this.props;
    
    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}missoclock/performances/${app.gameId}/performer/${app.player.playerId}.jsonld`);
    const eventSource = new EventSource(url, { withCredentials: true });
    
    eventSource.onmessage = (event) => {
      const { performance, winners } = JSON.parse(event.data);
      
      if(performance){
        setPerformance(performance);
      }

      // if(winners){
      //   const isWinner = winners.indexOf(app.player.name) !== -1;
        
      //   setWinner(isWinner);
      //   endQuestions();
      // }
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
    const { performance } = this.props;
    const { mission } = this.state;
    if(!performance.title) {
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
