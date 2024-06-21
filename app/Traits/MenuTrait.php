<?php

namespace App\Traits;

use App\Models\Menu;

trait MenuTrait
{
    public function get_menu()
    {
        $menus = Menu::getMenu();
        return $menus;
    }
}
