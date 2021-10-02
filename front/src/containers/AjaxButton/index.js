import { connect } from 'react-redux';

import AjaxButton from 'src/components/AjaxButton';


const mapStateToProps = (state) => ({
  app: state.app
});

const mapDispatchToProps = (dispatch) => ({
 
});

const AjaxButtonContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(AjaxButton);

export default AjaxButtonContainer;
