# BINOTIFY

Aplikasi ini dibuat untuk pemenuhan Tugas Besar 1 IF3110 Web Based Development tahun 2022/2023.
Aplikasi ini digunakan sebagai media player untuk lagu dan album - album yang tersedia.

## Requirement
- Docker-compose 3.9
- Docker

## Installation
1. Install docker dan docker-compose pada komputer. Panduan instalasi docker dan docker compose pada link berikut.
2. Clone repository dan masuk ke folder
```
git clone https://gitlab.informatika.org/f3110-2022-k01-01-20/tugas-besar-1.git
cd tugas-besar-1
```
3. Menjalankan script sesuai mode yang diinginkan
```
Perbedaan Development dan Production
1. Mode dev bisa hot reload, production tidak bisa
2. Pada mode dev, file lagu dan gambar yang diupload akan masuk ke folder local. Pada mode production akan masuk ke named volume docker
3. Pada mode, dev data seeding akan dimasukkan, pada production tidak
```

#### Development
```
# create .env file based on .env.example
sudo chmod +x -R ./scripts
./scripts/run-dev.sh
# If you want to rebuild the container, use run-dev-build script
# open http://localhost:3000
```
OR
```
# create .env file based on .env.example
bash ./scripts/run-dev.sh
# open http://localhost:3000
```

#### Production
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
Login | 13520087 13520057
Register | 13520087 13520057
Home | 13520057
Search | 13520057
Add Song | 13520058 13520057
Add Album | 13520058 13520057
Detail Song | 13520058 13520057
Detail Album | 13520058 13520057
List Album | 13520057
List User | 13520058 13520057

### Server-side
Page / Feature | NIM
--- | ---
Login | 
Register | 
Home | 13520057
Search | 13520057
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