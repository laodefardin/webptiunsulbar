<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSliderResource\Pages;
use App\Models\HeroSlider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSliderResource extends Resource
{
    protected static ?string $model = HeroSlider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return 'Gambar Slider';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pengaturan Gambar Slider')
                    ->description('Atur gambar utama dan teks yang akan tampil di halaman depan.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // 📸 Kolom kiri: preview gambar
                                Forms\Components\FileUpload::make('image_url')
                                    ->label('Gambar Utama')
                                    ->image()
                                    ->imageEditor()
                                    ->required()
                                    ->disk('public')
                                    ->directory('hero-sliders')
                                    ->columnSpan(1)
                                    ->previewable(true)
                                    ->imageResizeMode('cover')
                                    ->imagePreviewHeight('250px')
                                    ->extraAttributes([
                                        'class' => 'rounded-xl shadow-md border border-gray-200'
                                    ]),

                                // ✍️ Kolom kanan: teks title dan subtitle
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul (Opsional)')
                                            ->placeholder('Contoh: Selamat Datang di PTI Unsulbar')
                                            ->maxLength(255),

                                        Forms\Components\Textarea::make('subtitle')
                                            ->label('Subjudul (Opsional)')
                                            ->placeholder('Tambahkan deskripsi singkat atau pesan tambahan.')
                                            ->rows(3)
                                            ->maxLength(255),
                                    ])
                                    ->columnSpan(1)
                                    ->extraAttributes([
                                        'class' => 'p-4 bg-white rounded-xl border border-gray-100 shadow-sm'
                                    ]),
                            ]),
                    ])
                    ->collapsible()
                    ->compact(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->circular() // tampilan bulat modern
                    ->height('80px')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->weight('bold')
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Subjudul')
                    ->color('gray')
                    ->wrap()
                    ->limit(50),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->striped()
            ->paginated([5, 10, 25])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->color('danger'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Slider')
            ->emptyStateDescription('Tambahkan gambar slider untuk halaman utama.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSliders::route('/'),
            'create' => Pages\CreateHeroSlider::route('/create'),
            'edit' => Pages\EditHeroSlider::route('/{record}/edit'),
        ];
    }
}
