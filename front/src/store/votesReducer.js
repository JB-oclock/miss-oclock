
export const initialState = {
    title: '',
    started:false,
    answers: [],
    answered: false, 
    ended: false,
  };
  

const SET_VOTES = 'SET_VOTES';
export const SEND_VOTE = 'SEND_VOTE';


/**
 * Action creators
 */



export const setVotes = (votes) => ({
  type: SET_VOTES,
  votes,
});

export const sendVote = (vote) => ({
  type: SEND_VOTE,
  vote,
});


/**
 * Reducer
 */

const reducer = (state = initialState, action = {}) => {
    switch (action.type) {
      case SET_VOTES :
          return {
            ...state,
            ...action.votes,
          };
        break;

      default:
        return state;
    }
  };
  
export default reducer;
  