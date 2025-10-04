<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Menu;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\MenuResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MenuResource\Pages\EditMenu;
use App\Filament\Resources\MenuResource\Pages\ListMenus;
use App\Filament\Resources\MenuResource\Pages\CreateMenu;
use App\Filament\Resources\MenuResource\RelationManagers;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Pengaturan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('location') // <-- Diubah dari TextInput menjadi Select
                    ->required()
                    ->options([
                        'main_nav' => 'Menu Utama (Header)',
                        'top_nav' => 'Menu Top Bar',
                        'footer_nav' => 'Menu Footer',
                    ])
                    ->unique(ignoreRecord: true),

                Repeater::make('menuItems')
                    ->relationship('menuItems')
                    ->label('Menu Items')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        Select::make('target')
                            ->options([
                                '_self' => 'Buka di Tab yang Sama',
                                '_blank' => 'Buka di Tab Baru',
                            ])->default('_self')->required(),

                        // Helpers to auto-fill from existing content
                        Select::make('page_id')
                            ->label('Link Cepat ke Halaman')
                            ->options(\App\Models\Page::pluck('title', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                                if ($page = \App\Models\Page::find($state)) {
                                    $set('title', $page->menu_title ?? $page->title);
                                    $set('url', route('pages.show', $page->slug));
                                }
                            })
                            ->placeholder('Pilih Halaman untuk mengisi Title & URL'),

                        TextInput::make('url')
                            ->label('URL')
                            ->required(),

                        Repeater::make('children')
                            ->relationship('children')
                            ->label('Sub Items')
                            ->schema([
                                TextInput::make('title')
                                    ->required(),
                                Select::make('target')
                                    ->options([
                                        '_self' => 'Buka di Tab yang Sama',
                                        '_blank' => 'Buka di Tab Baru',
                                    ])->default('_self')->required(),

                                // Helpers for sub-items
                                Select::make('page_id')
                                    ->label('Link Cepat ke Halaman')
                                    ->options(\App\Models\Page::pluck('title', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                                        if ($page = \App\Models\Page::find($state)) {
                                            $set('title', $page->menu_title ?? $page->title);
                                            $set('url', route('pages.show', $page->slug));
                                        }
                                    })
                                    ->placeholder('Pilih Halaman untuk mengisi Title & URL'),

                                TextInput::make('url')
                                    ->label('URL')
                                    ->required(),
                            ])
                            ->orderColumn('order')
                            ->reorderable()
                            ->collapsible()
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->addActionLabel('Tambah Sub Item'),
                    ])
                    ->orderColumn('order')
                    ->reorderable()
                    ->collapsible()
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                    ->addActionLabel('Tambah Item Menu')
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location'),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
