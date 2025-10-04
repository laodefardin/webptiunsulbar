<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected ?string $heading = 'Pengaturan Website';
 protected static ?int $navigationSort = 1;
    public ?array $data = [];

    public function mount(): void
    {
        // Ambil semua pengaturan dari database dan isi ke form
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('site_logo')->label('Logo Website')->disk('public')->directory('settings'),
                TextInput::make('program_study_name')->label('Nama Program Studi')->required(),
                TextInput::make('faculty_name')->label('Nama Fakultas')->required(),
                TextInput::make('university_name')->label('Nama Universitas')->required(),
                Textarea::make('footer_address')->label('Alamat di Footer')->rows(3),
                TextInput::make('footer_email')->label('Email di Footer')->email(),
                TextInput::make('footer_phone')->label('Telepon di Footer'),
                TextInput::make('footer_whatsapp')->label('WhatsApp di Footer'),
                TextInput::make('footer_facebook')->label('Facebook di Footer'),
                TextInput::make('footer_instagram')->label('Instagram di Footer'),
                TextInput::make('footer_youtube')->label('Youtube di Footer'),
                TextInput::make('footer_linkedin')->label('Linkedin di Footer'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
