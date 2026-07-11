<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use App\Services\CalorieCalculatorService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Manajemen User';

    protected static ?string $navigationLabel = 'Data User';

    protected static ?string $modelLabel = 'User';

    protected static ?string $pluralModelLabel = 'Data User';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->description('Data utama akun user.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(
                                table: 'users',
                                column: 'email',
                                ignoreRecord: true
                            )
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->options(self::getRoleOptions())
                            ->searchable()
                            ->default('user')
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->maxLength(255)
                            ->dehydrated(function ($state): bool {
                                return filled($state);
                            })
                            ->required(function (string $operation): bool {
                                return $operation === 'create';
                            })
                            ->helperText('Kosongkan saat edit jika tidak ingin mengganti password.'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Data Tubuh')
                    ->description('Data ini digunakan untuk menghitung kebutuhan kalori harian user.')
                    ->schema([
                        Forms\Components\Select::make('gender')
                            ->label('Gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('age')
                            ->label('Usia')
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(100)
                            ->suffix('tahun')
                            ->required(),

                        Forms\Components\TextInput::make('height_cm')
                            ->label('Height')
                            ->numeric()
                            ->minValue(100)
                            ->maxValue(250)
                            ->suffix('cm')
                            ->required(),

                        Forms\Components\TextInput::make('weight_kg')
                            ->label('Berat Badan')
                            ->numeric()
                            ->minValue(25)
                            ->maxValue(300)
                            ->suffix('kg')
                            ->required(),

                        Forms\Components\Select::make('activity_level')
                            ->label('Activity Level')
                            ->options(self::getActivityLevelOptions())
                            ->searchable()
                            ->required(),

                        Forms\Components\TextInput::make('daily_calorie_target')
                            ->label('Daily Calorie Target')
                            ->numeric()
                            ->suffix('kkal')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Nilai ini dihitung otomatis setelah data user disimpan.'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(function (?string $state): string {
                        return match ($state) {
                            'admin' => 'Admin',
                            'user' => 'User',
                            default => $state ? ucfirst($state) : '-',
                        };
                    })
                    ->color(function (?string $state): string {
                        return match ($state) {
                            'admin' => 'danger',
                            'user' => 'success',
                            default => 'gray',
                        };
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('gender_label')
                    ->label('Gender')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('age')
                    ->label('Usia')
                    ->suffix(' tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('height_cm')
                    ->label('Height')
                    ->suffix(' cm')
                    ->sortable(),

                Tables\Columns\TextColumn::make('weight_kg')
                    ->label('Berat')
                    ->formatStateUsing(function ($state): string {
                        if (! $state) {
                            return '-';
                        }

                        return number_format((float) $state, 1, ',', '.') . ' kg';
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('activity_level_label')
                    ->label('Aktivitas')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('daily_calorie_target')
                    ->label('Target Kalori')
                    ->formatStateUsing(function ($state): string {
                        if (! $state) {
                            return '-';
                        }

                        return number_format((int) $state, 0, ',', '.') . ' kkal';
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->options(self::getRoleOptions()),

                Tables\Filters\SelectFilter::make('gender')
                    ->label('Gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),

                Tables\Filters\SelectFilter::make('activity_level')
                    ->label('Activity Level')
                    ->options(self::getActivityLevelOptions()),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->visible(function (User $record): bool {
                        return Auth::id() !== (int) $record->getKey();
                    }),
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
        return parent::getEloquentQuery()
            ->with('roles');
    }

    public static function getRoleOptions(): array
    {
        return [
            'admin' => 'Admin',
            'user' => 'User',
        ];
    }

    public static function getActivityLevelOptions(): array
    {
        return CalorieCalculatorService::ACTIVITY_LABELS;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}