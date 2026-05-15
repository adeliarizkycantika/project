<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MakananResource\Pages;
use App\Models\Makanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MakananResource extends Resource
{
    protected static ?string $model = Makanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    protected static ?string $navigationGroup = 'Meal Planner';

    protected static ?string $navigationLabel = 'Makanan';

    protected static ?string $modelLabel = 'Makanan';

    protected static ?string $pluralModelLabel = 'Makanan';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Makanan')
                    ->schema([
                        Forms\Components\Select::make('kategori_makanan_id')
                            ->label('Kategori Makanan')
                            ->relationship('kategori', 'nama')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),

                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Makanan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar')
                            ->image()
                            ->directory('makanan')
                            ->imageEditor()
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Nutrisi')
                    ->schema([
                        Forms\Components\TextInput::make('kalori')
                            ->label('Kalori')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->suffix('kkal')
                            ->required(),

                        Forms\Components\TextInput::make('protein')
                            ->label('Protein')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->suffix('gram')
                            ->required(),

                        Forms\Components\TextInput::make('karbohidrat')
                            ->label('Karbohidrat')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->suffix('gram')
                            ->required(),

                        Forms\Components\TextInput::make('lemak')
                            ->label('Lemak')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->suffix('gram')
                            ->required(),
                    ])
                    ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->square(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Makanan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori.nama')
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
                    ->label('Karbohidrat')
                    ->suffix(' g')
                    ->sortable(),

                Tables\Columns\TextColumn::make('lemak')
                    ->label('Lemak')
                    ->suffix(' g')
                    ->sortable(),

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
                Tables\Filters\SelectFilter::make('kategori_makanan_id')
                    ->label('Kategori Makanan')
                    ->relationship('kategori', 'nama')
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
            ->emptyStateHeading('Belum ada data makanan')
            ->emptyStateDescription('Tambahkan data makanan untuk digunakan pada meal plan.')
            ->emptyStateIcon('heroicon-o-cake');
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