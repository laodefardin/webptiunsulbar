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
            Forms\Components\Section::make('Informasi Utama')
                ->description('Isi informasi utama dari agenda kegiatan.')
                ->icon('heroicon-o-calendar')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Event')
                        ->placeholder('Masukkan judul event...')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('description')
                        ->label('Deskripsi')
                        ->placeholder('Tulis deskripsi singkat kegiatan...')
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Detail Agenda')
                ->description('Atur waktu, lokasi, dan poster event.')
                ->icon('heroicon-o-clock')
                ->schema([
                    Forms\Components\FileUpload::make('image_url')
                        ->label('Poster / Gambar Event')
                        ->image()
                        ->imageEditor()
                        ->imagePreviewHeight('180')
                        ->disk('public')
                        ->directory('event-images')
                        ->columnSpanFull(),

                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\DatePicker::make('event_date')
                                ->label('Tanggal Event')
                                ->required(),

                            Forms\Components\TextInput::make('location')
                                ->label('Lokasi Event')
                                ->placeholder('Masukkan lokasi...')
                                ->required(),
                        ]),

                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TimePicker::make('start_time')
                                ->label('Waktu Mulai'),

                            Forms\Components\TimePicker::make('end_time')
                                ->label('Waktu Selesai'),
                        ]),
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
