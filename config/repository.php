<?php
return [
    /**
     * Default paths.
     * In this case:
     *      app/Interfaces
     *      app/Repositories
     *      app/Models
     */
    'paths' => [
        'contract' => 'App/Repositories/Interfaces',
        'eloquent' => 'App/Repositories',
        'model' => 'App/Models',
    ],
    /**
     * Configure the naming convention you wish for your repositories.
     *
     * Example: php artisan make:repository Users
     *      - Contract: UsersRepository
     *      - Eloquent: EloquentUsersRepository
     */
    'fileNames' => [
        'contract' => '{name}RepositoryInterface',
        'eloquent' => '{name}Repository',
        'model' => '{name}',
    ],
    'provider' => [
        'path' => 'app/Repositories',
        'contract' => 'Interfaces',
        'app' => 'App\Repositories',
    ],
];