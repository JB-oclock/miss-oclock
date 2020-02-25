import { connect } from 'react-redux';

import Performance from 'src/components/Performance';


const mapStateToProps = (state) => ({
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
 
});

const PerformanceContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Performance);

export default PerformanceContainer;