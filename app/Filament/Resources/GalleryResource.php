<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Grid::make(2) // 🔹 Dua kolom sejajar
                ->schema([
                    // 👉 Kiri: Upload Gambar
                    Forms\Components\Section::make('Upload Gambar')
                        ->description('Unggah gambar galeri dengan resolusi tinggi.')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\FileUpload::make('image_url')
                                ->label('Gambar Utama')
                                ->image()
                                ->imageEditor()
                                ->imagePreviewHeight('250')
                                ->disk('public')
                                ->directory('gallery-images')
                                ->imageResizeMode('contain')
                                ->imageResizeTargetWidth('1920')
                                ->imageResizeTargetHeight('1080')
                                ->maxSize(2048)
                                ->helperText('Ukuran maksimal 2MB. Rasio ideal: 16:9.')
                                ->required(),
                        ])
                        ->columnSpan(1),

                    // 👉 Kanan: Informasi Gambar
                    Forms\Components\Section::make('Informasi Gambar')
                        ->description('Tambahkan keterangan singkat untuk foto yang diunggah.')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            Forms\Components\TextInput::make('caption')
                                ->label('Keterangan')
                                ->placeholder('Contoh: Kegiatan mahasiswa, seminar, workshop...')
                                ->maxLength(255),

                            Forms\Components\DateTimePicker::make('created_at')
                                ->label('Tanggal Upload')
                                ->disabled()
                                ->default(now())
                                ->helperText('Tanggal tersimpan otomatis saat upload.'),
                        ])
                        ->columnSpan(1),
                ]),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->height(120)
                    ->extraAttributes(['class' => 'rounded-xl shadow-sm']),
                Tables\Columns\TextColumn::make('caption')
                    ->label('Keterangan')
                    ->limit(60)
                    ->color('gray')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diupload Pada')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->button()
                    ->label('Edit'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ]); // Menampilkan grid responsif seperti gallery
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
