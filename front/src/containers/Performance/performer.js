import { connect } from 'react-redux';

import Performer from 'src/components/Performance/performer';
import { setPerformance, endPerformance } from 'src/store/performancesReducer';
import {setStep2Winner } from 'src/store/reducer';



const mapStateToProps = (state) => ({
    performance: state.performances,
    app: state.app
});

const mapDispatchToProps = (dispatch) => ({
    setPerformance: (performance) => {
        dispatch(setPerformance(performance));
    },
    setWinner: (winner) => {
        dispatch(setStep2Winner(winner));
    },
    endPerformance: () => {
        dispatch(endPerformance());
    },
});

const PerformerContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Performer);

export default PerformerContainer;