/** 
 * Initial State
 */

export const initialState = {
  loading: true,
  waiting: false,
  player: false,
  game: {
    step: 0,
  },
};

/**
 * Types
 */

export const SET_PLAYER = 'SET_PLAYER';
export const GET_PLAYER_INFOS = 'GET_PLAYER_INFOS';
export const MERCURE_SUBSCRIBE_STEPS = 'MERCURE_SUBSCRIBE_STEPS';
const STOP_LOADING = 'STOP_LOADING';
const WAITING_STEP = 'WAITING_STEP';
const STOP_WAITING_STEP = 'STOP_WAITING_STEP';

/**
 * Action creators
 */


export const setPlayer = (player) => ({
  type: SET_PLAYER,
  player,
});

export const getPlayerInfos = () => ({
  type: GET_PLAYER_INFOS,
});

export const mercureSubscribeSteps = () => ({
  type: MERCURE_SUBSCRIBE_STEPS,
});

export const stopLoading = () => ({
  type: STOP_LOADING,
});

export const waiting = () => ({
  type: WAITING_STEP,
});

export const stopWaiting = () => ({
  type: STOP_WAITING_STEP,
});

/**
 * Reducer
 */

const reducer = (state = initialState, action = {}) => {
  switch (action.type) {
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
    case WAITING_STEP:
      return {
        ...state,
        waiting: true,
      };
    case STOP_WAITING_STEP:
      return {
        ...state,
        waiting: false,
      };
    default:
      return state;
  }
};

export default reducer;
