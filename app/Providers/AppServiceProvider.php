<?php

namespace App\Providers;

use App\Models\PassportAuthCode;
use App\Models\PassportClient;
use App\Models\PassportPersonalAccessClient;
use App\Models\PassportToken;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessClient;

class AppServiceProvider extends ServiceProvider
{
    protected $repo;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // register repos
        $this->repo = config('repository.provider');
        // binding repo
        $this->bindingRepository($this->repo);
        //
    }

    public function boot()
    {
        PassportClient::creating(function (PassportClient $client) {
            $client->incrementing = false;
            $client->id = (string)Str::uuid();
        });
        PassportClient::retrieved(function (PassportClient $client) {
            $client->incrementing = false;
        });

        PersonalAccessClient::creating(function (PersonalAccessClient $personal_client) {
            $personal_client->incrementing = false;
            $personal_client->id = (string)Str::uuid();
        });
        PersonalAccessClient::retrieved(function (PersonalAccessClient $personal_client) {
            $personal_client->incrementing = false;
        });
        // override class name for passport
        Passport::useTokenModel(PassportToken::class);
        Passport::useClientModel(PassportClient::class);
        Passport::useAuthCodeModel(PassportAuthCode::class);
        Passport::usePersonalAccessClientModel(PassportPersonalAccessClient::class);
    }

    /**
     * binding all Class in Repository directory
     * @param $repo
     */
    private function bindingRepository($repo)
    {
        $files = File::files(app()->basePath($repo['path']));
        foreach ($files as $file) {
            $name = basename($file, '.php');
            $this->app->bind($repo['app'] . '\\' . $repo['contract'] . '\\' . $this->processContractName($name, $repo['contract']),
                $repo['app'] . '\\' . $name);
        }
    }

    /**
     * get correct file name
     * @param $name
     * @param $contract
     * @return string
     */
    private function processContractName($name, $contract) {
        return $name . substr($contract, 0, (strlen($contract) - 1));
    }
}
