CREATE TABLE IF NOT EXISTS albums (
    album_id uuid primary key DEFAULT uuid_generate_v4(),
    Judul VARCHAR(64) NOT NULL,
    Penyanyi VARCHAR(128) NOT NULL,
    Total_duration INTEGER NOT NULL,
    Image_path VARCHAR(256) NOT NULL,
    Tanggal_terbit date NOT NULL,
    Genre VARCHAR(64) NOT NULL
);