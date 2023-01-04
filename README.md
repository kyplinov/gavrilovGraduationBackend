Запуск приложения:
- composer install (устанавливаем все зависимости)
- docker-compose build (собираем докер контейнеры)
- docker-compose up -d (запускаем контейнеры)
- php artisan serve (запускаем laravel сервер)
- php artisan storage:link (прокидываем линк на директорию куда будут сохранятся файлы)
- php artisan jwt:secret (генерирует секретный jwt-token)
- php artisan migrate --path=/database/migrations/BaseTable (запускаем миграции базовых таблиц)
- php artisan migrate --path=/database/migrations/First (запускаем миграции таблиц выше базовых)
- php artisan migrate (запускаем оставшиеся миграции)

p.s. 3 последние команды мб перепешу в очередь миграции

Для паролей используется Bcrypt Hash Generator (https://bcrypt.online/)
