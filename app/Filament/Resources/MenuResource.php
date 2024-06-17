<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Name')->required(),
                Forms\Components\Select::make('type')->label('Type')->options([
                    'link' => 'Link',
                    'page' => 'Page',
                ])->required(),
                Forms\Components\Select::make('lang')->label('Language')->options(
                    config('language.lang')
                )->required()->default('en'),
                Forms\Components\TextInput::make('link')->label('Link')->nullable(),
                Forms\Components\TextInput::make('order')->label('Order')->default(0),
                Forms\Components\TextInput::make('icon')->label('Icon')->nullable(),
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Menu')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name')
                    ->formatStateUsing(function ($state, $record) {
                        if($record->parent_id > 0) {
                            return '—>' . ' ' . $state;
                        }

                        return $state;
                    }),
                Tables\Columns\TextColumn::make('parent_id')
                    ->label('Parent')
                    ->formatStateUsing(function ($state, $record) {
                        $parent = $record->parent;
                        return $parent ? ' ' . $parent->name .' -> '.$record->name : 'Root';
                    }),  
                Tables\Columns\TextColumn::make('type')->label('Type'),
                Tables\Columns\TextColumn::make('lang')->label('Language'),
                Tables\Columns\TextColumn::make('link')->label('Link'),
                Tables\Columns\TextColumn::make('order')->label('Order')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
