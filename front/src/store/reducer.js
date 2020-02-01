/** 
 * Initial State
 */

export const initialState = {
  loading: true,
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
const STOP_LOADING = 'STOP_LOADING';

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

export const stopLoading = () => ({
  type: STOP_LOADING,
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
    case STOP_LOADING:
      return {
        ...state,
        loading: false,
      };

    default:
      return state;
  }
};

export default reducer;
