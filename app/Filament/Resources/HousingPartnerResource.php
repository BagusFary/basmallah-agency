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
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HousingPartnerResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Resources\HousingPartnerResource\RelationManagers;

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
                    ->required(),
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
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('available')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state == 0 ? 'Tidak Tersedia' : "{$state} Rumah";
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
                            fn (Builder $query, $input): Builder => $query->where('available', '==', $input)
                        );
                    }),
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
            'index' => Pages\ListHousingPartners::route('/'),
            'create' => Pages\CreateHousingPartner::route('/create'),
            'edit' => Pages\EditHousingPartner::route('/{record}/edit'),
        ];
    }
}
