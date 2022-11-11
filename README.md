## gazReqSys

Дипломный проект от ГАЗ-IT сервис.
Срок выполнения чуть больше двух недель.

### Запуск проекта

Для запуска проекта нужно выполнить команды `composer update`, `npm install`, `npm run build`

После чего можно либо развернуть локальный сервер и запустить проект на нем, либо воспользоваться сборкой под docker

#### Docker

Для запуска проекта с использование Docker:

- Скопируйте файл .env.docker под название .env
- Собрать образы: в папке с проектом написать `docker compose build`
- После завершения сборки запустить контейнеры `docker compose up`
- Прописать в системе в файле hosts
  - 127.0.0.1 pma.localhost
  - 127.0.0.1 app.localhost
- Зайти по адерсу pma.localhost и создать 4 базы данных
  - global
  - gaz
  - reqsys
  - wt
- Зайти в контейнер для запуска миграций
  - `docker exec -it fpm bash`
  - `php artisan migrate --seed`. Можно не использовать ключ `--seed`, чтобы не заполнять таблицы фековыми данными

После этого по адресу app.localhost будет доступно приложение

    На всякий случай при использовании docker под Windows лучше отключить использование WSL2 и переключиться на Hyper-V

### Разработка проекта

Для начала разработки проекта необходимо выполнить команды:

- `composer update`
- `npm install`
- `npm run watch` - запустит слежку за изменением файлов

Для сборки в продакшн команда `npm run build`
