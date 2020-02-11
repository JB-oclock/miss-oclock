
export const initialState = {
    questionId: 0,
    question: '',
    answers: [],
    answered: false, 
  };
  

const SET_QUESTION = 'SET_QUESTION';

/**
 * Action creators
 */


export const setQuestion = (question) => ({
  type: SET_QUESTION,
  question,
});


/**
 * Reducer
 */

const reducer = (state = initialState, action = {}) => {
    switch (action.type) {
      case SET_QUESTION :
          return {
            ...state,
            ...action.question,
          };
        break;
      default:
        return state;
    }
  };
  
export default reducer;
  