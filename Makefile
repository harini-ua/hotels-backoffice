re-build:
	php artisan migrate:fresh --seed
clear:
	php artisan route:clear
	php artisan config:clear
	php artisan cache:clear

