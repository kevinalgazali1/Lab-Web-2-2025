const readline = require("readline");
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question("Masukkan harga barang: ", (hargaInput) => {
    let harga = Number(hargaInput);

rl.question("Masukkan kategori barang (elektronik, pakaian, makanan, lainnya): ", (kategori) => {
    let diskon = 1;
    let dis = 0;

    switch (kategori.toLowerCase()) {
        case "elektronik":
            diskon = 0.9;
            dis = 10;
            break;
        case "pakaian":
            diskon = 0.8;
            dis = 20;
            break;
        case "makanan":
            diskon = 0.95;
            dis = 5;
            break;
    }

    let hargaAkhir = harga * diskon;
    console.log("Harga sebelum diskon: " + harga);
    console.log("Diskon: " + dis + "%");
    console.log("Harga akhir setelah diskon: " + hargaAkhir);

    rl.close();
  });
});
