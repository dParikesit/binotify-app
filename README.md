# BINOTIFY

Aplikasi ini dibuat untuk pemenuhan Tugas Besar 1 IF3110 Web Based Development tahun 2022/2023.
Aplikasi ini digunakan sebagai media player untuk lagu dan album - album yang tersedia.

## Requirement
Docker-compose 3.9
Docker
PHP 8.1.11

## Installation
1. Install docker dan docker-compose pada komputer. Panduan instalasi docker dan docker compose pada link berikut.
2. Disarankan menggunakan docker untuk instalasi yang lebih mudah
```
git clone https://gitlab.informatika.org/f3110-2022-k01-01-20/tugas-besar-1.git
```
3. Melakukan langkah - langkah di bawah.

#### Dev (Local change will be mirrored into running container)
```
# create .env file based on .env.example
sudo chmod +x -R ./scripts
./scripts/run-dev.sh (use run-dev-build for the first time)
# open http://localhost:3000
```
OR
```
# create .env file based on .env.example
bash ./scripts/run-dev.sh
# open http://localhost:3000
```

#### Production (Local change will NOT be mirrored into running container, upload files will be in container volume)
```
# create .env file based on .env.example
sudo chmod +x -R ./scripts
./scripts/run-prod.sh
# open http://localhost:3000
```
4. Website sudah dapat dijalankan pada localhost dengan default port 3000.

## Screenshot

## Pembagian Kerja
### Client-side
Page / Feature | NIM
--- | ---
Login | 
Register | 
Home | 
Search | 
Add Song | 13520058
Add Album | 13520058
Detail Song | 13520058
Detail Album | 13520058
List Album |
List User | 13520058

### Server-side
Page / Feature | NIM
--- | ---
Login | 
Register | 
Home | 
Search | 
Add Song | 13520058
Add Album | 13520058
Detail Song | 13520058
Detail Album | 13520058
List Album | 13520058
List User | 

## Bagian Bonus
- Docker
- Responsive
- UI/UX Spotify

## Author
NIM | NAMA
--- | ---
13520057 | Marcellus Michael Herman Kahari
13520058 | Kristo Abdi Wiguna
13520087 | Dimas Shidqi Parikesit