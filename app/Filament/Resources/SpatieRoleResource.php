<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use App\Filament\Resources\SpatieRoleResource\Pages;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\CreateAction;

class SpatieRoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                CreateAction::make(),
            ]);
    }

    public static function shouldRegisterOnNavigation(): bool
    {
        // Check if the authenticated user is a super admin
        if (auth()->user()?->hasRole('super_admin')) {
            return true; // Allow access to the roles resource
        } else {
            return false; // Don't allow access to the roles resource
        }
    }
    
    public static function getModelLabel(): string
    {
        return __('Spatie Role');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
           // 'create' => Pages\CreateRole::route('/create'),
           // 'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
