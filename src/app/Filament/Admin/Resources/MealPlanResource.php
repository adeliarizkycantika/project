<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MealPlanResource\Pages;
use App\Models\MealPlan;
use App\Services\GenerateDaftarBelanjaService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MealPlanResource extends Resource
{
    protected static ?string $model = MealPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Meal Planner';

    protected static ?string $navigationLabel = 'Meal Plan';

    protected static ?string $modelLabel = 'Meal Plan';

    protected static ?string $pluralModelLabel = 'Meal Plan';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Meal Plan')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),

                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Meal Plan')
                            ->placeholder('Contoh: Meal Plan Hari Ini')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('tanggal_rencana')
                            ->label('Tanggal Rencana')
                            ->native(false)
                            ->required(),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(4)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_rencana')
                    ->label('Tanggal Rencana')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jumlah Menu')
                    ->counts('items')
                    ->sortable(),

                Tables\Columns\TextColumn::make('item_daftar_belanja_count')
                    ->label('Item Belanja')
                    ->counts('itemDaftarBelanja')
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

                Tables\Filters\Filter::make('tanggal_rencana')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_dari')
                            ->label('Tanggal Dari')
                            ->native(false),

                        Forms\Components\DatePicker::make('tanggal_sampai')
                            ->label('Tanggal Sampai')
                            ->native(false),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['tanggal_dari'] ?? null,
                                fn ($query, $date) => $query->whereDate('tanggal_rencana', '>=', $date)
                            )
                            ->when(
                                $data['tanggal_sampai'] ?? null,
                                fn ($query, $date) => $query->whereDate('tanggal_rencana', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('generateDaftarBelanja')
                    ->label('Generate Belanja')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Generate Daftar Belanja')
                    ->modalDescription('Daftar belanja lama untuk meal plan ini akan diganti dengan data baru.')
                    ->modalSubmitActionLabel('Generate')
                    ->action(function (MealPlan $record): void {
                        $jumlahItem = app(GenerateDaftarBelanjaService::class)->generate($record);

                        if ($jumlahItem <= 0) {
                            Notification::make()
                                ->title('Daftar belanja tidak dibuat')
                                ->body('Meal plan ini belum memiliki detail makanan atau bahan makanan.')
                                ->warning()
                                ->send();

                            return;
                        }

                        Notification::make()
                            ->title('Daftar belanja berhasil dibuat')
                            ->body("Total {$jumlahItem} item belanja berhasil dibuat.")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada meal plan')
            ->emptyStateDescription('Tambahkan meal plan untuk membuat jadwal makan user.')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMealPlans::route('/'),
            'create' => Pages\CreateMealPlan::route('/create'),
            'edit' => Pages\EditMealPlan::route('/{record}/edit'),
        ];
    }
}