
export const initialState = {
    questionId: 0,
    question: '',
    answers: [],
    answered: false, 
  };
  

/**
 * Reducer
 */

const reducer = (state = initialState, action = {}) => {
    switch (action.type) {
      default:
        return state;
    }
  };
  
export default reducer;
  