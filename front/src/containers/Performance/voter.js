import { connect } from 'react-redux';

import Voter from 'src/components/Performance/voter';


const mapStateToProps = (state) => ({
  performance: state.performances,
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
});

const VoterContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Voter);

export default VoterContainer;