import React, { Component } from 'react';
import { withRouter } from 'react-router-dom';
import LoadingScreen from '../../components/LoadingScreen';
import Performance from '../../containers/GlobalView/Performance';
import Question from '../../containers/GlobalView/Question';

class GlobalView extends Component {

    componentDidMount() {
        
        let { code } = this.props.match.params;
        let { getGameDataGlobal } = this.props;
        getGameDataGlobal(code);
    }

    render() {
        const {  step } = this.props;

        return (
            <>
              { step == 0 && <LoadingScreen  />}
              { step == 1 && <Question  />}
              { step == 2 && <Performance  />}
              { step == 3 && <LoadingScreen  />}
            </>
        );
    }
}

export default withRouter(GlobalView);
