<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ItemDaftarBelanjaResource\Pages;
use App\Models\ItemDaftarBelanja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ItemDaftarBelanjaResource extends Resource
{
    protected static ?string $model = ItemDaftarBelanja::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Meal Planner';

    protected static ?string $navigationLabel = 'Daftar Belanja';

    protected static ?string $modelLabel = 'Item Daftar Belanja';

    protected static ?string $pluralModelLabel = 'Daftar Belanja';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Daftar Belanja')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),

                        Forms\Components\Select::make('meal_plan_id')
                            ->label('Meal Plan')
                            ->relationship('mealPlan', 'judul')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->nullable(),

                        Forms\Components\Select::make('bahan_makanan_id')
                            ->label('Bahan Makanan')
                            ->relationship('bahanMakanan', 'nama')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->nullable(),

                        Forms\Components\TextInput::make('nama_item')
                            ->label('Nama Item')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(0)
                            ->nullable(),

                        Forms\Components\TextInput::make('satuan')
                            ->label('Satuan')
                            ->placeholder('gram, kg, pcs, ml')
                            ->maxLength(50)
                            ->nullable(),

                        Forms\Components\Toggle::make('sudah_dibeli')
                            ->label('Sudah Dibeli')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('sudah_dibeli')
                    ->label('Dibeli')
                    ->boolean(),

                Tables\Columns\TextColumn::make('nama_item')
                    ->label('Nama Item')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('satuan')
                    ->label('Satuan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('mealPlan.judul')
                    ->label('Meal Plan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('mealPlan.tanggal_rencana')
                    ->label('Tanggal Meal Plan')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
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
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('meal_plan_id')
                    ->label('Meal Plan')
                    ->relationship('mealPlan', 'judul')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('sudah_dibeli')
                    ->label('Status Belanja')
                    ->trueLabel('Sudah Dibeli')
                    ->falseLabel('Belum Dibeli'),
            ])
            ->actions([
                Tables\Actions\Action::make('toggleDibeli')
                    ->label(fn (ItemDaftarBelanja $record): string => $record->sudah_dibeli ? 'Batalkan Dibeli' : 'Tandai Dibeli')
                    ->icon(fn (ItemDaftarBelanja $record): string => $record->sudah_dibeli ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (ItemDaftarBelanja $record): string => $record->sudah_dibeli ? 'danger' : 'success')
                    ->action(function (ItemDaftarBelanja $record): void {
                        $record->update([
                            'sudah_dibeli' => ! $record->sudah_dibeli,
                        ]);
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada daftar belanja')
            ->emptyStateDescription('Generate daftar belanja dari meal plan atau tambahkan manual.')
            ->emptyStateIcon('heroicon-o-shopping-cart');
    }

    public static function getRelations(): array
    {
        return [];
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