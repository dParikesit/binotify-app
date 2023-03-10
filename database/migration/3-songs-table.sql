CREATE TABLE IF NOT EXISTS songs (
    song_id uuid primary key DEFAULT uuid_generate_v4(),
    Judul VARCHAR(64) NOT NULL,
    Penyanyi VARCHAR(128) NOT NULL,
    Tanggal_terbit date NOT NULL,
    Genre VARCHAR(64) NOT NULL,
    Duration INTEGER NOT NULL,
    Audio_path VARCHAR(256) NOT NULL,
    Image_path VARCHAR(256) NOT NULL,
    album_id uuid REFERENCES albums (album_id) ON UPDATE CASCADE on DELETE SET NULL
);