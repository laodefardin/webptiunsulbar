<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pertanyaan & Jawaban')
                    ->description('Tambahkan daftar pertanyaan umum (FAQ) beserta jawabannya.')
                    ->icon('heroicon-o-light-bulb')
                    ->schema([
                        Forms\Components\Textarea::make('question')
                            ->label('Pertanyaan')
                            ->placeholder('Contoh: Bagaimana cara mendaftar akun?')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('answer')
                            ->label('Jawaban')
                            ->placeholder('Tuliskan jawaban secara jelas dan ringkas...')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'bulletList', 'orderedList', 'link', 'undo', 'redo',
                            ])
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->extraAttributes([
                        'class' => 'p-5 bg-white rounded-2xl shadow-sm border border-gray-100'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('Pertanyaan')
                    ->wrap()
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->limit(80)
                    ->tooltip(fn($record) => $record->question)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->striped()
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->tooltip('Edit Pertanyaan'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->tooltip('Hapus Pertanyaan'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
                ]),
            ])
            ->emptyStateHeading('Belum Ada FAQ')
            ->emptyStateDescription('Tambahkan pertanyaan dan jawaban yang sering diajukan pengunjung situs.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
