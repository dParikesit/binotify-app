chmod 777 src/uploads/images/
chmod 777 src/uploads/audios/

docker compose -p "tubes-1" -f ./docker/docker-compose.dev.yml --env-file .env down -v
docker compose -p "tubes-1" -f ./docker/docker-compose.dev.yml --env-file .env up --build