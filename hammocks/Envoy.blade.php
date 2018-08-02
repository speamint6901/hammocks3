@servers(['dev' => '127.0.0.1', 'prod' => '127.0.0.1']);

@task('develop', ['on' => 'dev', 'confirm' => true])
    cd /var/www/data/hammocks
    git pull origin develop
    composer install
    php artisan down
    php artisan migrate
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:clear
    php artisan up
    cp -r resources/assets/js/*.js public/js/
    cp -r resources/assets/js/vendor/* public/js/vendor/
@endtask

@task('product', ['on' => 'prod'])
    cd /var/www/data/hammocks
    git pull origin master 
    composer install
    php artisan down
    php artisan migrate
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:clear
    php artisan up 
    cp -r resources/assets/js/*.js public/js/
    cp -r resources/assets/js/vendor/* public/js/vendor/
@endtask
