<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@tokobuku.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Jl. Admin No. 1, Jakarta',
        ]);

        // Create Sample User
        User::create([
            'name' => 'Pembeli Demo',
            'email' => 'user@tokobuku.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '08987654321',
            'address' => 'Jl. Pembeli No. 2, Bandung',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Fiksi', 'slug' => 'fiksi', 'description' => 'Buku-buku fiksi dan novel'],
            ['name' => 'Non-Fiksi', 'slug' => 'non-fiksi', 'description' => 'Buku-buku non-fiksi dan pengetahuan'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Buku pelajaran dan pendidikan'],
            ['name' => 'Anak-anak', 'slug' => 'anak-anak', 'description' => 'Buku cerita dan edukasi anak'],
            ['name' => 'Bisnis', 'slug' => 'bisnis', 'description' => 'Buku bisnis dan kewirausahaan'],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Buku tentang teknologi dan komputer'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Books
        $books = [
            [
                'category_id' => 1,
                'title' => 'Laskar Pelangi',
                'slug' => 'laskar-pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'year_published' => 2005,
                'isbn' => '978-979-1227-35-0',
                'description' => 'Novel tentang persahabatan dan perjuangan anak-anak Belitong untuk meraih mimpi.',
                'price' => 79000,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'title' => 'Bumi Manusia',
                'slug' => 'bumi-manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'year_published' => 1980,
                'isbn' => '978-979-3210-01-0',
                'description' => 'Novel sejarah yang menceritakan kisah Minke di era kolonial Belanda.',
                'price' => 95000,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'title' => 'Pulang',
                'slug' => 'pulang',
                'author' => 'Tere Liye',
                'publisher' => 'Republika',
                'year_published' => 2015,
                'isbn' => '978-602-0820-05-0',
                'description' => 'Novel tentang perjalanan pulang seorang anak ke kampung halaman.',
                'price' => 85000,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'slug' => 'sapiens-riwayat-singkat-umat-manusia',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'Gramedia',
                'year_published' => 2017,
                'isbn' => '978-602-03-3927-5',
                'description' => 'Buku yang menceritakan perjalanan evolusi manusia dari zaman purba.',
                'price' => 125000,
                'stock' => 10,
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'title' => 'Atomic Habits',
                'slug' => 'atomic-habits',
                'author' => 'James Clear',
                'publisher' => 'Gramedia',
                'year_published' => 2019,
                'isbn' => '978-602-06-2028-5',
                'description' => 'Panduan praktis untuk membangun kebiasaan baik dan menghilangkan kebiasaan buruk.',
                'price' => 99000,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'title' => 'Matematika Dasar SMA',
                'slug' => 'matematika-dasar-sma',
                'author' => 'Tim Penulis Erlangga',
                'publisher' => 'Erlangga',
                'year_published' => 2023,
                'isbn' => '978-602-241-567-8',
                'description' => 'Buku pegangan matematika untuk siswa SMA.',
                'price' => 75000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => 4,
                'title' => 'Si Kancil yang Cerdik',
                'slug' => 'si-kancil-yang-cerdik',
                'author' => 'Penulis Indonesia',
                'publisher' => 'Mizan',
                'year_published' => 2020,
                'isbn' => '978-602-318-123-4',
                'description' => 'Kumpulan cerita rakyat Si Kancil untuk anak-anak.',
                'price' => 45000,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'category_id' => 5,
                'title' => 'Rich Dad Poor Dad',
                'slug' => 'rich-dad-poor-dad',
                'author' => 'Robert T. Kiyosaki',
                'publisher' => 'Gramedia',
                'year_published' => 2018,
                'isbn' => '978-602-03-8765-4',
                'description' => 'Buku tentang literasi keuangan dan cara berpikir orang kaya.',
                'price' => 89000,
                'stock' => 18,
                'is_active' => true,
            ],
            [
                'category_id' => 6,
                'title' => 'Clean Code',
                'slug' => 'clean-code',
                'author' => 'Robert C. Martin',
                'publisher' => 'Prentice Hall',
                'year_published' => 2008,
                'isbn' => '978-0-13-235088-4',
                'description' => 'Panduan menulis kode yang bersih dan mudah dipelihara.',
                'price' => 150000,
                'stock' => 8,
                'is_active' => true,
            ],
            [
                'category_id' => 6,
                'title' => 'Belajar Laravel untuk Pemula',
                'slug' => 'belajar-laravel-untuk-pemula',
                'author' => 'Programmer Indonesia',
                'publisher' => 'Informatika',
                'year_published' => 2023,
                'isbn' => '978-602-123-456-7',
                'description' => 'Panduan lengkap belajar framework Laravel dari dasar.',
                'price' => 120000,
                'stock' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
