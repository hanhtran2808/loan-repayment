# Loan API
## Instruction use to API
### Require server environment
1. php >= 7.4
2. mysql 5.7|8.0
3. composer

### Usage API (step by step)
Note: After get source from git, use command line into the project
1. CLI: cd {project name}
2. Run composer install
    CLI: composer install
3. copy file .env.example to .env
    CLI: cp .env.example .env
4. Generate app key
    CLI: php artisan key:generate
5. Open .env file to set up Database connection
    DB_CONNECTION={DB connection}
    DB_HOST={DB host}
    DB_PORT={DB port}
    DB_DATABASE={DB name}
    DB_USERNAME={account access DB}
    DB_PASSWORD={Password of account}
6. After API has connected database successfully. Run command line to create database structure
    Run CLI: php artisan migrate
7. Run this command line to generate client ID and secret ID when using passport
   - Run CLI: php artisan passport:install 
   - Open .env file to add more keys:
    API_GET_TOKEN=/user/auth/token
    PASSPORT_CLIENT_ID={get value of column 'id' into 'oauth_clients' table. NOTE: get record with name column has contain ' Grant Client'}
    PASSPORT_CLIENT_SECRET={get value of column 'secret' into 'oauth_clients' table. NOTE: get record with name column has contain ' Grant Client'}
    GRANT_TYPE_PASSWORD=password
8. Run command line to generate data in database
    - Run CLI: php artisan db:seed --class=UserSeeder

    
    

