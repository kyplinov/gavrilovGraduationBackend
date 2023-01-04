Запуск приложения:
- composer install (устанавливаем все зависимости)
- docker-compose build (собираем докер контейнеры)
- docker-compose up -d (запускаем контейнеры)
- php artisan serve (запускаем laravel сервер)
- php artisan storage:link (прокидываем линк на директорию куда будут сохранятся файлы)
- php artisan jwt:secret (генерирует секретный jwt-token)
- php artisan migrate-in-order (запускаем миграции через консольную команду)

Для паролей используется Bcrypt Hash Generator (https://bcrypt.online/)
