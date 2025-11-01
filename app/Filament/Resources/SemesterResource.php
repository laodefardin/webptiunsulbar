<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SemesterResource\RelationManagers;
use App\Filament\Resources\SemesterResource\Pages;
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
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'p-4 bg-white rounded-xl shadow-sm border border-gray-100']),
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
                ->alignLeft()
                ->icon('heroicon-o-academic-cap')
                ->weight('bold'),
        ])
        ->defaultSort('name', 'asc')
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make()->icon('heroicon-o-pencil-square'),
            Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->striped()
        ->emptyStateHeading('Belum Ada Semester')
        ->emptyStateDescription('Tambahkan semester baru untuk mulai mengatur mata kuliah.');
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
