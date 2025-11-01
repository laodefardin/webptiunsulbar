<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.settings';
    protected ?string $heading = 'Pengaturan Website';
    protected ?string $subheading = 'Kelola identitas dan informasi kontak utama website.';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

   public function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Identitas Website')
                ->description('Atur logo dan nama institusi yang akan tampil di halaman utama.')
                ->icon('heroicon-o-building-library')
                ->schema([
                    // Buat dua kolom besar
                    Grid::make()
                        ->columns(2)
                        ->schema([
                            // Kolom kiri: logo
                            FileUpload::make('site_logo')
                                ->label('Logo Website')
                                ->image()
                                ->imageEditor()
                                ->disk('public')
                                ->directory('settings')
                                ->imagePreviewHeight('180px')
                                ->helperText('Gunakan logo berformat .png transparan untuk hasil terbaik.')
                                ->extraAttributes([
                                    'class' => 'rounded-xl border border-gray-200 shadow-sm p-2 bg-white',
                                ])
                                ->columnSpan(1),

                            // Kolom kanan: teks nama-nama institusi
                            Grid::make()
                                ->schema([
                                    TextInput::make('program_study_name')
                                        ->label('Nama Program Studi')
                                        ->placeholder('Contoh: Pendidikan Teknologi Informasi')
                                        ->required(),

                                    TextInput::make('faculty_name')
                                        ->label('Nama Fakultas')
                                        ->placeholder('Contoh: Fakultas Keguruan dan Ilmu Pendidikan'),

                                    TextInput::make('university_name')
                                        ->label('Nama Universitas')
                                        ->placeholder('Contoh: Universitas Sulawesi Barat'),
                                ])
                                ->extraAttributes([
                                    'class' => 'bg-white rounded-xl border border-gray-100 shadow-sm p-4',
                                ])
                                ->columnSpan(1),
                        ]),
                ])
                ->collapsible()
                ->compact(),

            Section::make('Informasi Kontak & Media Sosial')
                ->description('Tampilkan kontak dan sosial media di bagian footer website.')
                ->icon('heroicon-o-phone')
                ->schema([
                    Grid::make(2)->schema([
                        Textarea::make('footer_address')
                            ->label('Alamat di Footer')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('footer_email')
                            ->label('Email')
                            ->email(),
                        TextInput::make('footer_phone')
                            ->label('Telepon'),

                        TextInput::make('footer_whatsapp')
                            ->label('WhatsApp'),
                        TextInput::make('footer_facebook')
                            ->label('Facebook'),
                        TextInput::make('footer_instagram')
                            ->label('Instagram'),
                        TextInput::make('footer_youtube')
                            ->label('YouTube'),
                        TextInput::make('footer_linkedin')
                            ->label('LinkedIn'),
                    ]),
                ])
                ->collapsible()
                ->compact(),
        ])
        ->statePath('data');
}

protected function getFormActions(): array
{
    return [
        \Filament\Actions\Action::make('save')
            ->label('Simpan Perubahan')
            ->color('danger') // tetap merah seperti di gambar
            ->button()
            ->icon('heroicon-o-check-circle')
            ->extraAttributes([
                'class' => 'mt-10 mb-4 px-5 py-2 font-medium rounded-md shadow-sm', // jarak dan gaya tambahan
            ])
            ->action(fn() => $this->save()),
    ];
}


    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->body('Perubahan konfigurasi website telah diperbarui.')
            ->success()
            ->send();
    }
}
