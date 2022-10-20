/* CREATE TABLE IF NOT EXISTS songs (
    song_id INTEGER primary key,
    Judul VARCHAR(64) NOT NULL,
    Penyanyi VARCHAR(128) NOT NULL,
    Tanggal_terbit date NOT NULL,
    Genre VARCHAR(64) NOT NULL,
    Duration INTEGER NOT NULL,
    Audio_path VARCHAR(256) NOT NULL,
    Image_path VARCHAR(256) NOT NULL,
    CONSTRAINT album_id_fk FOREIGN KEY(album_id) REFERENCES albums(album_id)
); */

CREATE TABLE IF NOT EXISTS songs (
    song_id INTEGER primary key,
    Judul VARCHAR(64) NOT NULL,
    Penyanyi VARCHAR(128) NOT NULL,
    Tanggal_terbit date NOT NULL,
    Genre VARCHAR(64) NOT NULL,
    Duration INTEGER NOT NULL,
    Audio_path VARCHAR(256) NOT NULL,
    Image_path VARCHAR(256) NOT NULL,
    album_id INTEGER REFERENCES albums (album_id)
);

ALTER TABLE songs
ADD CONSTRAINT fk_album_id FOREIGN KEY (album_id) REFERENCES albums (album_id);