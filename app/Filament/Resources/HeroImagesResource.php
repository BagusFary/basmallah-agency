<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroImagesResource\Pages;
use App\Models\HeroImage;
use Cache;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Storage;
use Symfony\Component\Uid\Ulid;

class HeroImagesResource extends Resource
{
    protected static ?string $model = HeroImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
