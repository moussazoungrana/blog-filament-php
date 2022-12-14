<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $slug = 'posts';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required(),
                        Forms\Components\TextInput::make('description')
                            ->nullable(),
                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                            ->minFiles(1)
                            ->maxFiles(1)
                            ->image()
                            ->disk('media')
                            ->collection('cover')
                            ->required(),
                        Forms\Components\MarkdownEditor::make('content')
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Visible')
                            ->default(true),
                        Forms\Components\Toggle::make('feature')
                            ->label('A la une ?')
                            ->default(false),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->default('Pas de description'),
                Tables\Columns\BooleanColumn::make('feature')
                    ->label('A la une ?'),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Visible'),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()

            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->query(fn(Builder $query):Builder => $query->where('is_active',true))
                    ->label('Visible'),

                Tables\Filters\Filter::make('feature')
                    ->query(fn(Builder $query):Builder => $query->where('feature',true))
                    ->label('A la une'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }


}
