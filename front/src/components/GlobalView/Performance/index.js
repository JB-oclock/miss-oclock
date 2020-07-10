import React, { Component } from 'react';
import { mercureSubscribe } from 'src/helpers';

class Performance extends Component {

    componentDidMount() {
        this.eventSource = '';
        this.listenEvents();
      }

    state = {
        winners: [],
    }


    listenEvents = () => {
        const {app, endPerformance} = this.props;
        
        this.eventSource = mercureSubscribe(`missoclock/performances/${app.gameId}/props`);
        
        this.eventSource.onmessage = (event) => {
          const { ended, winners } = JSON.parse(event.data);
          
          if (winners){
              console.log(winners);
              
            this.setState({
                winners
            });
          }
          if(ended) {
            endPerformance();
          }
        };
      }
    
    render() {
        const { performance } = this.props;
        const { winners } = this.state;

        if(!performance.ended) {
            return (
                <div className="global-view-title slideIn">L'art</div>
            )
        } else {
            return (
                <>
                  <p className="result-tag performance-title">Nos vainqueurs sont :</p>
                  <div className="winners-global">
                    {winners.map((winner,i) => {
                      return (
                        <>
                          <div className={`slideIn winners-global-view delay-${i}`} key={i.toString()}>{winner}</div>
                        </>
                      )
                    })}
                  </div>
                </> 
              )
        }
    }
}

export default Performance;
