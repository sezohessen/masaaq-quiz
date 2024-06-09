<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Null_;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Exams';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Quiz')
                ->description('description')
                ->schema([
                    TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                    Textarea::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                    Select::make('Type')
                    ->options([
                        Quiz::InTimeType => 'In time',
                        Quiz::OutTimeType => 'Out time',
                    ])
                    ->required()
                    ->native(false),
                    DateTimePicker::make('Start time'),
                    DateTimePicker::make('End time'),
                ]),
                Section::make('Question')
                ->description('questions information')
                ->schema([
                    Select::make('question_id')
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set) => $set('choice_id',null))
                    ->relationship(name:'questions',titleAttribute:'Question'),
                    Select::make('choice_id')
                    ->required()
                    ->options(fn(Get $get): Collection => Choice::query()
                    ->where('question_id', $get('question_id'))
                    ->pluck('title','id'))

                    /* ->searchable()
                    ->preload(), */
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
