let genap = []

function countEventNumbers (a,b){
    for(let i = a; i <= b; i++){
        if (i % 2 === 0){
            genap.push(i)
        }
    }
    console.log(genap.length, genap);
}
countEventNumbers(1,10);