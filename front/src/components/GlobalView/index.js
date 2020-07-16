import React, { Component } from 'react';
import { withRouter } from 'react-router-dom';
import LoadingScreen from '../../components/LoadingScreen';
import End from '../../components/End';
import Speech from '../../containers/GlobalView/Speech';
import Performance from '../../containers/GlobalView/Performance';
import Question from '../../containers/GlobalView/Question';


class GlobalView extends Component {

    componentDidMount() {
        
        let { code } = this.props.match.params;
        let { getGameDataGlobal } = this.props;
        getGameDataGlobal(code);
    }

 

    render() {
        const {  step, winner } = this.props;

        return (
            <>
              { step == 0 && <LoadingScreen  />}
              { step == 1 && <Question  />}
              { step == 2 && <Performance  />}
              { step == 3 && !winner && <Speech  />}
              { step == 3 && winner && <End winner={winner} view='global' />}
            </>
        );
    }
}

export default withRouter(GlobalView);
