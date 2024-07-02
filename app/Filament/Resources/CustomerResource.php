<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Settings\JobOpeningSettings;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Collection;
use Filament\Tables\Columns\BooleanColumn;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   // protected static bool $shouldRegisterNavigation = false;
    //Hide Menu item temporarily
    protected static ?int $navigationSort = null; // Set navigationSort to null to hide the menu item
    public static function getNavigationItems(): array
    {
        return [];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Customer Information')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('fullName')
                            ->required(),
                        TextInput::make('jobTitle'),
                        TextInput::make('companyName'),
                        TextInput::make('emailId')
                            ->email()
                            ->required(),
                        TextInput::make('phoneNumber'),
                        TextInput::make('location'),
                        TextInput::make('companyWebsiteFromPersonalProfile')
                            ->label('Company Website (From Personal Profile)'),
                        TextInput::make('personalWebsite')
                            ->label('Personal Website'),
                        TextInput::make('linkedinSalesNavUrl')
                            ->label('LinkedIn Sales Navigator URL'),
                        TextInput::make('linkedinUrl')
                            ->label('LinkedIn URL'),
                        TextInput::make('companyWebsiteFromCompanyProfile')
                            ->label('Company Website (From Company Profile)'),
                        Select::make('industry')
                            ->options([
                                // Define options for industry
                            ]),
                        Checkbox::make('blackListed'),
                    ])->columns(2),
                Section::make('Additional Information')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        RichEditor::make('fullDescription')
                            ->label('Full Description'),
                        TextInput::make('tagList')
                            ->label('Tag List'),
                        DatePicker::make('lastActivity')
                            ->label('Last Activity')
                            ->format('d/m/Y')
                           // ->required(),
                    ])->columns(1),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullName')
                    ->label('Full Name'),
                TextColumn::make('jobTitle')
                    ->label('Job Title'),
                TextColumn::make('companyName')
                    ->label('Company Name'),
                TextColumn::make('emailId')
                    ->label('Email'),
                BooleanColumn::make('blackListed')
                    ->label('Blacklisted'),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-m-plus-small'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
