CREATE TYPE statusEnum AS ENUM ('PENDING', 'ACCEPTED', 'REJECTED');

CREATE TABLE IF NOT EXISTS subs (
    creator_id INT NOT NULL,
    subscriber_id INT REFERENCES users (user_id) ON UPDATE CASCADE on DELETE SET NULL,
    status statusEnum DEFAULT 'PENDING' NOT NULL,
    CONSTRAINT PK_Subs PRIMARY KEY (creator_id, subscriber_id)
);