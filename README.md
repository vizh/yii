# Инициализация и запуск рабочего окружения

1. Убеждаемся, что на портах 80, 27017, 5432 ничего не висит.
2. Копируем текущий боевой дамп в /conf/docker/database.sql что бы он развернулся во время инициализации.
3. `docker-compose up`
4. /etc/hosts:
   `127.0.0.1           runet-id.dev`
   `127.0.0.1       api.runet-id.dev`
   `127.0.0.1       pay.runet-id.dev`
   `127.0.0.1     admin.runet-id.dev`
   `127.0.0.1   partner.runet-id.dev`

# Обслуживание рабочей копии

1. Для обновления дампа после инициализации можно выполнить `docker-compose exec database bash`
   * pg_dump -h runet-id.com --username runetid --password -f dump.sql
   * psql --username runetid --password -f dump.sql; rm dump.sql
2. Если требуется синхронизация загруженных файлов с боевым сервером, то `docker-compose exec app bash`
   * apt-get update && apt-get install -yq rsync openssh-client
   * rsync -rcv runetid@runet-id.com:www/ www/
