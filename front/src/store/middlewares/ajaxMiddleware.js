import { GET_PLAYER_INFOS } from "../reducer";

const ajaxMiddleware = (store) => (next) => (action) => {
  switch (action.type) {
    case GET_PLAYER_INFOS:
        // Requête pour récupérer les infos player
      break;
    default:
      next(action);
  }
};

export default ajaxMiddleware;
