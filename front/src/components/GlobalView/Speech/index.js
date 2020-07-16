import React, { Component } from 'react';
import { mercureSubscribe } from 'src/helpers';


class Speech extends Component {
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
      const { winner } = JSON.parse(event.data);

      if (winner) {
        setGameWinner(winner);
      }
    };
  }
  render() {

    return (
      <div className="global-view-title slideIn">Le discours</div>
    )
  }
}

export default Speech;
