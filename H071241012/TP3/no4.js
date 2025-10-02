const readline = require('readline');

const angka = Math.floor(Math.random() * 100) + 1;
let percobaan = 1;


const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

function tanyaTebakan() {
    rl.question(`Percobaan ${percobaan} - Masukkan angka 1 sampai 100: `, function(tebak) {
        try {
            const tebakan = parseInt(tebak);
            if (isNaN(tebakan) || tebakan < 1 || tebakan > 100) {
                throw new Error("Input tidak valid! Masukkan angka antara 1 sampai 100.");
            }
            if (tebakan === angka) {
                console.log("Selamat! kamu berhasil menebak angka " + angka + " dengan benar");
                rl.close();
            } else {
                if (tebakan > angka) {
                    console.log("Terlalu tinggi! Coba lagi.");
                } else if (tebakan < angka) {
                    console.log("Terlalu rendah! Coba lagi.");
                }
                percobaan++;
                tanyaTebakan();
            }
        } catch (err) {
            console.log("Error:", err.message);
            tanyaTebakan();
        }
    });
}

tanyaTebakan();

