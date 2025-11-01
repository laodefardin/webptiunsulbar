<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

        protected static ?string $navigationGroup = 'Konten Utama';
        protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Grid::make(2)
                ->schema([
                    // 🔹 Kiri: Informasi Event
                    Forms\Components\Section::make('Informasi Utama')
                        ->description('Isi informasi dasar kegiatan seperti judul dan deskripsi.')
                        ->icon('heroicon-o-calendar')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Judul Event')
                                ->placeholder('Masukkan judul event...')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\RichEditor::make('description')
                                ->label('Deskripsi Event')
                                ->placeholder('Tuliskan deskripsi singkat kegiatan...')
                                ->toolbarButtons([
                                    'bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link', 'undo', 'redo',
                                ])
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(1),

                    // 🔹 Kanan: Detail & Gambar
                    Forms\Components\Section::make('Detail Agenda')
                        ->description('Atur poster, waktu, dan lokasi event di sini.')
                        ->icon('heroicon-o-clock')
                        ->schema([
                            Forms\Components\FileUpload::make('image_url')
                                ->label('Poster / Gambar Event')
                                ->image()
                                ->imageEditor()
                                ->imagePreviewHeight('180')
                                ->disk('public')
                                ->directory('event-images')
                                ->helperText('Upload poster dengan rasio 16:9 agar tampak proporsional.')
                                ->columnSpanFull(),

                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\DatePicker::make('event_date')
                                        ->label('Tanggal Event')
                                        ->required(),

                                    Forms\Components\TextInput::make('location')
                                        ->label('Lokasi')
                                        ->placeholder('Masukkan lokasi kegiatan...')
                                        ->required(),
                                ]),

                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TimePicker::make('start_time')
                                        ->label('Mulai')
                                        ->seconds(false)
                                        ->placeholder('08:00 AM'),

                                    Forms\Components\TimePicker::make('end_time')
                                        ->label('Selesai')
                                        ->seconds(false)
                                        ->placeholder('10:00 AM'),
                                ]),
                        ])
                        ->columnSpan(1),
                ])
                ->columns(2), // Dua kolom besar: kiri & kanan
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
