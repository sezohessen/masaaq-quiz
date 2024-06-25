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
use Filament\Tables\Columns\TextColumn;
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
                    Select::make('quiz_type')
                    ->options([
                        Quiz::InTimeType => 'In time',
                        Quiz::OutTimeType => 'Out time',
                    ])
                    ->required()
                    ->native(false),
                    DateTimePicker::make('start_time')
                    ->native(false)
                    ->seconds(false),
                    DateTimePicker::make('end_time')
                    ->native(false)
                    ->seconds(false),
                ]),
                Section::make('Question')
                ->description('questions information')
                ->schema([
                    Select::make('question_id')
                    /* ->multiple() */
                    ->relationship('questions','Question')
                    ->required()
                    ->live()
                    ->searchable()
                    ->afterStateUpdated(fn(Set $set) => $set('choice_id',null)),

                    Select::make('choice_id')
                    ->label('Choices')
                    ->multiple()
                    ->required()
                    ->options(fn(Get $get): Collection => Choice::query()
                    ->where('question_id', $get('question_id'))
                    ->pluck('title','id'))
                    ->live()
                    ->preload(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->searchable(),
                TextColumn::make('description')->hidden(true),
                TextColumn::make('type'),
                TextColumn::make('score')->numeric(),
                TextColumn::make('number_of_questions')->label('No. questions'),
                TextColumn::make('created_at')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault:true)
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
