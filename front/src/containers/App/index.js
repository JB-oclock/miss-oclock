import { connect } from 'react-redux';

import App from 'src/components/App';
import { getPlayerInfos, stopLoading } from 'src/store/reducer';

const mapStateToProps = (state) => ({
  player: state.app.player,
  loading: state.app.loading,
  waiting: state.app.waiting,
  step: state.app.gameStep,
});

const mapDispatchToProps = (dispatch) => ({
  getPlayerInfos: () => {
    dispatch(getPlayerInfos());
  },
  stopLoading: () => {
    dispatch(stopLoading());
  },
});

const AppContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(App);

export default AppContainer;