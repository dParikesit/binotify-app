CREATE TABLE IF NOT EXISTS songs (
    song_id SERIAL primary key,
    Judul VARCHAR(64) NOT NULL,
    Penyanyi VARCHAR(128) NOT NULL,
    Tanggal_terbit date NOT NULL,
    Genre VARCHAR(64) NOT NULL,
    Duration INTEGER NOT NULL,
    Audio_path VARCHAR(256) NOT NULL,
    Image_path VARCHAR(256) NOT NULL,
    album_id INTEGER REFERENCES albums (album_id) ON UPDATE CASCADE on DELETE CASCADE
);