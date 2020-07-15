import { connect } from 'react-redux';

import Votes from 'src/components/Votes';
import { setVotes, sendVote } from 'src/store/votesReducer';
import { setGameWinner } from 'src/store/reducer';



const mapStateToProps = (state) => ({
  app: state.app,
  votes: state.votes
});

const mapDispatchToProps = (dispatch) => ({
    setVotes: (votes) => {
      dispatch(setVotes(votes));
    },
    sendVote: (vote) => {
      dispatch(sendVote(vote));
    },
    setGameWinner: (winner) => {
      dispatch(setGameWinner(winner));
    }
});

const VotesContainer = connect(
  mapStateToProps,
  mapDispatchToProps,
)(Votes);

export default VotesContainer;