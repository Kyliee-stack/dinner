<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [

            // --- MAKANAN BERAT ---
            [
                'nama' => 'NASI AYAM BLACKPEPPER',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 20000,
                'deskripsi' => 'Ricebowl: Ayam Blackpepper spesial.',
                'image' => 'nasi_ayam.jpg',
            ],
            [
                'nama' => 'NASI AYAM TERIYAKI',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 20000,
                'deskripsi' => 'Ricebowl: Ayam Teriyaki dengan saus manis gurih.',
                'image' => 'teriyaki.jpg',
            ],
            [
                'nama' => 'NASI AYAM SALTED EGG + TELUR',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 20000,
                'deskripsi' => 'Ricebowl: Nasi Ayam Salted Egg dengan telur.',
                'image' => 'salted_egg.jpg',
            ],
            [
                'nama' => 'NASI TELOR PONTIANAK CHILIPADI',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 15000,
                'deskripsi' => 'Nasi dengan Telur Pontianak dan sambal Chilipadi.',
                'image' => 'nasi_telur_pontianak.jpg',
            ],
            [
                'nama' => 'MANGGA STICKY RICE',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 20000,
                'deskripsi' => 'Dessert: Nasi ketan dengan santan dan mangga segar.',
                'image' => 'mango_sticky_rice.jpg',
            ],
            [
                'nama' => 'PUDING CARAMEL LUMER',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 10000,
                'deskripsi' => 'Puding caramel lembut dengan saus lumer.',
                'image' => 'puding_karamel.jpg',
            ],
            [
                'nama' => 'INDOMIE KUAH',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 10000,
                'deskripsi' => 'Indomie klasik.',
                'image' => 'indomie_kuah.jpg',
            ],
            [
                'nama' => 'INDOMIE GORENG',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 10000,
                'deskripsi' => 'Indomie klasik.',
                'image' => 'indomie_goreng.jpg',
            ],
            [
                'nama' => 'INDOMIE RICA-RICA',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 12000,
                'deskripsi' => 'Indomie dengan bumbu Rica-Rica pedas.',
                'image' => 'indomie_rica.jpg',
            ],
            [
                'nama' => 'PANCONG REGAL',
                'category' => 'MAKANAN BERAT (Mie, Nasi, Roti)',
                'harga' => 12000,
                'deskripsi' => 'Pancog dengan remahan biskuit Regal.',
                'image' => 'pancong_regal.jpg',
            ],

            // --- DIMSUM & SNACK ---
            [
                'nama' => 'DIMSUM GORENG KEJU LUMER',
                'category' => 'DIMSUM & SNACK',
                'harga' => 15000,
                'deskripsi' => 'Dimsum keju lumer.',
                'image' => 'dimsum_keju_lumer.jpg',
            ],
            [
                'nama' => 'DIMSUM MENTAI',
                'category' => 'DIMSUM & SNACK',
                'harga' => 15000,
                'deskripsi' => 'Dimsum kukus topping mentai.',
                'image' => 'dimsum_mentai.jpg',
            ],
            [
                'nama' => 'DIMSUM MOZARELLA',
                'category' => 'DIMSUM & SNACK',
                'harga' => 15000,
                'deskripsi' => 'Dimsum mozarella.',
                'image' => 'dimsum_mozarella.jpg',
            ],
            [
                'nama' => 'TAHU BASO',
                'category' => 'DIMSUM & SNACK',
                'harga' => 10000,
                'deskripsi' => 'Tahu dengan isian baso ikan.',
                'image' => 'tahu_baso.jpg',
            ],
            [
                'nama' => 'KENTANG SAUS KEJU',
                'category' => 'DIMSUM & SNACK',
                'harga' => 10000,
                'deskripsi' => 'Kentang goreng saus keju.',
                'image' => 'kentang_saus_keju.jpg',
            ],
            [
                'nama' => 'CHICKEN WINGS',
                'category' => 'DIMSUM & SNACK',
                'harga' => 15000,
                'deskripsi' => 'Sayap ayam goreng.',
                'image' => 'chicken_wings.jpg',
            ],
            [
                'nama' => 'MIX PLATTER A',
                'category' => 'DIMSUM & SNACK',
                'harga' => 15000,
                'deskripsi' => 'Tahu Baso + Chitato + Kentang.',
                'image' => 'platter_a.jpg',
            ],

            // --- KOPI BASED ---
            [
                'nama' => 'ES KOPI SUSU GULA AREN',
                'category' => 'KOPI BASED',
                'harga' => 15000,
                'deskripsi' => 'Kopi susu gula aren.',
                'image' => 'kopi_gula_aren.jpg',
            ],
            [
                'nama' => 'ES KOPI SUSU SIMANTAN',
                'category' => 'KOPI BASED',
                'harga' => 13000,
                'deskripsi' => 'Signature Simantan.',
                'image' => 'kopi_susu_simantan.jpg',
            ],
            [
                'nama' => 'AMERICANO (KALIBRASI)',
                'category' => 'KOPI BASED',
                'harga' => 10000,
                'deskripsi' => 'Kopi hitam.',
                'image' => 'americano.jpg',
            ],
            [
                'nama' => 'COCONUT AREN LATTE',
                'category' => 'KOPI BASED',
                'harga' => 15000,
                'deskripsi' => 'Latte santan + aren.',
                'image' => 'coconut_latte.jpg',
            ],
            [
                'nama' => 'COOKIES LATTE',
                'category' => 'KOPI BASED',
                'harga' => 15000,
                'deskripsi' => 'Latte cookies.',
                'image' => 'oreo_latte.jpg',
            ],
            [
                'nama' => 'AMERICANO LEMON',
                'category' => 'KOPI BASED',
                'harga' => 12000,
                'deskripsi' => 'Americano + lemon.',
                'image' => 'americano_lemon.jpg',
            ],
            [
                'nama' => 'HOT CAPPUCCINO',
                'category' => 'KOPI BASED',
                'harga' => 15000,
                'deskripsi' => 'Cappuccino panas.',
                'image' => 'hot_cappuccino.jpg',
            ],
            [
                'nama' => 'ESPRESSO ON THE ROCK',
                'category' => 'KOPI BASED',
                'harga' => 12000,
                'deskripsi' => 'Espresso + ice.',
                'image' => 'espresso_rock.jpg',
            ],
            [
                'nama' => 'Kopi Susu Dalgona Aren Regal',
                'category' => 'KOPI BASED',
                'harga' => 18000,
                'deskripsi' => 'Dalgona + regal + aren.',
                'image' => 'dalgona_regal.jpg',
            ],

            // --- MATCHA & TEA ---
            [
                'nama' => 'MATCHA LATTE',
                'category' => 'MATCHA & TEA BASED',
                'harga' => 15000,
                'deskripsi' => 'Matcha latte premium.',
                'image' => 'matcha_latte.jpg',
            ],
            [
                'nama' => 'MATCHA LATTE CARAMEL',
                'category' => 'MATCHA & TEA BASED',
                'harga' => 18000,
                'deskripsi' => 'Matcha caramel.',
                'image' => 'matcha_caramel.jpg',
            ],
            [
                'nama' => 'FRESH MANGO MATCHA LATTE',
                'category' => 'MATCHA & TEA BASED',
                'harga' => 18000,
                'deskripsi' => 'Matcha + mango fresh.',
                'image' => 'mango_matcha.jpg',
            ],
            [
                'nama' => 'THAI TEA MATCHA LATTE',
                'category' => 'MATCHA & TEA BASED',
                'harga' => 18000,
                'deskripsi' => 'Thai tea + matcha.',
                'image' => 'thai_tea_matcha.jpg',
            ],
            [
                'nama' => 'THAI TEA ICE',
                'category' => 'MATCHA & TEA BASED',
                'harga' => 15000,
                'deskripsi' => 'Es thai tea.',
                'image' => 'thai_tea.jpg',
            ],
            [
                'nama' => 'SUMMER MANGO TEA (MOCKTAIL)',
                'category' => 'MATCHA & TEA BASED',
                'harga' => 15000,
                'deskripsi' => 'Mocktail mango tea.',
                'image' => 'mango_tea.jpg',
            ],

            // --- SUSU & LAINNYA ---
            [
                'nama' => 'MILKSHAKE JUMBO SIZE',
                'category' => 'SUSU & LAINNYA',
                'harga' => 15000,
                'deskripsi' => 'Milkshake jumbo.',
                'image' => 'milk_shake_jumbo.jpg',
            ],
            [
                'nama' => 'KOREAN MANGGO MILK',
                'category' => 'SUSU & LAINNYA',
                'harga' => 15000,
                'deskripsi' => 'Korean mango milk.',
                'image' => 'mango_milk.jpg',
            ],
            [
                'nama' => 'SMOOTHIES BERRY',
                'category' => 'SUSU & LAINNYA',
                'harga' => 18000,
                'deskripsi' => 'Smoothies berry.',
                'image' => 'smoothie_berry.jpg',
            ],
            [
                'nama' => 'SMOOTHIES MANGO',
                'category' => 'SUSU & LAINNYA',
                'harga' => 18000,
                'deskripsi' => 'Smoothies mango.',
                'image' => 'smoothies_mango.jpg',
            ],
            [
                'nama' => 'LEMONADE',
                'category' => 'SUSU & LAINNYA',
                'harga' => 15000,
                'deskripsi' => 'Lemonade segar.',
                'image' => 'lemonade.jpg',
            ],
            [
                'nama' => 'PURE WATER (AIR MINERAL + ICE)',
                'category' => 'SUSU & LAINNYA',
                'harga' => 5000,
                'deskripsi' => 'Air mineral dingin.',
                'image' => 'pure_water.jpg',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
