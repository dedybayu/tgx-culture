<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Katalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key constraints to safely truncate tables
        Schema::disableForeignKeyConstraints();
        Katalog::truncate();
        Kategori::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Seed Users (m_user)
        $admin = User::create([
            'username' => 'superadmin',
            'password' => Hash::make('password'),
            'nama' => 'Super Admin',
            'is_admin' => true,
        ]);

        User::create([
            'username' => 'user',
            'password' => Hash::make('password'),
            'nama' => 'User Biasa',
            'is_admin' => false,
        ]);

        // 2. Seed Kategori (m_kategori)
        $kategoriList = [
            'Manuskrip',
            'Tradisi Lisan',
            'Adat Istiadat',
            'Ritus',
            'Pengetahuan Tradisional',
            'Teknologi Tradisional',
            'Seni',
            'Bahasa',
            'Permainan Rakyat',
            'Olahraga Tradisional',
            'Cagar Budaya'
        ];

        $faker = Faker::create('id_ID');

        foreach ($kategoriList as $namaKategori) {
            $kategori = Kategori::create([
                'nama_kategori' => $namaKategori,
                'path_gambar' => 'kategori/' . Str::slug($namaKategori) . '.jpg',
            ]);

            // 3. Seed Katalog (t_katalog) - 2 items per category
            for ($i = 1; $i <= 2; $i++) {
                Katalog::create([
                    'kategori_id' => $kategori->kategori_id,
                    'user_id' => $admin->user_id,
                    'judul' => $namaKategori . ' ' . $faker->words(3, true),
                    'deskripsi' => $faker->paragraph(3),
                    'pencipta' => $faker->name,
                    'subjek' => $faker->word,
                    'penerbit' => $faker->company,
                    'kontribusi' => $faker->name,
                    'tanggal' => $faker->date(),
                    'tipe' => 'Fisik',
                    'format' => 'Buku / Dokumen',
                    'identitas' => 'ID-' . $faker->numerify('##########'),
                    'sumber' => $faker->company,
                    'bahasa' => 'Indonesia',
                    'hubungan' => $faker->word,
                    'lokasi' => $faker->city,
                    'hak_cipta' => 'Milik Publik / tgx-culture',
                    'path_gambar' => 'katalog/' . Str::slug($namaKategori) . '-' . $i . '.jpg',
                ]);
            }
        }
    }
}

