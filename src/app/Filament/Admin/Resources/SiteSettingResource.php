<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Tampilan Website';

    protected static ?string $modelLabel = 'Pengaturan Tampilan';

    protected static ?string $pluralModelLabel = 'Pengaturan Tampilan';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'site_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Website')
                    ->description(
                        'Atur nama website, subjudul, logo, dan background halaman autentikasi.'
                    )
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Nama Website')
                            ->placeholder('Pola Makan Sehat')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('site_subtitle')
                            ->label('Subjudul Website')
                            ->placeholder('Meal Planner & Kalori Harian')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('logo_path')
                            ->label('Logo Website')
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('180')
                            ->disk('public')
                            ->directory('site-settings/logos')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->helperText(
                                'Gunakan gambar persegi. Format JPG, PNG, atau WebP. Maksimal 2 MB.'
                            ),

                        Forms\Components\FileUpload::make('auth_background_path')
                            ->label('Background Login dan Register')
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('260')
                            ->disk('public')
                            ->directory('site-settings/backgrounds')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->helperText(
                                'Gunakan gambar landscape minimal 1600 × 1000 piksel. Maksimal 5 MB.'
                            ),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(
                        asset('images/logo-pola-makan-sehat.png')
                    ),

                Tables\Columns\TextColumn::make('site_name')
                    ->label('Nama Website')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('site_subtitle')
                    ->label('Subjudul')
                    ->limit(45),

                Tables\Columns\ImageColumn::make('auth_background_path')
                    ->label('Background')
                    ->disk('public')
                    ->height(70)
                    ->width(120),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit Tampilan'),
            ])
            ->bulkActions([]);
    }

    public static function canCreate(): bool
    {
        return ! SiteSetting::query()->exists();
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}