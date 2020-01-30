import { connect } from 'react-redux';

import App from 'src/components/App';
import { getPlayerInfos } from 'src/store/reducer';

const mapStateToProps = (state) => ({
  player: state.app.player,
});

const mapDispatchToProps = (dispatch) => ({
  getPlayerInfos: () => {
    dispatch(getPlayerInfos());
  },
});

const AppContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(App);

export default AppContainer;