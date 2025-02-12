<?php

namespace App\Filament\Pages;

use App\Models\Content;
use Filament\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class Contents extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $title = 'Content Management';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Contents';

    protected static string $view = 'filament.pages.contents';

    public $hero_title = '';
    public $hero_description = '';
    public $about_title = '';
    public $about_description = '';
    public $contact_email = '';
    public $contact_phone = '';

    public function mount(): void
    {
        $content = Content::first();
        if ($content) {
            $this->form->fill($content->attributesToArray());
        } else {
            $this->form->fill();
        }
    }

    protected function getFormSchema(): array
    {
        return [
            Fieldset::make('Hero')
                ->schema([
                    TextInput::make('hero_title')
                        ->placeholder('Masukkan Judul Header')
                        ->label('Hero Title')
                        ->nullable(),
                    MarkdownEditor::make('hero_description')
                        ->placeholder('Masukkan Deskripsi')
                        ->label('Hero Description')
                        ->disableToolbarButtons([
                            'attachFiles'
                        ])
                        ->nullable(),
                ])
                ->columns(1),
            Fieldset::make('About Us')
                ->schema([
                    MarkdownEditor::make('about_description')
                        ->placeholder('Masukkan Deskripsi Tentang Kami')
                        ->label('Hero Description')
                        ->disableToolbarButtons([
                            'attachFiles'
                        ])
                        ->nullable(),
                ])
                ->columns(1),
            Fieldset::make('Contact Information')
                ->schema([
                    TextInput::make('contact_email')
                        ->label('Email')
                        ->placeholder('Masukkan email untuk menerima informasi tentang submission user')
                        ->email()
                        ->nullable(),
                    TextInput::make('contact_phone')
                        ->label('Phone Number')
                        ->placeholder('Masukkan nomor telepon yang bisa dihubungi')
                        ->nullable()
                ])
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Content')
                // ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $content = Content::first();
            $data = $this->form->getState();
            if (!$content) {
                Content::create($data);
            } else {
                $content->update($data);
            }
        } catch (\Error $e) {
            Notification::make()
                ->error()
                ->title('Save Content Error.')
                ->send();
        } finally {
            Cache::forget('index-contents');
            Notification::make()
                ->success()
                ->title('Save Content Successfully.')
                ->send();
        }
    }
}
