<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrinterResource\Pages;
use App\Models\Printer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PrinterResource extends Resource
{
    protected static ?string $model = Printer::class;

    protected static ?string $navigationIcon = 'heroicon-o-printer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('ip_address')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('printer_type_id')->relationship('printerType', 'name')->required(),
                Forms\Components\TextInput::make('serial_number')->maxLength(255),
                Forms\Components\TextInput::make('location')->maxLength(255),
                Forms\Components\TextInput::make('phone_extension')->maxLength(50),
                Forms\Components\Textarea::make('notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('ip_address')->sortable(),
                Tables\Columns\TextColumn::make('printerType.name')->label('Typ tiskárny')->sortable(),
                Tables\Columns\TextColumn::make('serial_number')->sortable(),
                Tables\Columns\TextColumn::make('location')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrinters::route('/'),
            'edit' => Pages\EditPrinter::route('/{record}/edit'),
        ];
    }
}
