import Axios from 'axios';
import { GET_PLAYER_INFOS, setPlayer, stopLoading } from '../reducer';

const ajaxMiddleware = (store) => (next) => (action) => {
  switch (action.type) {
    case GET_PLAYER_INFOS:
      const token = `Bearer ${localStorage.getItem('token')}`;
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
        store.dispatch(stopLoading());
      });
      break;
    default:
      next(action);
  }
};

export default ajaxMiddleware;
