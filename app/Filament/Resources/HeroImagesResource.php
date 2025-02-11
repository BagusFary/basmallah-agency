<?php

namespace App\Filament\Resources;

use Cache;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\HeroImage;
use Filament\Tables\Table;
use Symfony\Component\Uid\Ulid;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\HeroImagesResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class HeroImagesResource extends Resource
{
    protected static ?string $model = HeroImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Contents';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image_url')
                    ->label('Upload Image')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $timestamp = now()->timestamp;
                        $fileExtension = $file->getClientOriginalExtension();
                        $hashedName = md5($timestamp . Ulid::generate());
                        return (string) "heroImages/{$hashedName}.{$fileExtension}";
                    })
                    ->required()
                    ->afterStateUpdated(function ($state, $record) {
                        $storageImage = Storage::disk('filament_disk');
                        if(isset($record->image_url) && $state){
                            $storageImage->delete($record->image_url);
                        }
                    }),
                Hidden::make('user_id')
                    ->default(Auth::user()->id)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Gambar'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->iconButton()
                ->icon('heroicon-s-eye')
                ->color('info')
                ->tooltip('Detail'),
                Tables\Actions\EditAction::make()
                ->iconButton()
                ->tooltip('Edit'),
                Tables\Actions\DeleteAction::make()
                ->iconButton()
                ->tooltip('Delete')
                ->requiresConfirmation(),

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
            'index' => Pages\ListHeroImages::route('/'),
            'create' => Pages\CreateHeroImages::route('/create'),
            'edit' => Pages\EditHeroImages::route('/{record}/edit'),
        ];
    }
}
