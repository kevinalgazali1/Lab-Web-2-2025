const readline = require("readline");
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

let angka = Math.floor(Math.random() * 100) + 1;

function tanya() {
  rl.question("Masukkan angka dari 1 sampai 100: ", (gues) => {
    let guess = Number(gues);

    if (guess === angka) {
      console.log("Selamat, tebakan Anda benar!");
      rl.close();
    } else if (guess < angka) {
      console.log("Tebakan Anda terlalu rendah.");
      tanya();
    } else {
      console.log("Tebakan Anda terlalu tinggi.");
      tanya();
    }
  });
}

tanya();
