chmod -R 777 src/uploads
docker compose -p "tubes-1" -f ./docker/docker-compose.yml --env-file .env up