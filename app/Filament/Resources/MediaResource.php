<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use App\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('collection_name')->label('Collection Name')->required(),
                Forms\Components\TextInput::make('name')->label('Name')->required(),
                Forms\Components\TextInput::make('file_name')->label('File Name')->required(),
                Forms\Components\TextInput::make('mime_type')->label('MIME Type')->nullable(),
                Forms\Components\Select::make('disk')
                    ->label('Disk')
                    ->options([
                        'local' => 'Local',
                        'public' => 'Public',
                        's3' => 'S3',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('size')->label('Size')->required(),
                Forms\Components\TextInput::make('order_column')->label('Order')->nullable(),
                Forms\Components\FileUpload::make('file_path')->label('File Path')->disk('public')->directory('uploads')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('collection_name')->label('Collection Name'),
                Tables\Columns\TextColumn::make('name')->label('Name'),
                Tables\Columns\TextColumn::make('file_name')->label('File Name'),
                Tables\Columns\TextColumn::make('mime_type')->label('MIME Type'),
                Tables\Columns\TextColumn::make('disk')->label('Disk'),
                Tables\Columns\TextColumn::make('size')->label('Size'),
                Tables\Columns\TextColumn::make('order_column')->label('Order')->sortable(),
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
            // Добавьте отношения, если необходимо
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
