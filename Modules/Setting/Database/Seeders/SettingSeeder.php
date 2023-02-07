<?php

namespace Modules\Setting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Setting::query()->updateOrCreate([
            'title' => 'عنوان سایت',
            'description' => 'توضیحات سایت',
            'keywords' => 'کلمات کلیدی سایت',
            'logo' => 'logo.png',
            'icon' => 'icon.png'
        ]);
    }
}
