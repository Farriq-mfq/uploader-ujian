export const randomImg = () => {
    const img = [
        "01.webp",
        "02.webp",
        "03.webp",
        "04.webp",
        "05.webp",
        "06.webp",
        "07.webp",
        "08.webp",
        "09.webp",
        "10.webp",
        "11.webp",
        "12.webp",
        "13.webp",
        "14.webp",
        "15.webp",
        "16.webp",
        "17.webp",
        "18.webp",
        "19.webp",
        "20.webp",
        "21.webp",
        "22.webp",
        "23.webp",
        "24.webp",
        "25.webp",
        "26.webp",
        "27.webp",
        "29.webp",
        "30.webp",
        "31.webp",
        "32.webp",
        "33.webp",
    ];

    const random = Math.floor(Math.random() * img.length);
    console.log(random);
    return `/random/${img[random]}`;
};
