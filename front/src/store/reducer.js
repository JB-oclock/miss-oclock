/** 
 * Initial State
 */

export const initialState = {
  player: false,
  game: {
    step: 0,
  },
};

/**
 * Types
 */

//   export const TYPE_NAME = 'TYPE_NAME';
export const SET_PLAYER = 'SET_PLAYER';
export const GET_PLAYER_INFOS = 'GET_PLAYER_INFOS';


/**
 * Action creators
 */

// export const actionExample = (storeElement) => ({
//     type: TYPE_NAME,
//     storeElement
// });
export const setPlayer = (player) => ({
  type: SET_PLAYER,
  player,
});

export const getPlayerInfos = () => ({
  type: GET_PLAYER_INFOS,
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
        player: action.player,
      };

    default:
      return state;
  }
};

export default reducer;
