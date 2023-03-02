export const ConvertDate = (timesTamps) => {
    const t = timesTamps.replace("/[-]/g", "/");
    const date = Date.parse(t);
    return new Date(date);
};
