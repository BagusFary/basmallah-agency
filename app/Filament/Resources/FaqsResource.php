<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqsResource\Pages;
use App\Filament\Resources\FaqsResource\RelationManagers;
use App\Models\FAQ;
use App\Models\Faqs;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class FaqsResource extends Resource
{
    protected static ?string $model = FAQ::class;

    protected static ?string $navigationGroup = 'Contents';

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $breadcrumb = 'FAQs';


    public static function getNavigationLabel(): string
    {
        return __('FAQs');
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')
                    ->default(Auth::user()->id),
                TextInput::make('ask_question')
                    ->label('Pertanyaan')
                    ->required(),
                RichEditor::make('answer')
                    ->label('Jawaban')
                    ->disableToolbarButtons([
                        'attachFiles'
                    ])
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ask_question')
                    ->label('Question')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('FAQ No Exists');
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaqs::route('/create'),
            'edit' => Pages\EditFaqs::route('/{record}/edit'),
        ];
    }
}
