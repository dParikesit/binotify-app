-- Create username iniuser password 1234User
-- Create username iniadmin password 1234Admin
INSERT INTO users(email, password, username) 
VALUES ('user@gmail.com','$2y$10$/xj2UML489m0Pa1xGz8dcuPf1.Atvo/a9olT.zUdUEdfVQWlPlwmy','iniuser'),
('admin@gmail.com','$2y$10$OiZg1MQ8wvC1pK0UjlguZOS7G21E1gS3FNG1fiJTSElKPrfL3S4I2','iniadmin');

INSERT INTO albums(album_id, Judul, Penyanyi, Total_duration, Image_path, Tanggal_terbit, Genre)
VALUES (1, 'JUDUL-1', 'Penyanyi-1', 100, 'Path-1', '2022-04-03', 'GENRE-1'),
(2, 'JUDUL-2', 'Penyanyi-2', 100, 'Path-2', '2018-04-03', 'GENRE-2'),
(3, 'JUDUL-3', 'Penyanyi-3', 100, 'Path-3', '2021-04-03', 'GENRE-3'),
(4, 'JUDUL-4', 'Penyanyi-4', 100, 'Path-4', '2019-04-03', 'GENRE-4');

INSERT INTO songs(song_id, Judul, Penyanyi, Tanggal_terbit, Genre, Duration, Audio_path, Image_path, album_id)
VALUES (1, 'SONG-1', 'Penyanyi-1', '2018-04-03', 'GENRE-1', 200, 'AUDIO-1', 'IMAGE-1', 1),
(2, 'SONG-2', 'Penyanyi-1', '2002-04-03', 'GENRE-1', 200, 'AUDIO-2', 'IMAGE-2', 1),
(3, 'SONG-3', 'Penyanyi-1', '2012-04-03', 'GENRE-1', 200, 'AUDIO-3', 'IMAGE-3', 1),
(4, 'SONG-4', 'Penyanyi-2', '2020-04-03', 'GENRE-2', 200, 'AUDIO-4', 'IMAGE-4', 2);