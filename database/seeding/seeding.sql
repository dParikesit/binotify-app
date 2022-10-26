-- Create username iniuser password 1234User
-- Create username iniadmin password 1234Admin
INSERT INTO users(email, password, username,isadmin) 
VALUES ('user@gmail.com','$2y$10$uRlGOMznczBOJDsFxQTAGONHxdmEsPonvvHJrRiDm/eGDsqVsua/K','iniuser',false),
('admin@gmail.com','$2y$10$CpZ4uh/fW7C4m6CSUS3wieLcx7o4xjdvQff7pRndYyL2Pc9WpKR5C','iniadmin',true);

INSERT INTO albums(Judul, Penyanyi, Total_duration, Image_path, Tanggal_terbit, Genre)
VALUES ('JUDUL-1', 'Penyanyi-1', 100, 'Path-1', '2022-04-03', 'GENRE-1'),
('JUDUL-2', 'Penyanyi-2', 100, 'Path-2', '2018-04-03', 'GENRE-2'),
('JUDUL-3', 'Penyanyi-3', 100, 'Path-3', '2021-04-03', 'GENRE-3'),
('JUDUL-4', 'Penyanyi-4', 100, 'Path-4', '2019-04-03', 'GENRE-4');

INSERT INTO songs(Judul, Penyanyi, Tanggal_terbit, Genre, Duration, Audio_path, Image_path, album_id)
VALUES ('SONG-1', 'Penyanyi-1', '2018-04-03', 'GENRE-1', 200, 'AUDIO-1', 'IMAGE-1', 1),
('SONG-2', 'Penyanyi-1', '2002-04-03', 'GENRE-1', 200, 'AUDIO-2', 'IMAGE-2', 1),
('SONG-3', 'Penyanyi-1', '2012-04-03', 'GENRE-1', 200, 'AUDIO-3', 'IMAGE-3', 1),
('SONG-4', 'Penyanyi-2', '2020-04-03', 'GENRE-2', 200, 'AUDIO-4', 'IMAGE-4', 2);