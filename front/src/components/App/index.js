// == Import : npm
import React, { Component } from 'react';

// == Import : local
import './app.scss';
import { Switch, Route } from 'react-router-dom';
import FirstTimeForm from '../FirstTimeForm';
import ReduxToastr from 'react-redux-toastr';

class App extends Component {
  render() {
    return (
      <>
      {/* <Header /> */}
      <ReduxToastr />
      <Switch>
        <Route exact path="/">
          Homepage
          <FirstTimeForm />
        </Route>
      </Switch>
      {/* <Footer ? /> */}
      </>
     );
  }
}
// == Export
export default App;
 