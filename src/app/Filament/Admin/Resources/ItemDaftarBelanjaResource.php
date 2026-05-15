<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Pages;
use App\Filament\Admin\Resources\ItemDaftarBelanjaResource\RelationManagers;
use App\Models\ItemDaftarBelanja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemDaftarBelanjaResource extends Resource
{
    protected static ?string $model = ItemDaftarBelanja::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('meal_plan_id')
                    ->relationship('mealPlan', 'id')
                    ->default(null),
                Forms\Components\Select::make('bahan_makanan_id')
                    ->relationship('bahanMakanan', 'id')
                    ->default(null),
                Forms\Components\TextInput::make('nama_item')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('satuan')
                    ->maxLength(50)
                    ->default(null),
                Forms\Components\Toggle::make('sudah_dibeli')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mealPlan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bahanMakanan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_item')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('satuan')
                    ->searchable(),
                Tables\Columns\IconColumn::make('sudah_dibeli')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListItemDaftarBelanjas::route('/'),
            'create' => Pages\CreateItemDaftarBelanja::route('/create'),
            'edit' => Pages\EditItemDaftarBelanja::route('/{record}/edit'),
        ];
    }
}
