const readline=require('readline');

function hargabarang(jbarang,hbarang){
    let jenis=jbarang.toLowerCase();
    let harga=hbarang;
    
    if (isNaN(harga) || harga <= 0){
        throw new Error("Harga barang harus lebih dari 0");
    }

    if (jenis === "elektronik"){
        let diskon = 0.1 * harga;
        let total = harga - diskon;
        console.log("Harga barang : "+ harga);
        console.log("Diskon : 10%" );
        console.log("Selamat Anda mendapatkan diskon sebesar :"+ total);
    }
    else if (jenis === "pakaian"){
        let diskon = 0.2 * harga;
        let total = harga * diskon;
        console.log("Harga barang : "+ harga);
        console.log("Diskon : 20%" );
        console.log("Selamat Anda mendapatkan diskon sebesar :"+ total);
    }
    else if (jenis === "makanan" ){
        let diskon = 0.05 * harga;
        let total = harga - diskon;
        console.log("Harga barang : "+ harga);
        console.log("Diskon : 5%");
        console.log("Selamat Anda mendapatkan diskon sebesar :"+ total);   
    }
    else if (jenis === "lainnya"){
        let diskon = 0;
        let total = harga - diskon;
        console.log("Harga barang : "+ harga);
        console.log("Tidak ada diskon" );
        console.log("Maaf Anda tidak mendapatkan diskon, harga yang harus dibayar :"+ total);
    }
    else {
        throw new Error("Jenis barang tidak valid! Pilih: elektronik, pakaian, atau makanan, lainnya");
    }
}
const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question("Masukkan harga barang: ", function(harga) {
    rl.question("Masukkan jenis barang (elektronik, pakaian, makanan, lainnya): ", function(jenis) {
        try {
            hargabarang(jenis, parseFloat(harga));
        } catch (err) {
            console.log("Error:", err.message);
        }
        rl.close();
    });
});
