-- Create username iniuser password 1234User
-- Create username iniadmin password 1234Admin
INSERT INTO users(name, email, password, username,isadmin) 
VALUES ('user','user@gmail.com','$2y$10$uRlGOMznczBOJDsFxQTAGONHxdmEsPonvvHJrRiDm/eGDsqVsua/K','iniuser',false),
('admin','admin@gmail.com','$2y$10$CpZ4uh/fW7C4m6CSUS3wieLcx7o4xjdvQff7pRndYyL2Pc9WpKR5C','iniadmin',true);

INSERT INTO albums(album_id, Judul, Penyanyi, Total_duration, Image_path, Tanggal_terbit, Genre)
VALUES ('62d67891-b39e-4b7e-95e0-c94003ef5edf','Music to be Murdered By', 'Eminem', 3901, 'MusicToBeMurderedBy.png', '2020-01-17', 'Hip-Hop');

INSERT INTO songs(song_id, Judul, Penyanyi, Tanggal_terbit, Genre, Duration, Audio_path, Image_path, album_id)
VALUES ('de000811-180b-4754-8b12-43ace91fd665','Alfred - Interlude','Eminem','2020-01-17','Hip-Hop',30,'AlfredInterlude.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('5762e9e3-dad7-45dd-932a-63b4308b8de0','Alfred - Outro','Eminem','2020-01-17','Hip-Hop',39,'AlfredOutro.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('3953f70e-22a6-4f48-b3fd-8d717399b54c','Darkness','Eminem','2020-01-17','Hip-Hop',337,'Darkness.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('5532b7cd-2e30-4905-8f6b-87cc94644101','Farewell','Eminem','2020-01-17','Hip-Hop',247,'Farewell.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('edf01db1-cd1a-4c17-9021-d9d9a650d4c9','Godzilla','Eminem','2020-01-17','Hip-Hop',210,'Godzilla.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('d3380b72-8b5a-43d7-9b7f-f8af47d7af19','In Too Deep','Eminem','2020-01-17','Hip-Hop',194,'InTooDeep.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('50634372-66b5-41ca-b555-168846f2b59c','I Will','Eminem','2020-01-17','Hip-Hop',303,'IWill.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('42f30197-3a63-45b1-a2cb-ce1eec1a9a0a','Leaving Heaven','Eminem','2020-01-17','Hip-Hop',266,'LeavingHeaven.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('e3ae5c94-7846-4716-91c3-1143a37e2d8b','Little Engine','Eminem','2020-01-17','Hip-Hop',177,'LittleEngine.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('a783a087-a056-4e01-bc6c-a236916b22ea','Lock It Up','Eminem','2020-01-17','Hip-Hop',170,'LockItUp.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('f4a14d59-279a-4bfe-9949-749b87f1ee53','Marsh','Eminem','2020-01-17','Hip-Hop',200,'Marsh.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('9a3cc122-f532-407b-81ff-50bb8eb7cfae','Never Love Again','Eminem','2020-01-17','Hip-Hop',177,'NeverLoveAgain.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('c827d99f-bcd8-49ac-baea-fc8fc51e8828','No Regrets','Eminem','2020-01-17','Hip-Hop',201,'NoRegrets.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('fc828eb9-fecf-4d9c-ba98-1db0f6b09309','Premonition - Intro','Eminem','2020-01-17','Hip-Hop',223,'PremonitionIntro.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('f16c64e8-0575-42a3-bdb3-9ebabc8085d3','Stepdad','Eminem','2020-01-17','Hip-Hop',213,'Stepdad.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('8b6a4f7d-d687-4ebf-858c-d53371f61ad6','Those Kinda Night','Eminem','2020-01-17','Hip-Hop',177,'ThoseKindaNight.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('af781f6a-33f7-4d47-bc4e-c1dbb484df0a','Unaccomodating','Eminem','2020-01-17','Hip-Hop',216,'Unaccomodating.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('6552aae4-3092-44d8-832f-3281c60c619f','Yah Yah','Eminem','2020-01-17','Hip-Hop',287,'YahYah.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('b96e7f25-bffc-45fe-85be-fc6b432de367','You Gon Learn','Eminem','2020-01-17','Hip-Hop',234,'YouGonLearn.mp3','MusicToBeMurderedBy.png','62d67891-b39e-4b7e-95e0-c94003ef5edf'),
('77472a99-5fbb-4844-8950-afe755a59cfa','Lose Yourself','Eminem','2002-10-08','Hip-Hop',328,'LoseYourself.mp3','LoseYourself.jpg',null),
('3c1e5e48-2e6b-469d-8397-29f4b7d544e9','This is What You Came for','Calvin Harris','2016-04-29','Hip-Hop',222,'ThisIsWhatYouCameFor.mp3','ThisIsWhatYouCameFor.png',null);

INSERT INTO subs(creator_id, subscriber_id, status) 
VALUES (1, 1 ,'PENDING'),
(2, 1 ,'PENDING');
