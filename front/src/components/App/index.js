// == Import : npm
import React, { Component } from 'react';

// == Import : local
import './app.scss';
import { Switch, Route } from 'react-router-dom';
import Code from '../Code';

class App extends Component {
  render() {
    return (
      // <Header />
      <Switch>
        <Route exact path="/">
          Homepage
          <Code />
        </Route>
      </Switch>
      // <Footer ? />
     );
  }
}
// == Export
export default App;
 