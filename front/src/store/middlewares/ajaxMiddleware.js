import Axios from 'axios';
import { GET_PLAYER_INFOS, setPlayer, stopLoading, waiting, mercureSubscribeSteps, setGameId, getGameData, GET_GAME_DATA, setGameStep } from '../reducer';

const ajaxMiddleware = (store) => (next) => (action) => {
  const token = `Bearer ${localStorage.getItem('token')}`;
  switch (action.type) {
    case GET_PLAYER_INFOS:
      Axios.get(`${process.env.API_DOMAIN}get-infos`, {
        headers: {
          Authorization: token,
        },
      }).then((response) => {
        const player = {
          token: localStorage.getItem('token'),
          ...response.data,
        };
        store.dispatch(setPlayer(player));
        store.dispatch(getGameData());
      });
      break;
      case GET_GAME_DATA: 
      Axios.get(`${process.env.API_DOMAIN}game-data`, {
        headers: {
          Authorization: token,
        },
      }).then((response) => {
          const {gameId, gameStep} = response.data;
          
        store.dispatch(setGameId(gameId));
        store.dispatch(setGameStep(gameStep));
        store.dispatch(mercureSubscribeSteps());

        store.dispatch(stopLoading());
        store.dispatch(waiting());
    });
      break;  
    default:
      next(action);
  }
};

export default ajaxMiddleware;
