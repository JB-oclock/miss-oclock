import React, { Component } from 'react';
import { withRouter } from 'react-router-dom';
import LoadingScreen from '../../components/LoadingScreen';
import Question from '../../containers/GlobalView/Question';

class GlobalView extends Component {

    componentDidMount() {
        
        let { code } = this.props.match.params;
        let { getGameDataGlobal } = this.props;
        getGameDataGlobal(code);
    }

    render() {
        const { player, loading, waiting, step, winner } = this.props;

        return (
            <>
              { step == 0 && <LoadingScreen  />}
              { step == 1 && <Question  />}
              { step == 2 && <LoadingScreen  />}
            </>
        );
    }
}

export default withRouter(GlobalView);
