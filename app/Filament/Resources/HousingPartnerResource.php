<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Models\HousingPartner;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HousingPartnerResource\Pages;
use App\Models\Income;
use App\Models\UserSubmission;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class HousingPartnerResource extends Resource
{
    protected static ?string $model = HousingPartner::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::user()->id),
                Forms\Components\TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),
                Forms\Components\FileUpload::make('image_url')
                    ->label('Image')
                    ->image()
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $timestamp = now()->timestamp;
                        $fileExtension = $file->getClientOriginalExtension();
                        $hashedName = md5($timestamp);
                        return (string) "housingpartnerimage/{$hashedName}.{$fileExtension}";
                    })
                    ->required()
                    ->afterStateUpdated(function ($state, $record) {
                        $storageImage = Storage::disk('filament_disk');
                        if (isset($record->image_url) && $state) {
                            $storageImage->delete($record->image_url);
                        }
                    }),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('instagram')
                ->label('Username Instagram')
                ->required(),
                Forms\Components\TextInput::make('booking_fee')
                    ->label('Booking Fee')
                    ->prefix('Rp.')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Forms\Components\TextInput::make('available')
                    ->required()
                    ->suffix('Rumah')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
                Forms\Components\TextInput::make('down_payment')
                    ->label('Down Payment')
                    ->suffix('%')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('available')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state == 0 ? 'Tidak Tersedia' : "{$state} Rumah";
                    }),
                Tables\Columns\TextColumn::make('booking_fee')
                    ->formatStateUsing(function ($state) {
                        return "Rp. " . number_format($state, -3, ',', '.');
                    }),
            ])
            ->filters([
                Filter::make('available')
                    ->form([
                        TextInput::make('available_input')
                            ->label('Rumah yang tersedia (Available)')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['available_input'],
                            fn(Builder $query, $input): Builder => $query->where('available', '==', $input)
                        );
                    }),
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
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $userSubmissionIds = $record->userSubmission()->get(['id'])->pluck('id');

                        Income::whereIn('user_submission_id', $userSubmissionIds)->delete();
                        UserSubmission::whereIn('id', $userSubmissionIds)->delete();
                        $record->delete();

                        Notification::make()
                            ->title('Delete Success')
                            ->success()
                            ->body('The record has been successfully deleted.')
                            ->send();
                    })
                    ->iconButton()
                    ->tooltip('Delete')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function ($records) {
                            $housingPartnerIds = $records->pluck('id');
                            $query = UserSubmission::whereIn('housing_partner_id', $housingPartnerIds);
                            $userSubmissionIds = $query->get(['id'])->pluck('id');
                            Income::whereIn('user_submission_id', $userSubmissionIds)->delete();

                            $query->delete();

                            HousingPartner::whereIn('id', $housingPartnerIds)->delete();

                            Notification::make()
                                ->success()
                                ->title('House Partners Successfully Deleted.');
                        }),
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
            'index' => Pages\ListHousingPartners::route('/'),
            'create' => Pages\CreateHousingPartner::route('/create'),
            'edit' => Pages\EditHousingPartner::route('/{record}/edit'),
        ];
    }
}
