/* eslint-disable react/prefer-stateless-function */
// == Import : npm
import React, { Component } from 'react';

// == Import : local
import './app.scss';
import { Switch, Route } from 'react-router-dom';
import ReduxToastr from 'react-redux-toastr';
import FirstTimeForm from '../FirstTimeForm';
import Waiting from '../Waiting';
import End from '../End';
import Question from '../../containers/Question';
import Performance from '../../containers/Performance';
import Votes from '../../containers/Votes';
import Header from '../Header';
import LoadingScreen from '../LoadingScreen';


class App extends Component {

  componentDidMount() {
    let root = document.querySelector('.root');
    root.classList.remove('root');
    const { getPlayerInfos, stopLoading } = this.props;
    const token = localStorage.getItem('token');
    if (token) {
      getPlayerInfos();
    }
    else {
      stopLoading();
    }
  }

  render() {
    const { player, loading, waiting, step, winner } = this.props;
    
    return (
      <>
        <div className={`mainWrapper  step-${step}`}>
          <ReduxToastr
          transitionIn="bounceInDown"
          transitionOut="fadeOut"
           />
           <Switch>
              <Route exact path="/">
                <Header step={step} view="player" />
              </Route>
              <Route path="/view/:code">
                <Header step={step} view="global" />
              </Route>
           </Switch>

          <main className="content">
            <Switch>
              <Route exact path="/">
                {!loading && !player && <FirstTimeForm />}
                {waiting && <Waiting />}
                {!waiting &&  step == 1 && <Question />}
                {!waiting &&  step == 2 && <Performance />}
                {!waiting &&  step == 3 && !winner && <Votes />}
                {!waiting &&  step == 3 && winner && <End winner={winner} />}
              </Route>
              <Route path="/view/:code">
                { step == 0 && <LoadingScreen  />}
              </Route>
            </Switch>
          </main>
        </div>
        
      </>
    );
  }
}
// == Export
export default App;
