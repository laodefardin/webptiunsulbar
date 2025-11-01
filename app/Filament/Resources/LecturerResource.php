<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LecturerResource\Pages;
use App\Models\Lecturer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LecturerResource extends Resource
{
    protected static ?string $model = Lecturer::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        // 👤 Kiri: Foto
                        Forms\Components\Section::make('Foto Dosen')
                            ->description('Upload foto formal atau profesional untuk profil dosen.')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('photo_url')
                                    ->label('Foto Profil')
                                    ->image()
                                    ->avatar()
                                    ->imageEditor()
                                    ->imagePreviewHeight('180')
                                    ->disk('public')
                                    ->directory('lecturer-photos')
                                    ->helperText('Gunakan rasio 1:1 (persegi) untuk hasil terbaik.'),
                            ])
                            ->columnSpan(1),

                        // 🧾 Kanan: Data Dosen
                        Forms\Components\Section::make('Informasi Dosen')
                            ->description('Isi informasi lengkap mengenai dosen.')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->placeholder('Contoh: Dr. Andi Pratama, M.Kom')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('position')
                                    ->label('Jabatan')
                                    ->placeholder('Contoh: Kepala Program Studi')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('nidn')
                                    ->label('NIDN')
                                    ->placeholder('Masukkan NIDN...')
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email Dosen')
                                    ->email()
                                    ->placeholder('contoh@unsulbar.ac.id')
                                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 📸 Foto profil bundar
                Tables\Columns\ImageColumn::make('photo_url')
                    ->label('Foto')
                    ->circular()
                    ->disk('public')
                    ->height(50)
                    ->width(50),

                // 🧑 Nama & jabatan
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->weight('bold')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->position, position: 'below'),

                // 🏫 NIDN
                Tables\Columns\TextColumn::make('nidn')
                    ->label('NIDN')
                    ->searchable()
                    ->color('gray'),

                // ✉️ Email
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->color('gray')
                    ->searchable(),
            ])
            ->defaultSort('name', 'asc')
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
            ])
            ->striped()
            ->paginated([10, 25, 50]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLecturers::route('/'),
            'create' => Pages\CreateLecturer::route('/create'),
            'edit' => Pages\EditLecturer::route('/{record}/edit'),
        ];
    }
}
