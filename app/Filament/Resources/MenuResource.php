<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Informasi Menu')
                            ->description('Tentukan lokasi dan nama menu yang akan ditampilkan di situs.')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Menu')
                                    ->placeholder('Contoh: Menu Utama atau Footer Links')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('location')
                                    ->label('Lokasi Menu')
                                    ->options([
                                        'main_nav' => 'Menu Utama (Header)',
                                        'top_nav' => 'Menu Top Bar',
                                        'footer_nav' => 'Menu Footer',
                                    ])
                                    ->required()
                                    ->helperText('Pilih di mana menu ini akan ditampilkan.')
                                    ->unique(ignoreRecord: true),
                            ])
                            ->extraAttributes(['class' => 'p-5 bg-white rounded-2xl shadow-sm border border-gray-100']),

                        Forms\Components\Section::make('Panduan')
                            ->icon('heroicon-o-information-circle')
                            ->description('Tambahkan item menu dan sub-item sesuai struktur navigasi website Anda.')
                            ->schema([
                                Forms\Components\Placeholder::make('info')
                                    ->content('💡 Gunakan **Link Cepat ke Halaman** agar otomatis mengisi judul & URL berdasarkan halaman yang sudah ada.')
                            ])
                            ->extraAttributes(['class' => 'p-5 bg-gradient-to-br from-indigo-50 to-white rounded-2xl border border-indigo-100 shadow-sm']),
                    ]),

                Forms\Components\Section::make('Struktur Menu')
                    ->description('Atur urutan dan sub-menu di bawah.')
                    ->icon('heroicon-o-list-bullet')
                    ->schema([
                        Forms\Components\Repeater::make('menuItems')
                            ->relationship('menuItems')
                            ->label('Daftar Item Menu')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->placeholder('Contoh: Tentang Kami')
                                    ->required(),

                                Forms\Components\Select::make('target')
                                    ->label('Buka di')
                                    ->options([
                                        '_self' => 'Tab yang Sama',
                                        '_blank' => 'Tab Baru',
                                    ])
                                    ->default('_self')
                                    ->required(),

                                Forms\Components\Select::make('page_id')
                                    ->label('Link Cepat ke Halaman')
                                    ->options(Page::pluck('title', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                        if ($page = Page::find($state)) {
                                            $set('title', $page->menu_title ?? $page->title);
                                            $set('url', route('pages.show', $page->slug));
                                        }
                                    })
                                    ->placeholder('Pilih halaman untuk mengisi otomatis'),

                                Forms\Components\TextInput::make('url')
                                    ->label('URL')
                                    ->placeholder('https://example.com')
                                    ->required(),

                                Forms\Components\Repeater::make('children')
                                    ->relationship('children')
                                    ->label('Sub Menu')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul Sub Menu')
                                            ->required(),
                                        Forms\Components\TextInput::make('url')
                                            ->label('URL')
                                            ->placeholder('https://example.com')
                                            ->required(),
                                        Forms\Components\Select::make('target')
                                            ->label('Buka di')
                                            ->options([
                                                '_self' => 'Tab yang Sama',
                                                '_blank' => 'Tab Baru',
                                            ])
                                            ->default('_self'),
                                    ])
                                    ->orderColumn('order')
                                    ->reorderable()
                                    ->collapsible()
                                    ->collapsed()
                                    ->itemLabel(fn(array $state): ?string => $state['title'] ?? null)
                                    ->addActionLabel('Tambah Sub Item'),
                            ])
                            ->orderColumn('order')
                            ->reorderable()
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn(array $state): ?string => $state['title'] ?? null)
                            ->addActionLabel('Tambah Item Menu')
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->extraAttributes(['class' => 'p-5 bg-white rounded-2xl shadow-sm border border-gray-100']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Menu')
                    ->icon('heroicon-o-bars-3')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('location')
                    ->label('Lokasi')
                    ->colors([
                        'primary' => 'main_nav',
                        'info' => 'top_nav',
                        'secondary' => 'footer_nav',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'main_nav' => 'Header',
                        'top_nav' => 'Top Bar',
                        'footer_nav' => 'Footer',
                        default => ucfirst($state),
                    }),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->tooltip('Edit Menu'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->tooltip('Hapus Menu')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Menu')
            ->emptyStateDescription('Tambahkan menu untuk menampilkan navigasi di website.');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
