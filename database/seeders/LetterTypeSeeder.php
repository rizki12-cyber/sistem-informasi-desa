<?php

namespace Database\Seeders;

use App\Models\LetterType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LetterTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Surat keterangan tempat tinggal/domisili di wilayah desa',
                'requirements' => "Fotokopi KTP\nFotokopi Kartu Keluarga (KK)\nSurat pengantar RT/RW",
                'form_schema' => [
                    ['name' => 'alamat_asal', 'label' => 'Alamat Asal (sesuai KTP)', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Alamat lengkap sesuai KTP'],
                    ['name' => 'alamat_domisili', 'label' => 'Alamat Domisili Sekarang', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Alamat tempat tinggal sekarang'],
                    ['name' => 'lama_tinggal', 'label' => 'Lama Tinggal', 'type' => 'text', 'required' => false, 'placeholder' => 'Contoh: 2 tahun 3 bulan'],
                    ['name' => 'status_tempat', 'label' => 'Status Tempat Tinggal', 'type' => 'select', 'required' => false, 'options' => ['Milik Sendiri', 'Sewa/Kontrak', 'Menumpang', 'Lainnya']],
                ],
            ],
            [
                'name' => 'Surat Keterangan Usaha (SKU)',
                'description' => 'Surat keterangan untuk usaha kecil/menengah',
                'requirements' => "Fotokopi KTP\nFotokopi Kartu Keluarga (KK)\nFoto tempat usaha\nSurat pengantar RT/RW",
                'form_schema' => [
                    ['name' => 'nama_usaha', 'label' => 'Nama Usaha', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Toko Berkah Jaya'],
                    ['name' => 'jenis_usaha', 'label' => 'Jenis/Bidang Usaha', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Perdagangan Sembako'],
                    ['name' => 'alamat_usaha', 'label' => 'Alamat Usaha', 'type' => 'textarea', 'required' => true, 'placeholder' => 'Alamat lokasi usaha'],
                    ['name' => 'lama_usaha', 'label' => 'Lama Usaha Berdiri', 'type' => 'text', 'required' => false, 'placeholder' => 'Contoh: 3 tahun'],
                    ['name' => 'jumlah_karyawan', 'label' => 'Jumlah Karyawan', 'type' => 'number', 'required' => false, 'placeholder' => 'Contoh: 5'],
                    ['name' => 'modal_usaha', 'label' => 'Perkiraan Modal Usaha', 'type' => 'text', 'required' => false, 'placeholder' => 'Contoh: Rp 10.000.000'],
                ],
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'description' => 'Surat keterangan untuk keluarga kurang mampu',
                'requirements' => "Fotokopi KTP\nFotokopi Kartu Keluarga (KK)\nSurat pengantar RT/RW\nFotokopi tagihan listrik/PDAM",
                'form_schema' => [
                    ['name' => 'penghasilan_perbulan', 'label' => 'Penghasilan per Bulan', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Rp 1.500.000'],
                    ['name' => 'jumlah_tanggungan', 'label' => 'Jumlah Tanggungan Keluarga', 'type' => 'number', 'required' => true, 'placeholder' => 'Contoh: 4'],
                    ['name' => 'nama_ayah', 'label' => 'Nama Ayah', 'type' => 'text', 'required' => false, 'placeholder' => 'Nama ayah kandung'],
                    ['name' => 'nama_ibu', 'label' => 'Nama Ibu', 'type' => 'text', 'required' => false, 'placeholder' => 'Nama ibu kandung'],
                    ['name' => 'pekerjaan_ayah', 'label' => 'Pekerjaan Ayah', 'type' => 'text', 'required' => false, 'placeholder' => 'Contoh: Buruh tani'],
                    ['name' => 'pekerjaan_ibu', 'label' => 'Pekerjaan Ibu', 'type' => 'text', 'required' => false, 'placeholder' => 'Contoh: Ibu rumah tangga'],
                ],
            ],
            [
                'name' => 'Surat Pengantar KTP',
                'description' => 'Surat pengantar pembuatan/perpanjangan KTP',
                'requirements' => "Fotokopi Kartu Keluarga (KK)\nFotokopi KTP lama (jika perpanjangan)\nFoto 3x4 (2 lembar)",
                'form_schema' => [
                    ['name' => 'jenis_pengajuan', 'label' => 'Jenis Pengajuan', 'type' => 'select', 'required' => true, 'options' => ['Baru', 'Perpanjangan', 'Penggantian (Hilang/Rusak)']],
                    ['name' => 'golongan_darah', 'label' => 'Golongan Darah', 'type' => 'select', 'required' => false, 'options' => ['A', 'B', 'AB', 'O', 'Tidak Tahu']],
                    ['name' => 'status_perkawinan', 'label' => 'Status Perkawinan', 'type' => 'select', 'required' => true, 'options' => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']],
                    ['name' => 'pendidikan_terakhir', 'label' => 'Pendidikan Terakhir', 'type' => 'select', 'required' => false, 'options' => ['Tidak/Belum Sekolah', 'SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3']],
                ],
            ],
            [
                'name' => 'Surat Pengantar Kartu Keluarga (KK)',
                'description' => 'Surat pengantar pembuatan/perubahan KK',
                'requirements' => "Fotokopi KK lama\nFotokopi akta nikah/cerai\nSurat pengantar RT/RW",
                'form_schema' => [
                    ['name' => 'jenis_pengajuan', 'label' => 'Jenis Pengajuan', 'type' => 'select', 'required' => true, 'options' => ['Baru', 'Penambahan Anggota', 'Pengurangan Anggota', 'Perbaikan Data', 'Hilang/Rusak']],
                    ['name' => 'nomor_kk_lama', 'label' => 'Nomor KK Lama', 'type' => 'text', 'required' => false, 'placeholder' => '16 digit KK lama'],
                    ['name' => 'jumlah_anggota', 'label' => 'Jumlah Anggota Keluarga', 'type' => 'number', 'required' => false, 'placeholder' => 'Contoh: 4'],
                    ['name' => 'kepala_keluarga', 'label' => 'Nama Kepala Keluarga', 'type' => 'text', 'required' => false, 'placeholder' => 'Nama kepala keluarga'],
                ],
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'description' => 'Surat keterangan kelahiran anak',
                'requirements' => "Fotokopi KTP orang tua\nFotokopi Kartu Keluarga (KK)\nFotokopi buku nikah\nSurat keterangan bidan/RS",
                'form_schema' => [
                    ['name' => 'nama_anak', 'label' => 'Nama Anak', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama lengkap anak'],
                    ['name' => 'jenis_kelamin_anak', 'label' => 'Jenis Kelamin Anak', 'type' => 'select', 'required' => true, 'options' => ['Laki-laki', 'Perempuan']],
                    ['name' => 'tanggal_lahir_anak', 'label' => 'Tanggal Lahir Anak', 'type' => 'date', 'required' => true],
                    ['name' => 'tempat_lahir_anak', 'label' => 'Tempat Lahir Anak', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Rumah / RS / Klinik'],
                    ['name' => 'nama_ayah', 'label' => 'Nama Ayah', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama lengkap ayah'],
                    ['name' => 'nama_ibu', 'label' => 'Nama Ibu', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama lengkap ibu'],
                    ['name' => 'anak_ke', 'label' => 'Anak Ke-', 'type' => 'number', 'required' => false, 'placeholder' => 'Contoh: 2'],
                ],
            ],
            [
                'name' => 'Surat Keterangan Kematian',
                'description' => 'Surat keterangan kematian seseorang',
                'requirements' => "Fotokopi KTP almarhum/almarhumah\nFotokopi Kartu Keluarga (KK)\nSurat keterangan medis/RS",
                'form_schema' => [
                    ['name' => 'nama_almarhum', 'label' => 'Nama Almarhum/Almarhumah', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama lengkap almarhum'],
                    ['name' => 'nik_almarhum', 'label' => 'NIK Almarhum', 'type' => 'text', 'required' => false, 'placeholder' => '16 digit NIK'],
                    ['name' => 'tanggal_kematian', 'label' => 'Tanggal Kematian', 'type' => 'date', 'required' => true],
                    ['name' => 'tempat_kematian', 'label' => 'Tempat Kematian', 'type' => 'text', 'required' => true, 'placeholder' => 'Contoh: Rumah / RS'],
                    ['name' => 'sebab_kematian', 'label' => 'Sebab Kematian', 'type' => 'text', 'required' => false, 'placeholder' => 'Contoh: Sakit / Usia Lanjut'],
                    ['name' => 'tempat_pemakaman', 'label' => 'Tempat Pemakaman', 'type' => 'text', 'required' => false, 'placeholder' => 'Contoh: TPU Desa'],
                ],
            ],
            [
                'name' => 'Surat Pengantar Nikah',
                'description' => 'Surat pengantar untuk keperluan pernikahan',
                'requirements' => "Fotokopi KTP calon pengantin\nFotokopi Kartu Keluarga (KK)\nFotokopi akta lahir\nFoto 2x3 dan 4x6",
                'form_schema' => [
                    ['name' => 'nama_calon_pasangan', 'label' => 'Nama Calon Pasangan', 'type' => 'text', 'required' => true, 'placeholder' => 'Nama lengkap calon pasangan'],
                    ['name' => 'tanggal_lahir_pasangan', 'label' => 'Tanggal Lahir Pasangan', 'type' => 'date', 'required' => false],
                    ['name' => 'agama_pasangan', 'label' => 'Agama Pasangan', 'type' => 'text', 'required' => false, 'placeholder' => 'Contoh: Islam'],
                    ['name' => 'alamat_pasangan', 'label' => 'Alamat Pasangan', 'type' => 'textarea', 'required' => false],
                    ['name' => 'tanggal_akad', 'label' => 'Rencana Tanggal Akad', 'type' => 'date', 'required' => false],
                    ['name' => 'tempat_akad', 'label' => 'Rencana Tempat Akad', 'type' => 'text', 'required' => false],
                ],
            ],
        ];

        foreach ($types as $index => $type) {
            LetterType::updateOrCreate(
                ['slug' => Str::slug($type['name'])],
                [
                    'name' => $type['name'],
                    'description' => $type['description'],
                    'requirements' => $type['requirements'],
                    'form_schema' => $type['form_schema'],
                    'is_active' => true,
                    'order' => $index,
                ]
            );
        }
    }
}