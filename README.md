## Сайт «Турнир юных математиков памяти А.А. Кошкина»

## Исходный код сайта <name-domen.ru>

## Установка:
1. Склонировать репозиторий: <name-rep.git>
2. Перейти в папку с проектом: `cd name-proj`
3. Установить зависимости командой `composer install`, `npm install`
4. Создать и заполнить файл `.env`: `cp .env.example .env`
5. Собрать Docker-образ: `docker-compose build`
6. Запустить Docker-образ: `docker-compose up -d`
7. В терминале Docker-Desktop (`app -> terminal`) ввести `php artisan migrate`

## Полезные команды:
> `docker-compose down` - выключает контейнеры.

> `docker-compose down -v` - полностью очищает Docker-образ.

> `docker-compose build --no-cache` - собирает Docker-образ без сохранённого кеша.

> `php artisan key:generate` - генерирует ключ APP_KEY.
