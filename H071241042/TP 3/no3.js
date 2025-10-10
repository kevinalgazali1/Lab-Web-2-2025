const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

try {
  rl.question("Masukkan hari: ", function(hari) {

    if (hari !== "Senin" && hari !== "Selasa" && hari !== "Rabu" && hari !== "Kamis" && hari !== "Jumat" && hari !== "Sabtu" && hari !== "Minggu" && hari !== "Ahad") {
      console.log("Tolong masukkan hari yang benar.");
      rl.close();
      return;
    }

    rl.question("Masukkan jumlah hari yang akan datang: ", function(numInput) {
      let num = parseInt(numInput);

      if (isNaN(num) || num < 0) {
        console.error("Input tidak valid. Harap masukkan jumlah hari yang benar.");
        rl.close();
        return;
      }
      hariArray = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Ahad"];
      // Hitung hari di masa depan
      let index = hariArray.indexOf(hari);
      let futureIndex = (index + num) % 7;
      let futureDay = hariArray[futureIndex];
      console.log("Hari setelah " + num + " hari dari " + hari + " adalah " + futureDay);

      rl.close();
    });
  });
} catch (error) {
  console.error("Terjadi error:", error.message);
  rl.close();
}