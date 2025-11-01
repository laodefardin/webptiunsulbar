<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Halaman')
                    ->description('Atur detail utama halaman seperti judul, menu, dan gambar.')
                    ->icon('heroicon-o-document')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Halaman (Lengkap)')
                                    ->placeholder('Masukkan judul halaman...')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) =>
                                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                    ),

                                Forms\Components\TextInput::make('menu_title')
                                    ->label('Judul Menu (Singkat)')
                                    ->placeholder('Judul yang muncul di menu navigasi')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Page::class, 'slug', ignoreRecord: true)
                                    ->helperText('Otomatis dibuat dari judul halaman.')
                                    ->columnSpan(2),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Tampilkan di Halaman Depan')
                                    ->onColor('success')
                                    ->offColor('gray')
                                    ->helperText('Aktifkan untuk menampilkan halaman ini di beranda.'),
                            ]),

                        Forms\Components\FileUpload::make('image_url')
                            ->label('Gambar Utama / Thumbnail')
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('200')
                            ->disk('public')
                            ->directory('page-images')
                            ->helperText('Gambar ini akan muncul sebagai thumbnail di daftar halaman.'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Konten Halaman')
                    ->description('Isi konten utama halaman di bawah ini.')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('Isi Konten')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'bulletList', 'orderedList', 'link', 'blockquote',
                                'h2', 'h3', 'codeBlock', 'undo', 'redo',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('page-content-images')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('image_url')
                ->label('Thumbnail')
                ->disk('public')
                ->square()
                ->height(70)
                ->extraAttributes(['class' => 'rounded-lg shadow-sm']),

            Tables\Columns\TextColumn::make('title')
                ->label('Judul Halaman')
                ->weight('bold')
                ->limit(50)
                ->searchable()
                ->sortable()
                ->description(fn ($record) => $record->menu_title, position: 'below'),

            Tables\Columns\IconColumn::make('is_featured')
                ->label('Unggulan')
                ->boolean()
                ->trueIcon('heroicon-s-star')
                ->falseIcon('heroicon-o-star')
                ->trueColor('warning')
                ->falseColor('gray'),

            Tables\Columns\TextColumn::make('updated_at')
                ->label('Diperbarui')
                ->since()
                ->sortable()
                ->color('gray'),
        ])
        ->defaultSort('updated_at', 'desc')
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->button(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->striped() // Menambahkan efek zebra
        ->paginated([10, 25, 50]); // Pagination modern
}


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
