const readline = require('readline');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});



rl.question("Masukkan harga barang: ", (hargaInput) => {
    rl.question("Masukkan jenis barang (Elektronik, Pakaian, Makanan, Lainnya): ", (jenisInput) => {
        const hargaAwal = parseFloat(hargaInput);
        if (isNaN(hargaAwal)) {
        console.log("Input harga tidak valid. Harap masukkan angka.");
        } else {
        let diskonPersen = 0;
        const jenisBarang = jenisInput.toLowerCase();
        switch (jenisBarang) {
        case "elektronik":
            diskonPersen = 0.10;
            break;
        case "pakaian":
            diskonPersen = 0.20;
            break;
        case "makanan":
            diskonPersen = 0.05;
            break;
        }
        const jumlahDiskon = hargaAwal * diskonPersen;
        const hargaAkhir = hargaAwal - jumlahDiskon;

        console.log("Harga awal: Rp " + hargaAwal);
        console.log("Diskon: " + (diskonPersen * 100) + "%");
        console.log("Harga setelah diskon: Rp " + hargaAkhir);
        }
    rl.close();
    });
});