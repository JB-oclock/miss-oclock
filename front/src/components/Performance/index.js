// == Import : npm
import React, { Component } from 'react';
import Performer from '../../containers/Performance/performer';
import Voter from '../../containers/Performance/voter';
class Performance extends Component {

  render() {
    const { step_1_winner } = this.props.app;
    return (
        <>
            { step_1_winner &&  <Performer />}
            { !step_1_winner &&  <Voter />}
        </>
    );
  }
}
// == Export
export default Performance;
