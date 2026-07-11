<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BahanMakananResource\Pages;
use App\Models\BahanMakanan;
use App\Models\Makanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class BahanMakananResource extends Resource
{
    protected static ?string $model = BahanMakanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Manajemen Makanan';

    protected static ?string $navigationLabel = 'Bahan Makanan';

    protected static ?string $modelLabel = 'Bahan Makanan';

    protected static ?string $pluralModelLabel = 'Bahan Makanan';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Bahan Makanan')
                    ->description('Isi bahan yang dibutuhkan untuk membuat sebuah menu makanan.')
                    ->schema([
                        Forms\Components\Select::make('makanan_id')
                            ->label('Menu Makanan')
                            ->options(fn (): array => Makanan::query()
                                ->orderBy('nama')
                                ->pluck('nama', 'id')
                                ->toArray())
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Bahan')
                            ->placeholder('Contoh: Dada ayam, nasi merah, telur, brokoli')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->minValue(0.1)
                                    ->default(1)
                                    ->required(),

                                Forms\Components\Select::make('satuan')
                                    ->label('Satuan')
                                    ->options([
                                        'gram' => 'gram',
                                        'kg' => 'kg',
                                        'ml' => 'ml',
                                        'liter' => 'liter',
                                        'pcs' => 'pcs',
                                        'buah' => 'buah',
                                        'butir' => 'butir',
                                        'ikat' => 'ikat',
                                        'potong' => 'potong',
                                        'sendok makan' => 'sendok makan',
                                        'sendok teh' => 'sendok teh',
                                        'porsi' => 'porsi',
                                    ])
                                    ->searchable()
                                    ->default('gram')
                                    ->required(),
                            ]),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->placeholder('Contoh: tanpa kulit, direbus, dicuci bersih')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('makanan.nama')
                    ->label('Menu Makanan')
                    ->searchable()
                    ->sortable()
                    ->limit(35),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Bahan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->formatStateUsing(function ($record): string {
                        $jumlah = $record->jumlah ?? 1;
                        $satuan = $record->satuan ?? 'pcs';

                        return number_format((float) $jumlah, 1, ',', '.') . ' ' . $satuan;
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(40)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('makanan_id')
                    ->label('Menu Makanan')
                    ->options(fn (): array => Makanan::query()
                        ->orderBy('nama')
                        ->pluck('nama', 'id')
                        ->toArray())
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $table = (new BahanMakanan())->getTable();

        if (Schema::hasTable($table) && Schema::hasColumn($table, 'makanan_id')) {
            $query->with('makanan');
        }

        return $query;
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