<?php

namespace App\Livewire\Account;

use App\Models\Agency;
use CodePix\Bank\Application\UseCase\AccountUseCase;
use CodePix\Bank\Domain\Repository\PixKeyRepositoryInterface;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Symfony\Contracts\Service\Attribute\Required;

class Register extends Component implements HasForms
{
    use InteractsWithForms;

    public string $name;
    public string $password;
    public string $password_confirmation;

    public function render()
    {
        if (auth()->user()) {
            return redirect()->route('home');
        }

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
            TextInput::make('password')
                ->rules(['confirmed', 'min:3'])
                ->required()
                ->hiddenLabel()
                ->password()
                ->placeholder('Digite sua senha'),
            TextInput::make('password_confirmation')
                ->rules(['min:3'])
                ->required()
                ->hiddenLabel()
                ->password()
                ->placeholder('Confirme sua senha'),
        ];
    }

    public function submit(AccountUseCase $accountUseCase): Redirector|RedirectResponse|null
    {
        $data = $this->form->getState();

        $account = $accountUseCase->register(
            bank: config('bank.id'),
            name: $data['name'],
            agency: Agency::first()->id,
            password: $data['password'],
        );

        if (Auth::guard('accounts')->attempt([
            'agency_id' => $account->agency,
            'number' => $account->number,
            'password' => $data['password'],
        ])) {
            return redirect()->route('home');
        }

        return null;
    }
}
