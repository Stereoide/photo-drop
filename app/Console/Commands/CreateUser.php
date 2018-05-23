<?php

namespace App\Console\Commands;

use App\Facades\PhotoDropApi;
use Illuminate\Console\Command;
use App\User;
use PhotoDrop;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {name} {email} {token?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $token = $this->argument('token');

        $this->info('Creating user');

        $user = PhotoDrop::createUser($name, $email, $token);

        $this->table(['Name', 'eMail', 'Token', ], [[$user->name, $user->email, $user->token, ]]);
    }
}
