import { connect } from 'react-redux';

import Performance from 'src/components/GlobalView/Performance';
import { endPerformance } from 'src/store/performancesReducer';



const mapStateToProps = (state) => ({
  performance: state.performances,
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
  endPerformance: () => {
    dispatch(endPerformance());
  },
});

const PerformanceContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Performance);

export default PerformanceContainer;