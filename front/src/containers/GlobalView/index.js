import { connect } from 'react-redux';

import GlobalView from '../../components/GlobalView';
import {  setGameId, getGameDataGlobal, setGameWinner } from 'src/store/reducer';


const mapStateToProps = (state) => ({
  player: state.app.player,
  loading: state.app.loading,
  waiting: state.app.waiting,
  step: state.app.gameStep,
  code: state.app.code,
  winner: state.app.step_3_winner
});

const mapDispatchToProps = (dispatch) => ({

  setGameId: () => {
    dispatch(setGameId());
  },
  getGameDataGlobal: (id) => {
    dispatch(getGameDataGlobal(id));
  },

});

const GlobalViewContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(GlobalView);

export default GlobalViewContainer;