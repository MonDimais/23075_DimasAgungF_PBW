<?php
class Book {
    private $code_book;
    private $name;
    private $qty;

    /**
     * Constructor untuk class Book
     * 
     * @param string $code_book Kode buku (format: 2 huruf besar + 2 angka)
     * @param string $name Nama buku
     * @param int $qty Kuantitas buku (harus positif)
     */
    public function __construct($code_book, $name, $qty) {
        $this->setCodeBook($code_book);
        $this->name = $name;
        $this->setQty($qty);
    }

    /**
     * Setter untuk code_book
     * Format harus 2 huruf besar diikuti 2 angka
     * 
     * @param string $code_book
     * @return void
     */
    private function setCodeBook($code_book) {
        // Cek format code_book (2 huruf besar + 2 angka)
        if (preg_match('/^[A-Z]{2}[0-9]{2}$/', $code_book)) {
            $this->code_book = $code_book;
        } else {
            echo "Error: Format kode buku tidak valid. Format yang benar adalah 2 huruf kapital diikuti 2 angka (contoh: AB12).<br>";
        }
    }

    /**
     * Setter untuk qty
     * Harus berupa angka integer positif
     * 
     * @param int $qty
     * @return void
     */
    private function setQty($qty) {
        // Cek jika qty adalah integer positif
        if (is_int($qty) && $qty > 0) {
            $this->qty = $qty;
        } else {
            echo "Error: Kuantitas harus berupa angka integer positif.<br>";
        }
    }

    /**
     * Getter untuk code_book
     * 
     * @return string
     */
    public function getCodeBook() {
        return $this->code_book;
    }

    /**
     * Getter untuk name
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Getter untuk qty
     * 
     * @return int
     */
    public function getQty() {
        return $this->qty;
    }
}

// Contoh penggunaan:
// Format code_book valid, qty valid
$book1 = new Book("AB12", "PHP Programming", 10);
echo "Buku 1: " . $book1->getCodeBook() . " - " . $book1->getName() . " - " . $book1->getQty() . "<br>";

// Format code_book tidak valid
$book2 = new Book("ABC1", "Python Basics", 5);

// Format qty tidak valid
$book3 = new Book("CD34", "Javascript Fundamentals", -2);

// Format code_book tidak valid, qty tidak valid
$book4 = new Book("12AB", "Database Design", 0);
?>