<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MealPlanItemResource\Pages;
use App\Models\MealPlan;
use App\Models\MealPlanItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MealPlanItemResource extends Resource
{
    protected static ?string $model = MealPlanItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Meal Planner';

    protected static ?string $navigationLabel = 'Detail Meal Plan';

    protected static ?string $modelLabel = 'Detail Meal Plan';

    protected static ?string $pluralModelLabel = 'Detail Meal Plan';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Detail Meal Plan')
                    ->schema([
                        Forms\Components\Select::make('meal_plan_id')
                            ->label('Meal Plan')
                            ->relationship('mealPlan', 'judul')
                            ->getOptionLabelFromRecordUsing(function (MealPlan $record): string {
                                $tanggal = $record->tanggal_rencana
                                    ? $record->tanggal_rencana->format('d M Y')
                                    : '-';

                                $user = $record->user?->name ?? 'Tanpa User';

                                return "{$record->judul} - {$user} - {$tanggal}";
                            })
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->createOptionForm([
                                Forms\Components\Select::make('user_id')
                                    ->label('User')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required(),

                                Forms\Components\TextInput::make('judul')
                                    ->label('Judul Meal Plan')
                                    ->default('Meal Plan Hari Ini')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\DatePicker::make('tanggal_rencana')
                                    ->label('Tanggal Rencana')
                                    ->default(now())
                                    ->native(false)
                                    ->required(),

                                Forms\Components\Textarea::make('catatan')
                                    ->label('Catatan')
                                    ->rows(3)
                                    ->nullable(),
                            ]),

                        Forms\Components\Select::make('makanan_id')
                            ->label('Makanan')
                            ->relationship('makanan', 'nama')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),

                        Forms\Components\Select::make('waktu_makan')
                            ->label('Waktu Makan')
                            ->options([
                                'sarapan' => 'Sarapan',
                                'makan_siang' => 'Makan Siang',
                                'makan_malam' => 'Makan Malam',
                                'snack' => 'Snack',
                            ])
                            ->native(false)
                            ->required(),

                        Forms\Components\TextInput::make('porsi')
                            ->label('Porsi')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),

                        Forms\Components\Toggle::make('sudah_dikonsumsi')
                            ->label('Sudah Dikonsumsi')
                            ->default(false)
                            ->live(),

                        Forms\Components\DateTimePicker::make('dikonsumsi_pada')
                            ->label('Dikonsumsi Pada')
                            ->native(false)
                            ->nullable()
                            ->visible(fn (Forms\Get $get): bool => (bool) $get('sudah_dikonsumsi')),

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
                Tables\Columns\TextColumn::make('mealPlan.judul')
                    ->label('Meal Plan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('mealPlan.user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('mealPlan.tanggal_rencana')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('makanan.nama')
                    ->label('Makanan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('waktu_makan')
                    ->label('Waktu Makan')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sarapan' => 'Sarapan',
                        'makan_siang' => 'Makan Siang',
                        'makan_malam' => 'Makan Malam',
                        'snack' => 'Snack',
                        default => $state,
                    })
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('porsi')
                    ->label('Porsi')
                    ->sortable(),

                Tables\Columns\TextColumn::make('makanan.kalori')
                    ->label('Kalori / Porsi')
                    ->suffix(' kkal')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_kalori')
                    ->label('Total Kalori')
                    ->getStateUsing(fn (MealPlanItem $record): int => $record->total_kalori)
                    ->suffix(' kkal'),

                Tables\Columns\IconColumn::make('sudah_dikonsumsi')
                    ->label('Dikonsumsi')
                    ->boolean(),

                Tables\Columns\TextColumn::make('dikonsumsi_pada')
                    ->label('Dikonsumsi Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('meal_plan_id')
                    ->label('Meal Plan')
                    ->relationship('mealPlan', 'judul')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('makanan_id')
                    ->label('Makanan')
                    ->relationship('makanan', 'nama')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('waktu_makan')
                    ->label('Waktu Makan')
                    ->options([
                        'sarapan' => 'Sarapan',
                        'makan_siang' => 'Makan Siang',
                        'makan_malam' => 'Makan Malam',
                        'snack' => 'Snack',
                    ]),

                Tables\Filters\TernaryFilter::make('sudah_dikonsumsi')
                    ->label('Status Konsumsi')
                    ->trueLabel('Sudah Dikonsumsi')
                    ->falseLabel('Belum Dikonsumsi'),
            ])
            ->actions([
                Tables\Actions\Action::make('toggleKonsumsi')
                    ->label(fn (MealPlanItem $record): string => $record->sudah_dikonsumsi ? 'Batalkan Konsumsi' : 'Tandai Dikonsumsi')
                    ->icon(fn (MealPlanItem $record): string => $record->sudah_dikonsumsi ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (MealPlanItem $record): string => $record->sudah_dikonsumsi ? 'danger' : 'success')
                    ->action(function (MealPlanItem $record): void {
                        $record->update([
                            'sudah_dikonsumsi' => ! $record->sudah_dikonsumsi,
                            'dikonsumsi_pada' => ! $record->sudah_dikonsumsi ? now() : null,
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
            ->emptyStateHeading('Belum ada detail meal plan')
            ->emptyStateDescription('Tambahkan makanan ke dalam meal plan.')
            ->emptyStateIcon('heroicon-o-list-bullet');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMealPlanItems::route('/'),
            'create' => Pages\CreateMealPlanItem::route('/create'),
            'edit' => Pages\EditMealPlanItem::route('/{record}/edit'),
        ];
    }
}