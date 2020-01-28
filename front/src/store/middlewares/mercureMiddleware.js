const mercureMiddleware = (store) => (next) => (action) => {
    next(action);
}

export default mercureMiddleware;