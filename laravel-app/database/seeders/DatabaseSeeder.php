<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\EventItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create or update Super Admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('FF@!123'),
            ]
        );

        // 2. Default Frontend Settings
        $defaultSettings = [
            'site_title'        => 'Free Fire – Dunia Mistis Halloween Event',
            'event_title'       => 'DUNIA MISTIS',
            'event_subtitle'    => 'AMBIL ITEM SPESIAL EVENT FREE FIRE',
            'banner_image'      => 'images/banner_full_hd.png',
            'ticker_text'       => 'UID 281938*** Berhasil mengklaim Hollow Man Bundle! | UID 592810*** Berhasil mengklaim M1887 - ONEPUCHN! | UID 103984*** Berhasil mengklaim Crismon Glitches B.! | UID 489201*** Berhasil mengklaim M1887 - RAPPER M.! | UID 729103*** Berhasil mengklaim M1014 - GREEN FLA.!',
            'event_status'      => 'active',
            'telegram_token'    => '',
            'telegram_chat_id'  => '',
            'telegram_enabled'  => '0',
            'email_destination' => '',
            'email_enabled'     => '0',
            'footer_copyright'  => '© Garena International I Private Limited. Tradenames and trademarks are property of their respective owners.',
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => 'general']);
        }

        // 3. Default Event Items (9 items)
        $items = [
            [
                'name'       => 'Hollow Man Bundle',
                'short_name' => 'Hollow Man Bundle',
                'image'      => 'images/item_hd_1.png',
                'type'       => 'Bundle Eksklusif',
                'order'      => 1,
                'is_active'  => true,
            ],
            [
                'name'       => 'Crismon Glitches B.',
                'short_name' => 'Crismon Glitches B.',
                'image'      => 'images/item_hd_2.png',
                'type'       => 'Bundle Legendaris',
                'order'      => 2,
                'is_active'  => true,
            ],
            [
                'name'       => 'Cotton Teddy Bundl.',
                'short_name' => 'Cotton Teddy Bundl.',
                'image'      => 'images/item_hd_3.png',
                'type'       => 'Bundle Langka',
                'order'      => 3,
                'is_active'  => true,
            ],
            [
                'name'       => 'M1887 - ONEPUCHN.',
                'short_name' => 'M1887 - ONEPUCHN.',
                'image'      => 'images/item_hd_4.png',
                'type'       => 'Skin Senjata Tier S',
                'order'      => 4,
                'is_active'  => true,
            ],
            [
                'name'       => 'M1887 - RAPPER M.',
                'short_name' => 'M1887 - RAPPER M.',
                'image'      => 'images/item_hd_5.png',
                'type'       => 'Skin Senjata Tier S',
                'order'      => 5,
                'is_active'  => true,
            ],
            [
                'name'       => 'M1187 - HAND OF H.',
                'short_name' => 'M1187 - HAND OF H.',
                'image'      => 'images/item_hd_6.png',
                'type'       => 'Skin Senjata Tier S',
                'order'      => 6,
                'is_active'  => true,
            ],
            [
                'name'       => 'M1014 - GREEN FLA.',
                'short_name' => 'M1014 - GREEN FLA.',
                'image'      => 'images/item_hd_7.png',
                'type'       => 'Skin Senjata Tier S',
                'order'      => 7,
                'is_active'  => true,
            ],
            [
                'name'       => 'M1887 - STERLING.',
                'short_name' => 'M1887 - STERLING.',
                'image'      => 'images/item_hd_8.png',
                'type'       => 'Skin Senjata Tier S',
                'order'      => 8,
                'is_active'  => true,
            ],
            [
                'name'       => 'AN94 - EVIL HOWLE.',
                'short_name' => 'AN94 - EVIL HOWLE.',
                'image'      => 'images/item_hd_9.png',
                'type'       => 'Skin Senjata Tier S',
                'order'      => 9,
                'is_active'  => true,
            ],
        ];

        foreach ($items as $item) {
            EventItem::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
