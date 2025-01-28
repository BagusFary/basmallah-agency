<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Users';

    public static function canViewAny(): bool
    {
        $hasAuthenticated = Auth::check();

        if ($hasAuthenticated) {
            return Auth::user()->role === 'superadmin';
        } else {
            return false;
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nama')
                    ->placeholder('Masukkan Nama'),
                TextInput::make('email')
                    ->required()
                    ->label('Email')
                    ->placeholder("Masukkan Email")
                    ->email(),
                Select::make('role')
                    ->label('Akses Role')
                    ->placeholder('Pilih Role')
                    ->options([
                        'superadmin' => 'Superadmin',
                        'admin' => 'Admin Basmallah Agency'
                    ])
                    ->required(),
                TextInput::make('password')
                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                    ->dehydrated(fn(?string $state): bool => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->label('Password')
                    ->placeholder('Masukkan Password')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->same('new-password'),
                TextInput::make('new-password')
                    ->label('Ulang Password')
                    ->placeholder('Masukkan Ulang Password')
                    ->afterOrEqual('password')
                    ->password()
                    ->revealable()
                    ->dehydrated(false)
                    ->requiredWith('password')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('role')
                    ->color(fn(string $state): string => match ($state) {
                        'superadmin' => 'danger',
                        'admin' => 'success',
                    })
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
