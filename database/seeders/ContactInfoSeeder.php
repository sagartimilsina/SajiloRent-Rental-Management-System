<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactInfo;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInfo::create([
            'address' => 'pokhara-3,Kaski,Nepal',
            'phone' => '9779819113548',
            'phone_2' => '9779816636727',

            'email' => 'sajilorent@gmail.com',
            'email_2' => 'timilsinasagar04@gmail.com',
            'social_links' => json_encode([
                ['name' => 'Facebook', 'link' => 'https://www.facebook.com/sagar.timilsina.923', 'icon' => 'fab fa-facebook'],
                ['name' => 'Twitter', 'link' => 'https://x.com/yu1234510?mx=2', 'icon' => 'fab fa-twitter'],
                ['name' => 'LinkedIn', 'link' => 'https://www.linkedin.com/in/prakrititimilsina-dynamicpt/?originalSubdomain=np', 'icon' => 'fab fa-linkedin']
            ]),
        ]);
    }
}
