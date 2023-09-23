<?php

namespace BankingApp;

use BankingApp\Feature\Deposit;
use BankingApp\Feature\Feature;
use BankingApp\Feature\Login;
use BankingApp\Feature\Logout;
use BankingApp\Feature\Register;
use BankingApp\Feature\Transfer;
use BankingApp\Feature\ViewTransactions;
use BankingApp\Feature\ViewTransactionsByUser;
use BankingApp\Feature\ViewCustomers;
use BankingApp\Feature\Withdraw;
use BankingApp\Management\Management;
use BankingApp\Management\Managers\AccountsManager;
use BankingApp\Management\Managers\FinanceManager;
use BankingApp\Model\Role;
use BankingApp\State\AuthenticationState;
use BankingApp\Storage\FileStorage;
use BankingApp\View\ConsoleView;
use BankingApp\View\MessageType;
use BankingApp\View\View;
use BankingApp\Storage\Storage;

class BankingApp
{
    private View $view;
    private Management $management;
    private Storage $storage;
    private AuthenticationState $authenticationState;
    /**
     * @var array<string,array<int, Feature>>
     */
    private array $features;

    public function __construct()
    {
        $this->storage = new FileStorage();
        $this->management = $this->loadManagement($this->storage);
        $this->authenticationState = $this->loadAuthState();
        $this->view = new ConsoleView($this->authenticationState, $this->management);
        $this->loadFeatures();
        $this->registerTimeZone();

    }


    public function run(): void
    {
        while (true){
            try{
                $runningFeature = $this->features[$this->authenticationState->getUser()->getRole()->name];
                $this->view->preRender();
                $this->view->renderHeader();
                if ($this->authenticationState->isFirstRun() && $this->authenticationState->isLoggedIn()){
                    $password = $this->view->getInput("[L]ogout / Password: ");
                    if ($password == "L"){
                        $this->authenticationState->logout();
                        continue;
                    }
                    $this->authenticationState->reLogin($password);
                    continue;
                }
                $this->view->renderList($runningFeature, fn ($feature, $key) => "$key. $feature".PHP_EOL);
                $inp = (int) $this->view->inputWithValidation("Enter Option: ",
                    fn ($input) => !array_key_exists($input, $runningFeature));
                $runningFeature[$inp]->preRun();
                $runningFeature[$inp]->run();
                $runningFeature[$inp]->postRun();

            }catch (\Exception $err){
                $this->view->renderMessage($err->getMessage().PHP_EOL, MessageType::Failed);
            }
            $this->view->getInput("Press ENTER Key to Continue");
        }
    }


    private function loadFeatures(): void
    {
        $this->loadFeature([1 => Role::GUEST], Login::class);
        $this->loadFeature([2 => Role::GUEST], Register::class);

        $this->loadFeature([1 => Role::CUSTOMER], Deposit::class);
        $this->loadFeature([2 => Role::CUSTOMER], Withdraw::class);
        $this->loadFeature([3 => Role::CUSTOMER], Transfer::class);

        $this->loadFeature([1 => Role::ADMIN], ViewCustomers::class);
        $this->loadFeature([2 => Role::ADMIN], ViewTransactionsByUser::class);

        $this->loadFeature([4 => Role::CUSTOMER, 3 => Role::ADMIN], ViewTransactions::class);
        $this->loadFeature([5 => Role::CUSTOMER, 4 => Role::ADMIN], Logout::class);
    }

    private function loadFeature(array $roles, string $featureClass): void
    {
        foreach ($roles as $key => $role) {
            $this->features[$role->name][$key] = new $featureClass($this->authenticationState, $this->management, $this->view, $this->storage);
        }
    }

    private function loadManagement(Storage $storage) : Management
    {
        $financeManager = $this->storage->load(FinanceManager::class) ?? new FinanceManager($storage);
        $accountsManager = $this->storage->load(AccountsManager::class) ?? new AccountsManager($storage);
       return new Management($financeManager, $accountsManager);
    }

    private function loadAuthState(): AuthenticationState {
        return $this->storage->load(AuthenticationState::class) ?? new AuthenticationState($this->management->getAccountsManager());
    }

    private function registerTimeZone(string $zone = "Asia/Dhaka"): void
    {
        date_default_timezone_set($zone);
    }
}