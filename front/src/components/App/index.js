/* eslint-disable react/prefer-stateless-function */
// == Import : npm
import React, { Component } from 'react';

// == Import : local
import './app.scss';
import { Switch, Route } from 'react-router-dom';
import ReduxToastr from 'react-redux-toastr';
import FirstTimeForm from '../FirstTimeForm';

class App extends Component {
  componentDidMount() {
    const { getPlayerInfos } = this.props;
    const token = localStorage.getItem('token');
    if (token) {
      getPlayerInfos();
    }
  }

  render() {
    const { player } = this.props;
    return (
      <>
        {/* <Header /> */}
        <ReduxToastr />
        <Switch>
          <Route exact path="/">
            Homepage
            { player === false && <FirstTimeForm /> }
          </Route>
        </Switch>
        {/* <Footer ? /> */}
      </>
    );
  }
}
// == Export
export default App;
