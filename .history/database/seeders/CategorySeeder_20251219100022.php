<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Kategori spesifik Inventaris Multimedia
        $categories = [
            'Kamera',           // DSLR, Mirrorless, Camcorder
            'Lensa',            // Wide, Tele, Prime, Kit
            'Lighting',         // Studio lamp, LED, Softbox
            'Audio',            // Microphone, Clip-on, Recorder
            'Tripod & Stabilizer', // Tripod, Monopod, Gimbal
            'Kabel & Konektor', // HDMI, XLR, Roll Kabel
            'Aksesoris Lain',   // Tas, Memory Card, Baterai
        ];

        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }
    }
}