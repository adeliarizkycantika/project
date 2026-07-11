<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MakananResource\Pages;
use App\Models\KategoriMakanan;
use App\Models\Makanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MakananResource extends Resource
{
    protected static ?string $model = Makanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Makanan';

    protected static ?string $modelLabel = 'Makanan';

    protected static ?string $pluralModelLabel = 'Makanan';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Makanan')
                    ->description('Data utama makanan yang digunakan pada meal plan dan rekomendasi menu.')
                    ->schema([
                        Forms\Components\Select::make('kategori_makanan_id')
                            ->label('Kategori Makanan')
                            ->options(fn () => KategoriMakanan::query()->pluck('nama', 'id')->toArray())
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Makanan')
                            ->placeholder('Contoh: Nasi Merah Ayam Panggang')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Tuliskan deskripsi singkat makanan.')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Nutrisi')
                    ->description('Masukkan nilai nutrisi per satu porsi makanan.')
                    ->schema([
                        Forms\Components\TextInput::make('kalori')
                            ->label('Kalori')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->suffix('kkal'),

                        Forms\Components\TextInput::make('protein')
                            ->label('Protein')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->suffix('gram'),

                        Forms\Components\TextInput::make('karbohidrat')
                            ->label('Karbohidrat')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->suffix('gram'),

                        Forms\Components\TextInput::make('lemak')
                            ->label('Lemak')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->suffix('gram'),
                    ])
                    ->columns(4),

                Forms\Components\Section::make('Pengaturan Rekomendasi')
                    ->description('Atur apakah makanan ini akan muncul sebagai rekomendasi di dashboard user.')
                    ->schema([
                        Forms\Components\Toggle::make('is_recommended')
                            ->label('Jadikan Menu Rekomendasi')
                            ->helperText('Aktifkan agar makanan ini muncul pada bagian Rekomendasi Menu Sehat.')
                            ->default(false),

                        Forms\Components\Toggle::make('is_public')
                            ->label('Tampilkan untuk Semua User')
                            ->helperText('Aktifkan agar makanan ini bisa dilihat oleh semua user.')
                            ->default(true),

                        Forms\Components\Textarea::make('recommended_note')
                            ->label('Catatan Rekomendasi')
                            ->placeholder('Contoh: Cocok untuk sarapan tinggi protein dan rendah lemak.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Makanan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategoriMakanan.nama')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kalori')
                    ->label('Kalori')
                    ->suffix(' kkal')
                    ->sortable(),

                Tables\Columns\TextColumn::make('protein')
                    ->label('Protein')
                    ->suffix(' g')
                    ->sortable(),

                Tables\Columns\TextColumn::make('karbohidrat')
                    ->label('Karbo')
                    ->suffix(' g')
                    ->sortable(),

                Tables\Columns\TextColumn::make('lemak')
                    ->label('Lemak')
                    ->suffix(' g')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_recommended')
                    ->label('Rekomendasi')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_public')
                    ->label('Publik')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_recommended')
                    ->label('Menu Rekomendasi'),

                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Menu Publik'),

                Tables\Filters\SelectFilter::make('kategori_makanan_id')
                    ->label('Kategori')
                    ->options(fn () => KategoriMakanan::query()->pluck('nama', 'id')->toArray()),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMakanans::route('/'),
            'create' => Pages\CreateMakanan::route('/create'),
            'edit' => Pages\EditMakanan::route('/{record}/edit'),
        ];
    }
}