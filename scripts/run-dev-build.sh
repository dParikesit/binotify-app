chmod -R 777 src/uploads
docker compose -p "tubes-1" -f ./docker/docker-compose.dev.yml --env-file .env down -v
docker compose -p "tubes-1" -f ./docker/docker-compose.dev.yml --env-file .env up --build