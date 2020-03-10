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


class App extends Component {

  componentDidMount() {
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
          <header>
            <h1>Miss O'clock</h1>
          </header>
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
            </Switch>
          </main>
        </div>
        
      </>
    );
  }
}
// == Export
export default App;
