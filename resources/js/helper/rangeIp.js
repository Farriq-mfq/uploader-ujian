export const RangeIp = (start, end) => {
    const filterRegexIp = new RegExp(
        /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/
    );
    return new Promise((resolve, reject) => {
        if (start != null && end != null) {
            if (filterRegexIp.test(start) && filterRegexIp.test(start)) {
                if (checkIpOktet(start, end)) {
                    let startIp = parseInt(start.split(".")[3]);
                    let endIp = parseInt(end.split(".")[3]);
                    let rangesIp = [];
                    const startArr = start.split(".");
                    for (let i = startIp; i < endIp + 1; i++) {
                        rangesIp.push(
                            `${startArr[0]}.${startArr[1]}.${startArr[2]}.${i}`
                        );
                    }
                    resolve(rangesIp);
                } else {
                    reject("IP akhir harus lebih dari IP awal");
                }
            } else {
                reject("Invalid ip");
            }
        } else {
            reject("Invalid ip");
        }
    });

    function checkIpOktet(start, end) {
        const splitStart = start.split(".")[3];
        const splitEnd = end.split(".")[3];

        if (parseInt(splitStart) >= parseInt(splitEnd)) {
            return false;
        } else {
            return true;
        }
    }
};


export function validateIp(ip){
    const filterRegexIp = new RegExp(
        /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/
    );

    if(filterRegexIp.test(ip)){
        return true
    }else{
        return false
    }
}