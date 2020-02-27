import { connect } from 'react-redux';

import Voter from 'src/components/Performance/voter';
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

const VoterContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Voter);

export default VoterContainer;