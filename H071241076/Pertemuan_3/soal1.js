function countEvenNumbers(start, end) {
    if (isNaN(start) || isNaN(end)) {
    return "Error: Kedua input harus berupa angka.";
    }
    if (start > end) {
    return "Error: Angka 'start' tidak boleh lebih besar dari 'end'.";
    }
    let evenCounter = 0;
    let evenNumberlist = [];
    
    for (let i = start; i <= end; i++) {
        if (i % 2 === 0) {
            evenCounter++;
            evenNumberlist.push(i);
        }
    }
    return evenCounter + " [" + evenNumberlist.join(', ') + "]";
}

const result = countEvenNumbers('satu', 10);
const result2 = countEvenNumbers(1, 10);
console.log(result);
console.log(result2);