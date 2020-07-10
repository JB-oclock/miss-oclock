export const mercureSubscribe = (subscribeUrl) => {
    const url = new URL(`${process.env.MERCURE_DOMAIN}${process.env.MERCURE_HUB}`);
    url.searchParams.append('topic', `${process.env.MERCURE_DOMAIN}${subscribeUrl}.jsonld`);
    
    return new EventSource(url, { withCredentials: true });
}