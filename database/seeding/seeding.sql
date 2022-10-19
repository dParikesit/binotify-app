INSERT INTO users(email, password, username) 
VALUES ('user@gmail.com','1234User','iniuser'),
('admin@gmail.com','1234Admin','iniadmin');

INSERT INTO albums(Judul, Penyanyi, Total_duration, Image_path, Tanggal_terbit, Genre)
VALUES ("JUDUL-1", "Penyanyi-1", 100, "Path-1", "", "GENRE-1"),
("JUDUL-2", "Penyanyi-2", 100, "Path-2", "", "GENRE-2"),
("JUDUL-3", "Penyanyi-3", 100, "Path-3", "", "GENRE-3"),
("JUDUL-4", "Penyanyi-4", 100, "Path-4", "", "GENRE-4");

INSERT INTO songs(Judul, Penyanyi, Tanggal_terbit, Genre, Duration, Audio_path, Image_path, album_id)
VALUES ("SONG-1", "Penyanyi-1", "", "GENRE-1", 200, "AUDIO-1", "IMAGE-1", 1),
("SONG-2", "Penyanyi-1", "", "GENRE-1", 200, "AUDIO-2", "IMAGE-2", 1),
("SONG-3", "Penyanyi-1", "", "GENRE-1", 200, "AUDIO-3", "IMAGE-3", 1),
("SONG-4", "Penyanyi-2", "", "GENRE-2", 200, "AUDIO-4", "IMAGE-4", 2);