const daftarHari = ["senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];
const readline = require('readline');
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question("Masukkan hari saat ini: ", (hariIniInput) => {
    rl.question("Masukkan jumlah hari yang akan datang: ", (jumlahHariInput) => {
    const jumlahHari = parseInt(jumlahHariInput);
    const hariAwal = hariIniInput.toLowerCase();
    const indexAwal = daftarHari.indexOf(hariAwal);

    if (indexAwal === -1) {
        console.log("Nama hari tidak valid. Silakan coba lagi.");
    } else if (isNaN(jumlahHari)) {
        console.log("Jumlah hari harus berupa angka. Silakan coba lagi.");
    } else {
        const indexNanti = (indexAwal + jumlahHari) % 7;
        const hariNanti = daftarHari[indexNanti];
        console.log("Hari setelah " + jumlahHari + " hari dari " + hariAwal + " adalah: " + hariNanti);
    }
    rl.close();
    });
});