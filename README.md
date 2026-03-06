# Запуск результата тестового задания

---

Сбор и запуск докер образов:

`docker-compose up -d`

Установка пакетных зависимостей:

`docker-compose exec app composer install`

Переводим файлы в www-data

`docker-compose exec app chown -R www-data:www-data /var/www/app`

Копируем env

`docker-compose exec app cp /var/www/app/.env.example /var/www/app/.env`

Генерируем app-key

`docker-compose exec app php artisan key:generate`


Миграция, запуск сидов и фабрики:

`docker-compose exec app php artisan migrate --seed`

Запуск очереди:

`docker-compose exec -d app php artisan queue:work`

Запуск тестов:

`docker-compose exec app php artisan test`