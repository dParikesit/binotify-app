# How to run
## Dev (Local change will be mirrored into running container)
```
# create .env file based on .env.example
sudo chmod +x -R ./scripts
./scripts/run-dev.sh
# open http://localhost:3000
```

## Production (Local change will NOT be mirrored into running container, upload files will be in container volume)
```
# create .env file based on .env.example
sudo chmod +x -R ./scripts
./scripts/run-prod.sh
# open http://localhost:3000
```