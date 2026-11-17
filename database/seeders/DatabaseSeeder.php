<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VillageProfile;
use App\Models\Slider;
use App\Models\VillageOfficial;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\VillageStatistic;
use App\Models\VillagePotential;
use App\Models\Umkm;
use App\Models\Gallery;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@desa.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Village Profile
        $profile = VillageProfile::create([
            'village_name' => 'Desa Sukamaju',
            'district' => 'Kecamatan Sukamakmur',
            'regency' => 'Kabupaten Maju Jaya',
            'province' => 'Provinsi Sejahtera',
            'history' => 'Desa Sukamaju didirikan pada tahun 1945. Desa ini memiliki sejarah panjang dalam perjuangan kemerdekaan dan kini berkembang menjadi desa yang maju dan mandiri.',
            'vision' => 'Mewujudkan Desa Sukamaju yang maju, mandiri, sejahtera, dan berbudaya.',
            'mission' => '1. Meningkatkan pelayanan publik yang prima\n2. Mengembangkan potensi desa secara berkelanjutan\n3. Mewujudkan tata kelola pemerintahan yang baik dan partisipatif',
            'head_name' => 'Budi Santoso',
            'head_message' => 'Selamat datang di website resmi Desa Sukamaju. Kami berkomitmen untuk memberikan pelayanan terbaik kepada masyarakat. Mari bersama-sama kita bangun desa yang lebih maju dan sejahtera.',
        ]);

        // 3. Create Sliders
        Slider::create([
            'title' => 'Selamat Datang di Desa Sukamaju',
            'description' => 'Desa maju, mandiri, dan sejahtera',
            'image' => 'sliders/slide1.jpg',
            'button_text' => 'Jelajahi Desa',
            'button_link' => '/profil',
            'is_active' => true,
            'order' => 0,
        ]);

        Slider::create([
            'title' => 'Pembangunan Desa Berkelanjutan',
            'description' => 'Bersama membangun infrastruktur dan kesejahteraan masyarakat',
            'image' => 'sliders/slide2.jpg',
            'button_text' => 'Lihat Progres',
            'button_link' => '/berita',
            'is_active' => true,
            'order' => 1,
        ]);

        Slider::create([
            'title' => 'Potensi Wisata Desa',
            'description' => 'Keindahan alam dan budaya desa yang memukau',
            'image' => 'sliders/slide3.jpg',
            'button_text' => 'Jelajahi Wisata',
            'button_link' => '/potensi',
            'is_active' => true,
            'order' => 2,
        ]);

        // 4. Create Village Officials (Hierarchy)
        // Kepala Desa
        $kades = VillageOfficial::create([
            'name' => 'Budi Santoso',
            'position' => 'Kepala Desa',
            'photo' => null,
            'parent_id' => null,
            'description' => 'Memimpin pemerintahan desa dan bertanggung jawab atas penyelenggaraan pemerintahan desa.',
            'order' => 0,
            'is_active' => true,
        ]);

        // Sekretaris Desa
        $sekdes = VillageOfficial::create([
            'name' => 'Andi Wijaya',
            'position' => 'Sekretaris Desa',
            'photo' => null,
            'parent_id' => $kades->id,
            'description' => 'Membantu kepala desa dalam pelaksanaan pemerintahan desa.',
            'order' => 0,
            'is_active' => true,
        ]);

        // Kaur
        $kaur1 = VillageOfficial::create([
            'name' => 'Siti Rahayu',
            'position' => 'Kaur Pemerintahan',
            'photo' => null,
            'parent_id' => $sekdes->id,
            'description' => 'Mengelola urusan pemerintahan desa.',
            'order' => 0,
            'is_active' => true,
        ]);

        $kaur2 = VillageOfficial::create([
            'name' => 'Ahmad Fauzi',
            'position' => 'Kaur Keuangan',
            'photo' => null,
            'parent_id' => $sekdes->id,
            'description' => 'Mengelola urusan keuangan desa.',
            'order' => 1,
            'is_active' => true,
        ]);

        $kaur3 = VillageOfficial::create([
            'name' => 'Dewi Lestari',
            'position' => 'Kaur Perencanaan',
            'photo' => null,
            'parent_id' => $sekdes->id,
            'description' => 'Mengelola perencanaan pembangunan desa.',
            'order' => 2,
            'is_active' => true,
        ]);

        // Kasi
        $kasi1 = VillageOfficial::create([
            'name' => 'Muhammad Ali',
            'position' => 'Kasi Pemerintahan',
            'photo' => null,
            'parent_id' => $sekdes->id,
            'description' => 'Mengelola urusan pemerintahan dan pemberdayaan masyarakat.',
            'order' => 3,
            'is_active' => true,
        ]);

        $kasi2 = VillageOfficial::create([
            'name' => 'Fatimah Zahra',
            'position' => 'Kasi Kesejahteraan',
            'photo' => null,
            'parent_id' => $sekdes->id,
            'description' => 'Mengelola urusan kesejahteraan sosial masyarakat.',
            'order' => 4,
            'is_active' => true,
        ]);

        $kasi3 = VillageOfficial::create([
            'name' => 'Hasan Basri',
            'position' => 'Kasi Pelayanan',
            'photo' => null,
            'parent_id' => $sekdes->id,
            'description' => 'Mengelola urusan pelayanan publik.',
            'order' => 5,
            'is_active' => true,
        ]);

        // 5. Create News
        for ($i = 1; $i <= 10; $i++) {
            News::create([
                'title' => "Berita Desa Sukamaju #{$i}",
                'slug' => Str::slug("Berita Desa Sukamaju #{$i}") . '-' . time() . $i,
                'thumbnail' => null,
                'content' => "Konten berita desa Sukamaju nomor {$i}. Ini adalah contoh konten berita yang berisi informasi tentang kegiatan dan pembangunan di Desa Sukamaju. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                'status' => 'published',
                'published_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        // 6. Create Announcements
        for ($i = 1; $i <= 5; $i++) {
            Announcement::create([
                'title' => "Pengumuman Penting #{$i}",
                'content' => "Ini adalah pengumuman penting nomor {$i} untuk seluruh warga desa. Harap diperhatikan dengan baik.",
                'status' => 'published',
                'published_at' => now()->subDays(rand(0, 20)),
            ]);
        }

        // 7. Create Agendas
        $agendas = [
            ['title' => 'Musyawarah Desa', 'location' => 'Balai Desa', 'event_date' => now()->addDays(5), 'start_time' => '19:00', 'end_time' => '21:00', 'status' => 'upcoming'],
            ['title' => 'Gotong Royong Bersih Desa', 'location' => 'Seluruh Desa', 'event_date' => now()->addDays(10), 'start_time' => '07:00', 'end_time' => '10:00', 'status' => 'upcoming'],
            ['title' => 'Rapat Koordinasi Perangkat', 'location' => 'Kantor Desa', 'event_date' => now()->addDays(3), 'start_time' => '13:00', 'end_time' => '15:00', 'status' => 'upcoming'],
            ['title' => 'Kegiatan Posyandu', 'location' => 'Posyandu Desa', 'event_date' => now()->addDays(7), 'start_time' => '08:00', 'end_time' => '11:00', 'status' => 'upcoming'],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }

        // 8. Create Statistics
        $statistics = [
            ['label' => 'Penduduk', 'value' => '8.245', 'icon' => 'users', 'order' => 0],
            ['label' => 'Kepala Keluarga', 'value' => '2.341', 'icon' => 'home', 'order' => 1],
            ['label' => 'Dusun', 'value' => '6', 'icon' => 'map-marker-alt', 'order' => 2],
            ['label' => 'RT', 'value' => '32', 'icon' => 'layer-group', 'order' => 3],
            ['label' => 'RW', 'value' => '12', 'icon' => 'project-diagram', 'order' => 4],
        ];

        foreach ($statistics as $stat) {
            VillageStatistic::create($stat);
        }

        // 9. Create Potentials
        $potentials = [
            ['title' => 'Pertanian Organik', 'category' => 'Pertanian', 'description' => 'Lahan pertanian organik seluas 50 hektar dengan hasil panen berkualitas tinggi.'],
            ['title' => 'Perkebunan Kopi', 'category' => 'Perkebunan', 'description' => 'Perkebunan kopi arabika dengan luas 30 hektar yang menghasilkan biji kopi berkualitas ekspor.'],
            ['title' => 'Peternakan Sapi', 'category' => 'Peternakan', 'description' => 'Peternakan sapi perah yang menghasilkan susu segar berkualitas tinggi.'],
            ['title' => 'Wisata Alam Bukit Hijau', 'category' => 'Wisata', 'description' => 'Destinasi wisata alam dengan pemandangan bukit yang indah dan udara segar.'],
            ['title' => 'Kerajinan Batik', 'category' => 'Kerajinan', 'description' => 'Kerajinan batik khas desa dengan motif tradisional yang kaya akan nilai budaya.'],
            ['title' => 'Produksi Gula Kelapa', 'category' => 'Produk Lokal', 'description' => 'Produksi gula kelapa alami dari pohon kelapa yang ditanam secara organik.'],
        ];

        foreach ($potentials as $potential) {
            VillagePotential::create($potential);
        }

        // 10. Create UMKM
        $umkmData = [
            ['name' => 'Kopi Desa', 'owner' => 'Pak Ahmad', 'category' => 'Minuman', 'description' => 'Produksi kopi desa dengan cita rasa khas.', 'phone' => '081234567890', 'address' => 'Jl. Desa No. 1'],
            ['name' => 'Batik Sukamaju', 'owner' => 'Ibu Siti', 'category' => 'Kerajinan', 'description' => 'Batik tulis dengan motif khas desa.', 'phone' => '081234567891', 'address' => 'Jl. Batik No. 5'],
            ['name' => 'Gula Kelapa Alami', 'owner' => 'Pak Joko', 'category' => 'Makanan', 'description' => 'Gula kelapa organik dari pohon kelapa pilihan.', 'phone' => '081234567892', 'address' => 'Jl. Kelapa No. 8'],
            ['name' => 'Keripik Singkong', 'owner' => 'Bu Dewi', 'category' => 'Makanan', 'description' => 'Keripik singkong dengan berbagai rasa.', 'phone' => '081234567893', 'address' => 'Jl. Singkong No. 12'],
            ['name' => 'Anyaman Bambu', 'owner' => 'Pak Budi', 'category' => 'Kerajinan', 'description' => 'Anyaman bambu berkualitas untuk berbagai keperluan.', 'phone' => '081234567894', 'address' => 'Jl. Bambu No. 3'],
        ];

        foreach ($umkmData as $item) {
            Umkm::create($item);
        }

        // 11. Create Gallery
        for ($i = 1; $i <= 8; $i++) {
            Gallery::create([
                'title' => "Foto Galeri #{$i}",
                'description' => "Deskripsi foto galeri nomor {$i}",
                'image' => 'gallery/photo' . $i . '.jpg',
            ]);
        }

        // 12. Create Contact
        Contact::create([
            'address' => 'Jl. Desa No. 1, Desa Sukamaju, Kecamatan Sukamakmur',
            'phone' => '(021) 1234-5678',
            'email' => 'desa@sukamaju.test',
            'whatsapp' => '081234567890',
            'working_hours' => 'Senin - Jumat: 08:00 - 16:00 WIB',
            'map_embed' => 'https://www.google.com/maps/embed?pb=...',
        ]);

        $this->command->info('Seeder completed successfully!');
        $this->command->info('Admin login: admin@desa.test / password');
    }
}