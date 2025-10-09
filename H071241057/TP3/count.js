function countevennumbers(n,m) {
    let evennumber = []
    for (let index = n; index < m+1; index++) {
        if (index % 2 === 0) {
            evennumber.push(index);
        }
    }
    return evennumber.length +" [" +evennumber+"]";
}

console.log(countevennumbers(1,10));