// Menggunakan Perulangan
function deretFibonacci(jumlahDeret) {
    let deret = [0, 1];
    
    console.log("Deret Fibonacci:");
    console.log(deret[0]);
    console.log(deret[1]);
    
    for (let i = 2; i < jumlahDeret; i++) {
        let nextNumber = deret[i-1] + deret[i-2];
        deret.push(nextNumber);
        console.log(nextNumber);
    }
}

// Panggil fungsi
deretFibonacci(10);
