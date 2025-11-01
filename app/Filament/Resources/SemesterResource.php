<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SemesterResource\Pages;
use App\Filament\Resources\SemesterResource\RelationManagers;
use App\Models\Semester;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SemesterResource extends Resource
{
    protected static ?string $model = Semester::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make('Informasi Semester')
                            ->description('Isi detail nama semester akademik (misalnya: Ganjil 2024/2025).')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Semester')
                                    ->placeholder('Contoh: Semester Ganjil 2024/2025')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Gunakan format seperti: Ganjil 2024/2025 atau Genap 2023/2024.'),
                            ])
                            ->columns(1)
                            ->extraAttributes([
                                'class' => 'p-5 bg-white rounded-2xl shadow-sm border border-gray-100'
                            ]),

                        Forms\Components\Section::make('Panduan Input')
                            ->icon('heroicon-o-information-circle')
                            ->description('Setiap semester dapat memiliki daftar mata kuliah yang berbeda. Anda dapat menambahkannya di bagian relasi setelah menyimpan data semester ini.')
                            ->schema([
                                Forms\Components\Placeholder::make('Tips')
                                    ->content(' Simpan dulu semester ini, lalu buka tab **Daftar Mata Kuliah** untuk menambahkan mata kuliah yang terkait.')
                            ])
                            ->extraAttributes([
                                'class' => 'p-5 bg-gradient-to-br from-indigo-50 to-white rounded-2xl border border-indigo-100 shadow-sm'
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Semester')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-academic-cap')
                    ->alignLeft(),
            ])
            ->defaultSort('name', 'asc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->tooltip('Edit Semester')
                    ->color('primary'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->tooltip('Hapus Semester')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
                ]),
            ])
            ->striped()
            ->emptyStateHeading('Belum Ada Semester')
            ->emptyStateDescription('Tambahkan semester baru untuk mulai mengatur mata kuliah.')
            ->paginated([5, 10, 25]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CoursesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSemesters::route('/'),
            'create' => Pages\CreateSemester::route('/create'),
            'edit' => Pages\EditSemester::route('/{record}/edit'),
        ];
    }
}
