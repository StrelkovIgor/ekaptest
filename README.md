# Запуск результата тестового задания

---

Сбор и запуск докер образов:

`docker-compose up -d`

Установка пакетных зависимостей:

`docker-compose exec app composer install`

Миграция, запуск сидов и фабрики:

`docker-compose exec app php artisan migrate --seed`

Запуск очереди:

`docker-compose exec app php artisan queue:work`

Запуск тестов:

`docker-compose exec app php artisan test`