<?php


namespace App\Base;


use App\Events\NewUserCreated;
use App\Events\UserUpdated;
use App\Models\Role;
use App\Models\User;
use App\Models\Company as CompanyModel;

class RegisterUser
{

    private $userData, $userRole, $foundUser,$company;


    private $allowedMeta = [
        'gender',
        'phone',
    ];
    private $alwaysLowerMeta = [
        'gender',
    ];

    private $meta = [];

    public function __construct($user = null)
    {
        if (!auth()->check()) switch (gettype($user)) {
            case null;
                break;

            case 'integer';
                $this->setUser(User::findOrFail($user));
                break;

            case 'object';
                if (is_a($user, User::class)) {
                    $this->setUser($user);
                }
                break;

            default:
        } else {
            $this->setUser(auth()->user());
        }
    }

    private function setUser(User $user): void
    {
        $this->foundUser = $user;
    }

    public static function getOptions()
    {
        return [];
    }

    public function create(Role $type, $user)
    {

        $this->filter__create($type, $user);
        $this->setRole($type);
        $this->setUserData($user);
        $this->setUser(User::findOrCreate($user, 'email'));
        $this->getUser()->fill($user)->save();
        $this->getUser()->syncRoles($type??Role::findById(1));

        if ($this->company) {
            $this->getCompany()->companyAssociates()->save($this->getUser());
        }

        if (count($this->meta)) {
            $this->getUser()->syncMeta($this->meta);
        }
        NewUserCreated::dispatch($this->getUser());
        return $this->chain();
    }

    private function filter__create(&$type, &$user): void
    {
        $this->filter__user($user);
    }

    private function getCompany(){
        return $this->company;
    }
    private function setCompany($refCode){
        $this->company=CompanyModel::where('ref_code',$refCode)->first();
    }

    private function filter__user(&$user): void
    {
        if(array_key_exists('ref_code',$user)){
            $this->setCompany($user['ref_code']);
        }
        foreach ($user as $k => $v) {
            if (in_array(strtolower($k), $this->allowedMeta, true)) {
                $this->meta[$k] = (in_array(strtolower($k), $this->allowedMeta, true)) ? strtolower($v) : $v;
                unset($user[$k]);
            }
        }
    }

    private function setRole(Role $role): void
    {
        $this->userRole = $role;
    }

    private function setUserData(array $data): void
    {
        $this->userData = $data;
    }

    public function getUser(): User
    {
        return $this->foundUser;
    }

    public function chain(): self
    {
        return $this;
    }

    public function update($data)
    {
        $this->filter__user($data);
        $this->getUser()->update($data);
        UserUpdated::dispatch($this->foundUser);
        return $this->chain();
    }

    private function getRole()
    {
        return $this->userRole;
    }

    private function getUserData(): array
    {
        return $this->userData ?? [];
    }


}