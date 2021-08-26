Development
#### Docker with sail
###### .env file
Duplicate .env.example change name to .env and set your local environment variables
###### generate app key for the project
<code>php artisan key:generate</code>
###### start server
<code>vendor/bin/sail up -d</code>
###### install composer dependencies
<code>vendor/bin/sail composer install</code>
###### run migrations
<code>vendor/bin/sail artisan migrate</code>
###### run seeding
<code>vendor/bin/sail artisan db:seed</code>
###### run test
<code>vendor/bin/sail artisan test</code>
