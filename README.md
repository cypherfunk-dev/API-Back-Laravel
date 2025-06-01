http://127.0.0.1:8000/api/documentation

generar documentacion swagger

php artisan config:clear
php artisan l5-swagger:generate

crear clave 
php artisan serve

recrear la base y poblarla con seeders
php artisan migrate:fresh --seed

recrearla limpia
php artisan migrate:fresh