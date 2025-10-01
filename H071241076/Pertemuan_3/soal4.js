const readline = require('readline');
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const angkaRahasia = Math.floor(Math.random() * 100) + 1;
let percobaan = 0;
console.log("Selamat datang di permainan tebak angka!");

function tebakangka(){
    rl.question("Masukkan salah satu dari angka 1 sampai 100: ", (inputtebakan) => {
    percobaan++;
    const tebakan = parseInt(inputtebakan);

    if (isNaN(tebakan)) {
        console.log("Input tidak valid, harap masukkan angka.")
    } else if (tebakan < angkaRahasia) {
        console.log("Terlalu rendah! Coba lagi.");
        tebakangka();
    } else if (tebakan > angkaRahasia) {
        console.log("Terlalu tinggi! Coba lagi.");
        tebakangka();
    } else {
        console.log("Selamat! Tebakan Anda benar.");
        console.log("Jumlah percobaan: " + percobaan);
        rl.close();
    }
    });
}
tebakangka();