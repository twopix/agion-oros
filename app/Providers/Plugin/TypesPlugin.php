<?php

namespace App\Providers\Plugin;

use TomatoPHP\FilamentTypes\FilamentTypesPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentTypes\Resources\TypeResource;
use Filament\SpatieLaravelTranslatablePlugin;

class TypesPlugin extends FilamentTypesPlugin
{
    public function register(Panel $panel): void
    {
        $locals = getLocales();

        $panel
            ->plugin(
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales($locals),
            )
            ->resources([
            TypeResource::class
        ]);

    }
}
