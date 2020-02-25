import { connect } from 'react-redux';

import Performer from 'src/components/Performance/performer';


const mapStateToProps = (state) => ({
});

const mapDispatchToProps = (dispatch) => ({
 
});

const PerformerContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Performer);

export default PerformerContainer;