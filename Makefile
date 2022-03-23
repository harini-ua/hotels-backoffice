re-build:
	php artisan migrate:fresh --seed
clear:
	php artisan route:clear
	php artisan config:clear
	php artisan cache:clear

ifndef host
# Default Homestead ip
override host = 192.168.56.56
endif

ifndef port
# Default local web server port
override port = 80
endif

share:
	ngrok http $(host):$(port)
