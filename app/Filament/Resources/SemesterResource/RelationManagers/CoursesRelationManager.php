<?php

namespace App\Filament\Resources\SemesterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static ?string $title = 'Daftar Mata Kuliah'; // judul di section relasi

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Mata Kuliah')
                    ->description('Isi detail lengkap mengenai mata kuliah.')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('code')
                                ->label('Kode MK')
                                ->placeholder('CT101')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('name')
                                ->label('Nama Mata Kuliah')
                                ->placeholder('Contoh: Algoritma & Pemrograman')
                                ->required()
                                ->maxLength(255),
                        ]),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('credits')
                                ->label('SKS')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(6)
                                ->required(),

                            Forms\Components\Select::make('type')
                                ->label('Sifat')
                                ->options([
                                    'Wajib' => 'Wajib',
                                    'Pilihan' => 'Pilihan',
                                ])
                                ->required()
                                ->native(false), // tampil dropdown modern

                            Forms\Components\TextInput::make('rps_link')
                                ->label('Link RPS (Google Drive)')
                                ->placeholder('https://drive.google.com/...')
                                ->url()
                                ->nullable(),
                        ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->weight('bold')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Mata Kuliah')
                    ->wrap()
                    ->description(fn($record) => "{$record->credits} SKS • {$record->type}", position: 'below')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Sifat')
                    ->colors([
                        'success' => 'Wajib',
                        'warning' => 'Pilihan',
                    ])
                    ->icons([
                        'heroicon-o-academic-cap' => 'Wajib',
                        'heroicon-o-sparkles' => 'Pilihan',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('rps_link')
                    ->label('RPS')
                    ->formatStateUsing(fn($state) => $state ? '📄 Lihat RPS' : '-')
                    ->url(fn($state) => $state)
                    ->openUrlInNewTab()
                    ->color('primary'),
            ])
            ->defaultSort('code', 'asc')
            ->striped()
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Mata Kuliah')
                    ->icon('heroicon-o-plus-circle')
                    ->button()
                    ->color('primary'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->label('Hapus')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada Mata Kuliah')
            ->emptyStateDescription('Tambahkan data mata kuliah pertama untuk semester ini.');
    }
}
