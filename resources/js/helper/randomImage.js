export const randomImg = () => {
    const img = [
        "01.webp",
        "02.webp",
        "03.webp",
        // "04.webp",
        // "05.webp",
        // "06.webp",
        // "07.webp",
        // "08.webp",
        // "09.webp",
        // "10.webp",
    ];

    const random = Math.floor(Math.random() * img.length);
    return `/random/${img[random]}`;
};
