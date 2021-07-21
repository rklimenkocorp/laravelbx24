<?php

namespace Mind4me\Bx24_integration\Console;

use Illuminate\Console\Command;
use Mind4me\Bx24_integration\Models\User;
use Mind4me\Bx24_integration\Services\B24;

class UsersIntegration extends Command
{

    protected $signature = 'integration:get-users';

    protected $description = 'Init user integration';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle($start = 0)
    {
        $b24 = new B24();
        $data = $b24->callMethod('/rest/user.search', 'get', [
            'start' => $start
        ]);
        $users = isset($data->result) ? json_decode(json_encode($data->result), true) : [];
        $users_string = "";
        echo "USERS FOR UPDATE: ".count($users)."\n";
        foreach ($users as $fields) {
            if(isset($fields['ID'])){
                $user = new User();
                $user->saveField($fields);
                $users_string .= "{$fields['ID']} : {$fields['NAME']}  ";
            }
        }
        echo "SUCCESS UPDATED!  \n $users_string \n-----------\n";
        if (count($users))
            $this->handle($start + 50);
    }

}
