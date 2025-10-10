const readline = require("readline");
const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question("Masukkan hari: ", (har) => {
rl.question("Masukkan hari akan datang: ", (days) => {

    let day = Number(days);
    let hari = har.toLowerCase();
    let seminggu = [ "senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu"];        
    let indexhari= seminggu.indexOf(hari);

    let haribaru = seminggu[((indexhari + day) % 7)];
    console.log(day + "Hari setelah " + har + " adalah hari " + haribaru);


    rl.close();
  });
});
