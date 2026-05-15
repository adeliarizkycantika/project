<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MealPlanItemResource\Pages;
use App\Filament\Admin\Resources\MealPlanItemResource\RelationManagers;
use App\Models\MealPlanItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MealPlanItemResource extends Resource
{
    protected static ?string $model = MealPlanItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('meal_plan_id')
                    ->relationship('mealPlan', 'id')
                    ->required(),
                Forms\Components\Select::make('makanan_id')
                    ->relationship('makanan', 'id')
                    ->required(),
                Forms\Components\TextInput::make('waktu_makan')
                    ->required(),
                Forms\Components\TextInput::make('porsi')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Toggle::make('sudah_dikonsumsi')
                    ->required(),
                Forms\Components\DateTimePicker::make('dikonsumsi_pada'),
                Forms\Components\Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mealPlan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('makanan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_makan'),
                Tables\Columns\TextColumn::make('porsi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('sudah_dikonsumsi')
                    ->boolean(),
                Tables\Columns\TextColumn::make('dikonsumsi_pada')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListMealPlanItems::route('/'),
            'create' => Pages\CreateMealPlanItem::route('/create'),
            'edit' => Pages\EditMealPlanItem::route('/{record}/edit'),
        ];
    }
}
