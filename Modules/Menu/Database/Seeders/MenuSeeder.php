<?php

namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Menu\Entities\Menu;

class MenuSeeder extends Seeder
{

    /**
     * @return void
     */
    public function run(): void
    {
        $this->seedMenus();
    }

    /**
     * @return void
     */
    private function seedMenus(): void
    {
        foreach (Menu::$menus as $menu) {
            Menu::query()->updateOrCreate([
                'name' => $menu['name'],
                'url' => $menu['url'],
                'status' => $menu['status'],
            ]);
        }
    }
}
