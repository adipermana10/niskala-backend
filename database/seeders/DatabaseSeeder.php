<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Disaster;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin Utama Niskala',
            'email'    => 'admin@niskala.id',
            'phone'    => '081234567890',
            'role'     => 'admin',
            'password' => Hash::make('password123'),
        ]);

        $user1 = User::create([
            'name'     => 'Raka Pratama',
            'email'    => 'raka@niskala.id',
            'phone'    => '081298765432',
            'role'     => 'user',
            'password' => Hash::make('password123'),
        ]);

        $user2 = User::create([
            'name'     => 'Ayu Lestari',
            'email'    => 'ayu@niskala.id',
            'phone'    => '081355667788',
            'role'     => 'user',
            'password' => Hash::make('password123'),
        ]);

        $catErupsi = Category::create([
            'name'        => 'Erupsi & Vulkanik',
            'slug'        => 'erupsi-vulkanik',
            'description' => 'Penanganan dampak aktivitas gunung berapi, awan panas, dan banjir lahar dingin.',
            'icon'        => 'mountain',
        ]);

        $catBanjir = Category::create([
            'name'        => 'Banjir & Longsor',
            'slug'        => 'banjir-longsor',
            'description' => 'Respon cepat bencana hidrometeorologi, banjir bandang, dan tanah longsor.',
            'icon'        => 'cloud-rain',
        ]);

        $catGempa = Category::create([
            'name'        => 'Gempa Bumi',
            'slug'        => 'gempa-bumi',
            'description' => 'Tanggap darurat dan rehabilitasi pascagempa bumi di wilayah Nusantara.',
            'icon'        => 'activity',
        ]);

        $catKemanusiaan = Category::create([
            'name'        => 'Pemulihan Sosial & Medis',
            'slug'        => 'pemulihan-sosial-medis',
            'description' => 'Dukungan logistik, dapur umum, trauma healing, dan layanan kesehatan penyintas.',
            'icon'        => 'heart-handshake',
        ]);

        $disaster1 = Disaster::create([
            'category_id'      => $catErupsi->id,
            'title'            => 'Erupsi & Guguran Awan Panas Lereng Semeru',
            'slug'             => 'erupsi-guguran-awan-panas-lereng-semeru',
            'location'         => 'Kab. Lumajang, Jawa Timur',
            'latitude'         => -8.1077170,
            'longitude'        => 112.9224070,
            'impact_radius_km' => 12.50,
            'occurred_at'      => now()->subDays(4),
            'status'           => 'tanggap_darurat',
            'summary'          => 'Peningkatan aktivitas vulkanik disertai hujan abu tebal berdampak pada 1.450 warga di tiga desa lereng gunung. Kebutuhan mendesak meliputi masker medis N95, air bersih, dan selimut hangat.',
            'content'          => "Peningkatan aktivitas vulkanik kembali terjadi dan mengakibatkan hujan abu vulkanik di beberapa titik pemukiman warga.\n\nTim relawan gabungan bersama BPBD setempat telah mendirikan posko pengungsian terpadu untuk memprioritaskan lansia, ibu hamil, serta anak-anak. Saat ini jalur distribusi logistik terus dibuka agar suplai makanan siap saji, air bersih, serta perlengkapan tidur dapat menjangkau posko-posko pengungsian.",
            'thumbnail'        => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1000&q=80',
        ]);

        $disaster2 = Disaster::create([
            'category_id'      => $catBanjir->id,
            'title'            => 'Banjir Bandang & Longsor Wilayah Agam',
            'slug'             => 'banjir-bandang-longsor-wilayah-agam',
            'location'         => 'Kab. Agam, Sumatera Barat',
            'latitude'         => -0.3055560,
            'longitude'        => 100.3691670,
            'impact_radius_km' => 8.00,
            'occurred_at'      => now()->subDays(9),
            'status'           => 'pemulihan',
            'summary'          => 'Curah hujan tinggi memicu luapan sungai dan material longsor yang menutup akses jalan desa serta merusak puluhan rumah warga dan fasilitas air bersih.',
            'content'          => "Intensitas hujan tinggi yang berlangsung selama dua hari berturut-turut menyebabkan debit sungai meluap dengan cepat.\n\nSaat ini fokus penanganan berada pada fase pemulihan awal, termasuk pembersihan fasilitas umum, penyediaan instalasi air bersih darurat, serta pemulihan ruang belajar sementara bagi anak-anak terdampak.",
            'thumbnail'        => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&w=1000&q=80',
        ]);

        $disaster3 = Disaster::create([
            'category_id'      => $catGempa->id,
            'title'            => 'Gempa Tektonik Dangkal Wilayah Garut Selatan',
            'slug'             => 'gempa-tektonik-dangkal-wilayah-garut-selatan',
            'location'         => 'Kab. Garut, Jawa Barat',
            'latitude'         => -7.2279060,
            'longitude'        => 107.9086990,
            'impact_radius_km' => 15.00,
            'occurred_at'      => now()->subDays(14),
            'status'           => 'pemulihan',
            'summary'          => 'Guncangan gempa menyebabkan keretakan dan kerusakan pada sejumlah rumah warga serta bangunan sekolah dasar di daerah perbukitan.',
            'content'          => "Gempa bumi tektonik dangkal dirasakan kuat oleh warga sekitar pada malam hari. Meski tidak berpotensi tsunami, sejumlah rumah dengan struktur rentan mengalami kerusakan ringan hingga sedang.\n\nWarga membutuhkan bantuan material perbaikan tempat tinggal sementara, tenda keluarga, serta pendampingan psikososial untuk anak-anak.",
            'thumbnail'        => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=1000&q=80',
        ]);

        $campaign1 = Campaign::create([
            'category_id'      => $catErupsi->id,
            'disaster_id'      => $disaster1->id,
            'user_id'          => $admin->id,
            'title'            => 'Darurat Udara Bersih & Dapur Umum Penyintas Lereng Semeru',
            'slug'             => 'darurat-udara-bersih-dapur-umum-semeru',
            'description'      => "Kebaikan yang tak terlihat namun nyata manfaatnya. Mari bersama menyediakan paket masker respirator, tabung oksigen portabel, perlengkapan bayi, dan operasional dapur umum selama 14 hari masa tanggap darurat bagi keluarga di lereng Semeru.\n\nSetiap donasi yang terkumpul akan disalurkan secara transparan melalui posko lapangan Niskala bekerja sama dengan relawan lokal.",
            'target_amount'    => 150000000,
            'collected_amount' => 92500000,
            'deadline'         => now()->addDays(21),
            'status'           => 'active',
            'thumbnail'        => 'https://images.unsplash.com/photo-1593113630400-ea4288922497?auto=format&fit=crop&w=1000&q=80',
        ]);

        $campaign2 = Campaign::create([
            'category_id'      => $catBanjir->id,
            'disaster_id'      => $disaster2->id,
            'user_id'          => $admin->id,
            'title'            => 'Bangun Kembali Jaringan Air Bersih & Sanitasi Desa Terdampak Banjir Agam',
            'slug'             => 'air-bersih-sanitasi-desa-terdampak-banjir-agam',
            'description'      => "Pascabanjir bandang, warga kesulitan memperoleh air bersih untuk kebutuhan memasak dan sanitasi harian. Kampanye ini berfokus pada pembangunan kembali jaringan pipa air bersih masyarakat dan penyediaan tangki filtrasi komunal.",
            'target_amount'    => 120000000,
            'collected_amount' => 84000000,
            'deadline'         => now()->addDays(30),
            'status'           => 'active',
            'thumbnail'        => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&w=1000&q=80',
        ]);

        $campaign3 = Campaign::create([
            'category_id'      => $catKemanusiaan->id,
            'disaster_id'      => $disaster3->id,
            'user_id'          => $admin->id,
            'title'            => 'Ruang Belajar & Paket Sekolah untuk Anak Penyintas Gempa Garut',
            'slug'             => 'ruang-belajar-paket-sekolah-penyintas-gempa-garut',
            'description'      => "Jangan biarkan mimpi anak-anak terhenti karena bencana. Mari hadirkan tenda belajar yang nyaman, buku bacaan, seragam, serta kegiatan trauma healing agar senyum mereka kembali pulih.",
            'target_amount'    => 75000000,
            'collected_amount' => 61250000,
            'deadline'         => now()->addDays(15),
            'status'           => 'active',
            'thumbnail'        => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1000&q=80',
        ]);

        Donation::create([
            'campaign_id'    => $campaign1->id,
            'user_id'        => $user1->id,
            'invoice_number' => 'NSK-20261023-0001',
            'donor_name'     => $user1->name,
            'donor_email'    => $user1->email,
            'is_anonymous'   => false,
            'amount'         => 1500000,
            'message'        => 'Semoga saudara-saudara kita di Lumajang selalu diberikan kesehatan dan keselamatan.',
            'payment_method' => 'QRIS',
            'status'         => 'verified',
            'verified_at'    => now()->subHours(5),
        ]);

        Donation::create([
            'campaign_id'    => $campaign1->id,
            'user_id'        => null,
            'invoice_number' => 'NSK-20261023-0002',
            'donor_name'     => 'Budi Santoso',
            'donor_email'    => 'budi@example.com',
            'is_anonymous'   => true,
            'amount'         => 500000,
            'message'        => 'Titip doa dan sedikit rezeki untuk dapur umum di sana.',
            'payment_method' => 'Transfer BCA',
            'status'         => 'verified',
            'verified_at'    => now()->subHours(3),
        ]);

        Donation::create([
            'campaign_id'    => $campaign2->id,
            'user_id'        => $user2->id,
            'invoice_number' => 'NSK-20261023-0003',
            'donor_name'     => $user2->name,
            'donor_email'    => $user2->email,
            'is_anonymous'   => false,
            'amount'         => 2000000,
            'message'        => 'Semoga instalasi air bersihnya lekas rampung dan bermanfaat bagi warga.',
            'payment_method' => 'Transfer Mandiri',
            'status'         => 'verified',
            'verified_at'    => now()->subHours(2),
        ]);
    }
}