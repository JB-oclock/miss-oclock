import { connect } from 'react-redux';

import Speech from 'src/components/GlobalView/Speech';
import { setGameWinner } from 'src/store/reducer';



const mapStateToProps = (state) => ({
  app: state.app,
});

const mapDispatchToProps = (dispatch) => ({
    setGameWinner: (winner) => {
      dispatch(setGameWinner(winner));
    }
});

const SpeechContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Speech);

export default SpeechContainer;