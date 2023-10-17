<?php

namespace App\Livewire\Account;

use App\Models\Agency;
use CodePix\Bank\Application\UseCase\AccountUseCase;
use CodePix\Bank\Domain\Repository\PixKeyRepositoryInterface;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Symfony\Contracts\Service\Attribute\Required;

class Register extends Component implements HasForms
{
    use InteractsWithForms;

    public string $name;

    public function render()
    {
        return view('livewire.account.register');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->rules(['min:3'])
                ->required()
                ->hiddenLabel()
                ->placeholder('Digite seu nome'),
        ];
    }

    public function submit(AccountUseCase $accountUseCase): void
    {
        $data = $this->form->getState();

        $accountUseCase->register(
            bank: config('bank.id'),
            name: $data['name'],
            agency: Agency::first()->id
        );
    }
}
