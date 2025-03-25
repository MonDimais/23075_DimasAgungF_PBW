const readline = require('readline');

class KalkulatorSederhana {
    constructor() {
        this.rl = readline.createInterface({
            input: process.stdin,
            output: process.stdout
        });
    }

    tambah(angka) {
        return angka.reduce((total, current) => total + current, 0);
    }

    kurang(angka) {
        return angka.reduce((total, current) => total - current);
    }

    kali(angka) {
        return angka.reduce((total, current) => total * current, 1);
    }

    bagi(angka) {
        return angka.reduce((total, current) => total / current);
    }

    modulus(angka) {
        return angka.reduce((total, current) => total % current);
    }

    mulai() {
        console.log("\n===== Kalkulator Sederhana =====");
        console.log("Operasi:");
        console.log("1. Tambah (+)");
        console.log("2. Kurang (-)");
        console.log("3. Kali (*)");
        console.log("4. Bagi (/)");
        console.log("5. Modulus (%)");
        console.log("6. Keluar");

        this.pilihOperasi();
    }

    pilihOperasi() {
        this.rl.question("\nPilih operasi (1-6): ", (pilihan) => {
            switch(pilihan) {
                case '1':
                    this.hitungOperasi("Penjumlahan", this.tambah);
                    break;
                case '2':
                    this.hitungOperasi("Pengurangan", this.kurang);
                    break;
                case '3':
                    this.hitungOperasi("Perkalian", this.kali);
                    break;
                case '4':
                    this.hitungOperasi("Pembagian", this.bagi);
                    break;
                case '5':
                    this.hitungOperasi("Modulus", this.modulus);
                    break;
                case '6':
                    console.log("Terima kasih!");
                    this.rl.close();
                    return;
                default:
                    console.log("Pilihan tidak valid!");
                    this.pilihOperasi();
            }
        });
    }

    hitungOperasi(nama, operasi) {
        this.rl.question(`Masukkan angka untuk ${nama} (pisahkan dengan spasi): `, (input) => {
            const angka = input.split(' ').map(Number);

            if (angka.some(isNaN)) {
                console.log("Input tidak valid! Harap masukkan angka.");
                this.pilihOperasi();
                return;
            }

            try {
                const hasil = operasi(angka);
                console.log(`\nHasil ${nama}: ${hasil}`);
            } catch (error) {
                console.log("Terjadi kesalahan dalam perhitungan.");
            }

            this.pilihOperasi();
        });
    }
}

// Jalankan kalkulator
const kalkulator = new KalkulatorSederhana();
kalkulator.mulai();