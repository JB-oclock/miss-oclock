/* eslint-disable react/prefer-stateless-function */
// == Import : npm
import React, { Component } from 'react';

// == Import : local
import './app.scss';
import { Switch, Route } from 'react-router-dom';
import ReduxToastr from 'react-redux-toastr';
import FirstTimeForm from '../FirstTimeForm';
import Waiting from '../Waiting';

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
    const { player, loading, waiting } = this.props;
    return (
      <>
        {/* <Header /> */}
        <ReduxToastr />
        <Switch>
          <Route exact path="/">
            {!loading && !player && <FirstTimeForm />}
            {waiting && <Waiting />}
          </Route>
        </Switch>
        {/* <Footer ? /> */}
      </>
    );
  }
}
// == Export
export default App;
