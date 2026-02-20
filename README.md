## Сайт «Турнир юных математиков памяти А.А. Кошкина»

## Исходный код сайта <name-domen.ru>

## Установка:
1. Склонировать репозиторий: `git clone https://github.com/Ximelay/Website-for-young-mathematicians.git`
2. Перейти в папку с проектом: `cd website-for-young-mathematicians`
3. Установить зависимости командой `composer install`, `npm install`
4. Собрать зависимости `vite`: `npm run build`
5. Создать и заполнить файл `.env`: `cp .env.example .env`
6. Собрать Docker-образ: `docker-compose build`
7. Запустить Docker-образ: `docker-compose up -d`
8. В терминале Docker-Desktop (`app -> exec`) ввести `php artisan migrate`
8. В терминале Docker-Desktop (`app -> exec`) ввести `php artisan db:seed`
9. Перейти в браузер по url `https://localhost:8000`

## Полезные команды:
> `docker-compose down` - выключает контейнеры.

> `docker-compose down -v` - полностью очищает Docker-образ.

> `docker-compose build --no-cache` - собирает Docker-образ без сохранённого кеша.

> `php artisan key:generate` - генерирует ключ APP_KEY.
