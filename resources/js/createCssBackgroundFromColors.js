const createCssBackgroundFromColors = function (colors) {
    if (! Array.isArray(colors)) {
        return colors;
    }

    let percentage = 100 / colors.length;
    let gradient = 'linear-gradient(to bottom right, ';

    for (let i = 0; i < colors.length; i++) {
        gradient += colors[i] + ' ' + percentage * i + '%, ' + colors[i] + ' ' + percentage * (i + 1) + '%';
        if (i+1 < colors.length) {
            gradient += ',';
        }
    }

    return gradient + ')';
};

export default createCssBackgroundFromColors;
