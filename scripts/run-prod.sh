chmod 777 src/uploads/images
chmod 777 src/uploads/audios

docker compose -p "tubes-1" -f ./docker/docker-compose.yml --env-file .env up