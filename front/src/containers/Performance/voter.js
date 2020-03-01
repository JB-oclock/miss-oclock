import { connect } from 'react-redux';

import Voter from 'src/components/Performance/voter';
import { setPerformance, answerPerformance, endPerformance } from 'src/store/performancesReducer';



const mapStateToProps = (state) => ({
  performance: state.performances,
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
  setPerformance: (performance) => {
    dispatch(setPerformance(performance));
  },
  answerPerformance: (answer) => {
    dispatch(answerPerformance(answer))
  },
  endPerformance: () => {
    dispatch(endPerformance());
  },
});

const VoterContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Voter);

export default VoterContainer;