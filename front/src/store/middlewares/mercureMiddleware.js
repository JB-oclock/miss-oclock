import {MERCURE_SUBSCRIBE_STEPS } from '../reducer';

const mercureMiddleware = (store) => (next) => (action) => {
  switch (action.type) {
    case MERCURE_SUBSCRIBE_STEPS:
      const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);

      url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}${process.env.MERCURE_STEPS}`);
      const eventSource = new EventSource(url, { withCredentials: true });

      eventSource.onmessage = (e) => {
        // TODO : handle step events
        console.log(e);
      };
      next(action);
      break;
    default:
      next(action);
  }
}

export default mercureMiddleware;