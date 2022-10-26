-- Create username iniuser password 1234User
-- Create username iniadmin password 1234Admin
INSERT INTO users(email, password, username,isadmin) 
VALUES ('user@gmail.com','$2y$10$uRlGOMznczBOJDsFxQTAGONHxdmEsPonvvHJrRiDm/eGDsqVsua/K','iniuser',false),
('admin@gmail.com','$2y$10$CpZ4uh/fW7C4m6CSUS3wieLcx7o4xjdvQff7pRndYyL2Pc9WpKR5C','iniadmin',true);

INSERT INTO albums(album_id, Judul, Penyanyi, Total_duration, Image_path, Tanggal_terbit, Genre)
VALUES ('62d67891-b39e-4b7e-95e0-c94003ef5edf','JUDUL-1', 'Penyanyi-1', 100, 'ForeverAlone.jpg', '2022-04-03', 'GENRE-1'),
('89c7918f-f56a-45a8-8a05-a1c780f30737','JUDUL-2', 'Penyanyi-2', 100, 'ForeverAlone.jpg', '2018-04-03', 'GENRE-2'),
('f5849461-7375-437c-b62c-724c13afb95e','JUDUL-3', 'Penyanyi-3', 100, 'ForeverAlone.jpg', '2021-04-03', 'GENRE-3'),
('93ba429c-3ce0-41c7-b8c7-f815af4b34ee','JUDUL-4', 'Penyanyi-4', 100, 'ForeverAlone.jpg', '2019-04-03', 'GENRE-4');

INSERT INTO songs(Judul, Penyanyi, Tanggal_terbit, Genre, Duration, Audio_path, Image_path, album_id)
VALUES ('SONG-1', 'Penyanyi-1', '2018-04-03', 'GENRE-1', 200, 'RapGod.mp3', 'ForeverAlone.jpg', '62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('SONG-2', 'Penyanyi-1', '2002-04-03', 'GENRE-1', 200, 'RapGod.mp3', 'ForeverAlone.jpg', '62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('SONG-3', 'Penyanyi-1', '2012-04-03', 'GENRE-1', 200, 'RapGod.mp3', 'ForeverAlone.jpg', '62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('SONG-4', 'Penyanyi-2', '2020-04-03', 'GENRE-2', 200, 'RapGod.mp3', 'ForeverAlone.jpg', 'f5849461-7375-437c-b62c-724c13afb95e');