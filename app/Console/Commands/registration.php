<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class registration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:registration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Регистрация пользователя';

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
        $name  = $this->ask('Ваше имя', 'user');
        $email = $this->ask('Введите почту');
        $password = $this->secret('Введите пароль');
        $result   = User::registration($email, $password, $name);
        if($result instanceof User){
            $this->info('У вас получилось!');
            $this->info($result->toJson());
            return;
        }
        $this->error('Что-то пошло не так!');
        $this->error($result->toJson());

        $this->line('Попробуйте ещё раз');
        $this->call('user:registration');
    }
}
