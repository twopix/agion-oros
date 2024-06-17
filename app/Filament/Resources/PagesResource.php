<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PagesResource\Pages;
use App\Filament\Resources\PagesResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PagesResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Name')->required(),
                Forms\Components\TextInput::make('slug')->label('Slug')->required(),
                Forms\Components\RichEditor::make('content')
                    ->label('Content')
                    ->required()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('uploads'),
                Forms\Components\Textarea::make('intro')->label('Intro')->nullable(),
                Forms\Components\Select::make('type')->label('Type')->options([
                    'link' => 'Link',
                    'page' => 'Page',
                ])->required(),
                Forms\Components\Select::make('menu_id')->label('Menu')->relationship('menu', 'name')->nullable(),
                Forms\Components\FileUpload::make('featured_image')->label('Featured Image')->directory('featured-images')->nullable(),
                Forms\Components\TextInput::make('meta_title')->label('Meta Title')->nullable(),
                Forms\Components\Textarea::make('meta_keywords')->label('Meta Keywords')->nullable(),
                Forms\Components\Textarea::make('meta_description')->label('Meta Description')->nullable(),
                Forms\Components\TextInput::make('meta_og_image')->label('Meta OG Image')->nullable(),
                Forms\Components\TextInput::make('meta_og_url')->label('Meta OG URL')->nullable(),
                Forms\Components\TextInput::make('hits')->label('Hits')->default(0)->disabled(),
                Forms\Components\TextInput::make('order')->label('Order')->nullable(),
                Forms\Components\Toggle::make('status')->label('Status')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('slug')->label('Slug'),
                Tables\Columns\TextColumn::make('type')->label('Type'),
                Tables\Columns\TextColumn::make('menu.name')->label('Menu'),
                Tables\Columns\TextColumn::make('meta_title')->label('Meta Title'),
                Tables\Columns\TextColumn::make('hits')->label('Hits')->sortable(),
            ])
            ->filters([
                // Добавьте фильтры, если необходимо
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePages::route('/create'),
            'edit' => Pages\EditPages::route('/{record}/edit'),
        ];
    }
}
