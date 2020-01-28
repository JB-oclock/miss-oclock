/** 
 * Initial State
 */

 export const initialState = {
    player: false
 };

/**
 * Types
 */

//   export const TYPE_NAME = 'TYPE_NAME';
  export const SET_PLAYER = 'SET_PLAYER';


/**
 * Action creators
 */

// export const actionExample = (storeElement) => ({
//     type: TYPE_NAME,
//     storeElement
// });
export const setPlayer = (player) => ({
    type: SET_PLAYER,
    player
});

/**
 * Reducer
 */

 const reducer = (state = initialState, action = {}) => {
     switch (action.type) {
        // case TYPE_NAME:
        //     return {
        //         ...state,
        //         element: action.storeElement
        //     };
        case SET_PLAYER:
            return {
                ...state,
                player: action.player
            };
        default:
            return state;
     }
 }

 export  default reducer;