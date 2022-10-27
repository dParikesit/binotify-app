-- Create username iniuser password 1234User
-- Create username iniadmin password 1234Admin
INSERT INTO users(name, email, password, username,isadmin) 
VALUES ('user','user@gmail.com','$2y$10$uRlGOMznczBOJDsFxQTAGONHxdmEsPonvvHJrRiDm/eGDsqVsua/K','iniuser',false),
('admin','admin@gmail.com','$2y$10$CpZ4uh/fW7C4m6CSUS3wieLcx7o4xjdvQff7pRndYyL2Pc9WpKR5C','iniadmin',true);

INSERT INTO albums(album_id, Judul, Penyanyi, Total_duration, Image_path, Tanggal_terbit, Genre)
VALUES ('62d67891-b39e-4b7e-95e0-c94003ef5edf','JUDUL-1', 'Mamah Dedeh', 1161, 'ForeverAlone.jpg', '2022-04-03', 'GENRE-1'),
('89c7918f-f56a-45a8-8a05-a1c780f30737','JUDUL-2', 'Penyanyi-2', 0, 'ForeverAlone.jpg', '2018-04-03', 'GENRE-2'),
('f5849461-7375-437c-b62c-724c13afb95e','JUDUL-3', 'Penyanyi-3', 0, 'ForeverAlone.jpg', '2021-04-03', 'GENRE-3'),
('93ba429c-3ce0-41c7-b8c7-f815af4b34ee','JUDUL-4', 'Penyanyi-4', 0, 'ForeverAlone.jpg', '2019-04-03', 'GENRE-4');

INSERT INTO songs(song_id, Judul, Penyanyi, Tanggal_terbit, Genre, Duration, Audio_path, Image_path, album_id)
VALUES ('4508c8c4-12a9-479f-b43c-07ff8621924a','Rap God-1', 'Mamah Dedeh', '2018-04-03', 'ROCK', 387, 'RapGod.mp3', 'ForeverAlone.jpg', '62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('1f49105a-3516-45f3-afbf-bec359bc6b54','Rap God-2', 'Mamah Dedeh', '2002-04-03', 'ROCK', 387, 'RapGod.mp3', 'ForeverAlone.jpg', '62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('07225eb5-abd8-4376-ba59-8f399a989313','Rap God-3', 'Mamah Dedeh', '2012-04-03', 'ROCK', 387, 'RapGod.mp3', 'ForeverAlone.jpg', '62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('fe7643ce-a1a5-424b-9641-4ee3c409d8bd','Rap God-4', 'Mamah Dedeh', '2020-04-03', 'ROCK', 387, 'RapGod.mp3', 'ForeverAlone.jpg', null);