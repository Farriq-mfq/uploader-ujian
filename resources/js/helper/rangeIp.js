export const RangeIp = (start, end) => {
    const filterRegexIp = new RegExp(
        /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/
    );
    return new Promise((resolve, reject) => {
        if (start != null && end != null) {
            if (checkIpOktet(start, end)) {
                if (filterRegexIp.test(start) && filterRegexIp.test(start)) {
                    resolve([]);
                } else {
                    reject("Invalid ip");
                }
            } else {
                reject("IP akhir harus lebih dari IP awal");
            }
        } else {
            reject("Invalid ip");
        }
    });

    function checkIpOktet(start, end) {
        const splitStart = start.split(".")[start.split(".").length - 1];
        const splitEnd = end.split(".")[end.split(".").length - 1];

        if (parseInt(splitStart) > parseInt(splitEnd)) {
            return false;
        } else {
            return true;
        }
    }
};
