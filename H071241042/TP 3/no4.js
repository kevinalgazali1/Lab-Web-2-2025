const readline = require("readline");

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
});

let angkaRahasia = Math.floor(Math.random() * 100) + 1;
let jumlahTebakan = 0;

console.log("Komputer sudah memilih angka antara 1 - 100.");
console.log("Coba tebak angkanya!");

function tanya() {
  rl.question("Masukkan tebakanmu: ", (jawaban) => {
    let tebakan = parseInt(jawaban);

    // Cek apakah input valid (angka dan dalam rentang 1-100)
    if (isNaN(tebakan)) {
      console.error("Input tidak valid! Harap masukkan angka.");
      return tanya(); // ulangi tanpa tambah jumlahTebakan
    }
    if (tebakan < 1 || tebakan > 100) {
      console.error("Angka harus di antara 1 dan 100.");
      return tanya();
    }

    jumlahTebakan++;

    if (tebakan > angkaRahasia) {
      console.log("Terlalu tinggi! Coba lagi.");
      tanya();
    } else if (tebakan < angkaRahasia) {
      console.log("Terlalu rendah! Coba lagi.");
      tanya();
    } else {
      console.log(
        `Selamat! Kamu berhasil menebak angkanya (${angkaRahasia}) dalam ${jumlahTebakan} kali tebakan.`
      );
      rl.close();
    }
  });
}

tanya();