Запуск приложения:
- composer install (устанавливаем все зависимости)
- docker-compose build (собираем докер контейнеры)
- docker-compose up -d (запускаем контейнеры)
- php artisan serve (запускаем laravel сервер)
- php artisan migrate --path=/database/migrations/BaseTable (запускаем миграции базовых таблиц)
- php artisan migrate --path=/database/migrations/First (запускаем миграции таблиц выше базовых)
- php artisan migrate (запускаем оставшиеся миграции)
- php artisan storage:link (прокидываем линк на директорию куда будут сохранятся файлы)

p.s. 3 последние команды мб перепешу в очередь миграции
