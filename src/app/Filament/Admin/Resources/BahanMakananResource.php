<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BahanMakananResource\Pages;
use App\Models\BahanMakanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BahanMakananResource extends Resource
{
    protected static ?string $model = BahanMakanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Meal Planner';

    protected static ?string $navigationLabel = 'Bahan Makanan';

    protected static ?string $modelLabel = 'Bahan Makanan';

    protected static ?string $pluralModelLabel = 'Bahan Makanan';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Bahan Makanan')
                    ->schema([
                        Forms\Components\Select::make('makanan_id')
                            ->label('Makanan')
                            ->relationship('makanan', 'nama')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),

                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Bahan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(0)
                            ->nullable(),

                        Forms\Components\TextInput::make('satuan')
                            ->label('Satuan')
                            ->placeholder('gram, kg, pcs, sdm, sdt')
                            ->maxLength(50)
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('makanan.nama')
                    ->label('Makanan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Bahan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('satuan')
                    ->label('Satuan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('makanan_id')
                    ->label('Makanan')
                    ->relationship('makanan', 'nama')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada bahan makanan')
            ->emptyStateDescription('Tambahkan bahan makanan berdasarkan menu yang tersedia.')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBahanMakanans::route('/'),
            'create' => Pages\CreateBahanMakanan::route('/create'),
            'edit' => Pages\EditBahanMakanan::route('/{record}/edit'),
        ];
    }
}