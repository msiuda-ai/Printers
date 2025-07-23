<?php

namespace App\Filament\Resources;

use App\Models\Toner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class TonerResource extends Resource
{
    protected static ?string $model = Toner::class;
    protected static ?string $navigationIcon = 'heroicon-o-color-swatch';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\ColorPicker::make('color')->required(),
            Forms\Components\TextInput::make('stock_count')->numeric()->required(),
            Forms\Components\TextInput::make('barcode')->required(),
            Forms\Components\TextInput::make('price')->numeric()->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('color')->color(),
            Tables\Columns\TextColumn::make('stock_count'),
            Tables\Columns\TextColumn::make('price')->money('CZK'),
        ])->actions(Tables\Actions\EditAction::make());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListToners::route('/'),
            'edit' => Pages\EditToner::route('/{record}/edit'),
        ];
    }
}
