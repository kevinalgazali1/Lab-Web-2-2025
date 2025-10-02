const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

console.log("\n========HAI HAI HAI========");

try {
  rl.question("Masukkan harga barang: ", function(numInput) {
    let num = parseFloat(numInput);

      if (isNaN(num) || num < 0) {
        console.error("Input tidak valid. Harap masukkan harga yang benar.");
        rl.close();
        return;
      }

    rl.question("Masukkan nama barang (Elektronik, Pakaian, Makanan, Lainnya): ", function(brg) {

      if (brg !== "Elektronik" && brg !== "Pakaian" && brg !== "Makanan" && brg !== "Lainnya") {
        console.error("Input tidak valid. Harap masukkan nama barang yang benar.");
        rl.close();
        return;
      }
      
      if (brg === "Elektronik") {
        diskon = num * 0.1;
        dis = "10%";
      } else if (brg === "Pakaian") {
        diskon = num * 0.2;
        dis = "20%";
      } else if (brg === "Makanan") {
        diskon = num * 0.05;
        dis = "5%";
      } else {
        dis = "Tidak ada diskon";
      }

      let total = num - diskon;

      console.log("\n==========YUHUUU==========");
      console.log("Harga awal: Rp " + num);
      console.log("Diskon: " + dis);
      console.log("Total harga setelah diskon: Rp " + total);

      rl.close();
    });
  });
} catch (error) {
  console.error("Terjadi error:", error.message);
  rl.close();
}