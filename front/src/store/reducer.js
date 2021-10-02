/** 
 * Initial State
 */

export const initialState = {
  loading: true,
  waiting: false,
  player: false,
  gameId: 0,
  gameStep: 0,
  code: '',
  step_1_winner: false,
  step_2_winner: false,
  step_3_winner: false,
  waiting_ajax: false
};

/**
 * Types
 */

export const SET_PLAYER = 'SET_PLAYER';
export const SET_GAME_ID = 'SET_GAME_ID';
export const SET_GAME_STEP = 'SET_GAME_STEP';
export const SET_CODE = 'SET_CODE';
export const SET_GAME_WINNER = 'SET_GAME_WINNER';
export const GET_PLAYER_INFOS = 'GET_PLAYER_INFOS';
export const GET_GAME_DATA = 'GET_GAME_DATA';
export const GET_GAME_DATA_GLOBAL = 'GET_GAME_DATA_GLOBAL';
export const MERCURE_SUBSCRIBE_STEPS = 'MERCURE_SUBSCRIBE_STEPS';
const STOP_LOADING = 'STOP_LOADING';
const WAITING_AJAX = 'WAITING_AJAX';
const STOP_WAITING_AJAX = 'STOP_WAITING_AJAX';
const WAITING_STEP = 'WAITING_STEP';
const SET_STEP_1_WINNER = 'SET_STEP_1_WINNER';
const SET_STEP_2_WINNER = 'SET_STEP_2_WINNER';
const STOP_WAITING_STEP = 'STOP_WAITING_STEP';

/**
 * Action creators
 */


export const setPlayer = (player) => ({
  type: SET_PLAYER,
  player,
});

export const setGameId = (id) => ({
  type: SET_GAME_ID,
  id,
});

export const setCode = (code) => ({
  type: SET_CODE,
  code,
});

export const setGameStep = (step) => ({
  type: SET_GAME_STEP,
  step,
});
export const setGameWinner = (winner) => ({
  type: SET_GAME_WINNER,
  winner,
});

export const setStep1Winner = (winner) => ({
  type: SET_STEP_1_WINNER,
  winner,
});
export const setStep2Winner = (winner) => ({
  type: SET_STEP_2_WINNER,
  winner,
});
export const getPlayerInfos = () => ({
  type: GET_PLAYER_INFOS,
});

export const getGameData = () => ({
  type: GET_GAME_DATA,
});

export const getGameDataGlobal = (id) => ({
  type: GET_GAME_DATA_GLOBAL,
  id,
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

export const waitingAjax = () => ({
  type: WAITING_AJAX,
});
export const stopWaitingAjax = () => ({
  type: STOP_WAITING_AJAX,
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
    case SET_GAME_ID:
      return {
        ...state,
        gameId: action.id,
      };
    case SET_GAME_STEP:
      return {
        ...state,
        gameStep: action.step,
      };
    case SET_CODE:
      return {
        ...state,
        code: action.code,
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
    case WAITING_AJAX:
      return {
        ...state,
        waiting_ajax: true,
      };
    case STOP_WAITING_AJAX:
      return {
        ...state,
        waiting_ajax: false,
      };
    case SET_STEP_1_WINNER:
      return {
        ...state,
        step_1_winner: action.winner
      }
    case SET_STEP_2_WINNER:
      return {
        ...state,
        step_2_winner: action.winner,
      }
    case SET_GAME_WINNER:
      return {
        ...state,
        step_3_winner: action.winner,
      }
    default:
      return state;
  }
};

export default reducer;
