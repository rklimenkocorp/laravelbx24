<?php

namespace Mind4me\Bx24_integration\Console;

use Illuminate\Console\Command;

class Migration extends Command
{

    protected $signature = 'integration:install';

    protected $description = 'install integration';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $this->call('migrate');
    }

}
