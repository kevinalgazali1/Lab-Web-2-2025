function countEvenNumbers(start, end) {
  let evens = [];

  for (let i = start; i <= end; i++) {
    if (i % 2 === 0) {
      evens.push(i);
    }
  }

  console.log("Output : " + evens.length + " [" + evens + "]");
}

countEvenNumbers(1, 10);