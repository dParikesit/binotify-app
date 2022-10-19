CREATE TABLE IF NOT EXISTS songs (
    song_id INTEGER primary key,
    Judul VARCHAR(64) NOT NULL,
    Penyanyi VARCHAR(128) NOT NULL,
    Tanggal_terbit date NOT NULL,
    Genre VARCHAR(64) NOT NULL,
    Duration INTEGER NOT NULL,
    Audio_path VARCHAR(256) NOT NULL,
    Image_path VARCHAR(256) NOT NULL,
    CONSTRAINT album_id INTEGER FOREIGN KEY(album_id) REFERENCES albums(album_id)
);