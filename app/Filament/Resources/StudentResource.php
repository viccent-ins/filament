<?php

namespace App\Filament\Resources;

use App\Exports\StudentsExport;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $navigationGroup = 'Academic Management';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    TextInput::make('name')
                        ->required()
                        ->autofocus(),
                    TextInput::make('email')
                        ->required(),
                    TextInput::make('phone_number')
                        ->required()
                        ->tel(),
                    TextInput::make('address')
                        ->required(),

                    Select::make('class_id')
                        ->relationship('class', 'name')
                        ->reactive(),

                    Select::make('section_id')
                        ->label('Select Section')
                        ->options(function (callable $get) {
                            $classId = $get('class_id');
                            if ($classId) {
                                return Section::where('class_id', $classId)->pluck('name', 'id')->toArray();
                            }
                        })
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone_number')
                    ->toggleable(),
                TextColumn::make('class.name')
                    ->sortable(),
                TextColumn::make('section.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('address')
                    ->wrap()
                    ->searchable()
                    ->toggleable()

            ])
            ->filters([
                Filter::make('class-section-filter')
                    ->form([
                        Select::make('class_id')
                            ->label('Filter By Class')
                            ->placeholder('Select a Class')
                            ->options(
                                Classes::pluck('name', 'id')->toArray()
                            )
                            ->afterStateUpdated(
                                fn(callable $set) => $set('section_id', null)
                            ),
                        Select::make('section_id')
                            ->label('Filter By Section')
                            ->placeholder('Select a Section')
                            ->options(
                                function (callable $get) {
                                    $classId = $get('class_id');

                                    if ($classId) {
                                        return Section::where('class_id', $classId)->pluck('name', 'id')->toArray();
                                    }
                                }
                            )
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['class_id'],
                                fn(Builder $query, $record): Builder => $query->where('class_id', $record),
                            )->when(
                                $data['section_id'],
                                fn(Builder $query, $record): Builder => $query->where('section_id', $record),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                BulkAction::make('export')
                    ->label('Export Selected')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(fn(Collection $records) => (new StudentsExport($records))->download('student.xlsx'))
                    ->deselectRecordsAfterCompletion()
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStudents::route('/'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return self::$model::count();
    }
}
