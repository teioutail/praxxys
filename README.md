
### Installation

Download/Clone the project to local directory. Go to the path in terminal/cmd and install plugins via composer.

Composer plugins Installation:
```sh
$ composer install
```
NPM plugins installation:
```sh
$ npm install
```
#### Database
Update .env.example to .env  and setup the following configuration:
```sh
DB_CONNECTION=mysql
DB_HOST=<host>
DB_PORT=<port>
DB_DATABASE=<dbname>
DB_USERNAME=<username>
DB_PASSWORD=
```
After the database setup, run laravel migrate command.
```sh
$ php artisan migrate
```
(optional) Third:
To setup dummy data, run laravel db seed command
```sh
$ php artisan db:seed
```


#### Run
To run the project, use the artisan serve command
```sh
$ php artisan serve
```

To compile the VueJS front end run
```sh
$ npm run watch
```

After the command execute, go to the localhost:8000.

If problem occurs during php artisan serve, dump the composer autoload.
```sh
$ composer dump-autoload
```

License
----

Open Source