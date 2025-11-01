<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Grid::make(2)
                ->schema([
                    // 📄 KIRI — Informasi Utama
                    Forms\Components\Section::make('Informasi Utama')
                        ->description('Isi judul, slug, dan konten utama dari berita atau artikel.')
                        ->icon('heroicon-o-newspaper')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Judul Berita')
                                ->placeholder('Masukkan judul berita...')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) =>
                                    $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug URL')
                                ->disabled()
                                ->dehydrated()
                                ->helperText('Slug akan otomatis dibuat dari judul.')
                                ->unique(Post::class, 'slug', ignoreRecord: true),

                            Forms\Components\RichEditor::make('content')
                                ->label('Konten Berita')
                                ->placeholder('Tulis isi berita di sini...')
                                ->required()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsDirectory('post-content-images')
                                ->toolbarButtons([
                                    'bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link', 'undo', 'redo',
                                ])
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(1),

                    // 🖼 KANAN — Detail & Gambar
                    Forms\Components\Section::make('Detail Tambahan')
                        ->description('Atur kategori, gambar utama, dan jadwal publikasi.')
                        ->icon('heroicon-o-adjustments-horizontal')
                        ->schema([
                            Forms\Components\FileUpload::make('image_url')
                                ->label('Gambar Utama')
                                ->image()
                                ->imageEditor()
                                ->imagePreviewHeight('180')
                                ->disk('public')
                                ->directory('post-images')
                                ->helperText('Gunakan gambar dengan rasio 16:9 untuk hasil terbaik.')
                                ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/gif'])
                                ->columnSpanFull(),

                            Forms\Components\Select::make('category')
                                ->label('Kategori')
                                ->options([
                                    'Berita Kampus' => 'Berita Kampus',
                                    'Pengumuman' => 'Pengumuman',
                                    'Prestasi' => 'Prestasi',
                                ])
                                ->native(false)
                                ->searchable()
                                ->required(),

                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Tanggal Publikasi')
                                ->helperText('Waktu posting berita.')
                                ->default(now()),
                        ])
                        ->columnSpan(1),
                ])
                ->columns(2),
        ]);
}


    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('image_url')
                ->label('Gambar')
                ->disk('public')
                ->height(60)
                ->width(100)
                ->extraAttributes(['class' => 'rounded-lg shadow-sm']),

            Tables\Columns\TextColumn::make('title')
                ->label('Judul')
                ->weight('bold')
                ->limit(60)
                ->wrap()
                ->searchable()
                ->sortable()
                ->description(fn ($record) => $record->category, position: 'below'),

            Tables\Columns\TextColumn::make('published_at')
                ->label('Diterbitkan')
                ->dateTime('d M Y H:i')
                ->sortable()
                ->color('gray'),
        ])
        ->defaultSort('published_at', 'desc')
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil-square')
                ->color('primary'),
            Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
