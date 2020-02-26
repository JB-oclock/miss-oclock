import { connect } from 'react-redux';

import Performer from 'src/components/Performance/performer';
import { setPerformance } from 'src/store/performancesReducer';


const mapStateToProps = (state) => ({
    performance: state.performances,
    app: state.app
});

const mapDispatchToProps = (dispatch) => ({
    setPerformance: (performance) => {
        dispatch(setPerformance(performance));
    },
});

const PerformerContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Performer);

export default PerformerContainer;