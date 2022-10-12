CREATE TABLE IF NOT EXISTS users (
    user_id INTEGER primary key,
    email VARCHAR(256) NOT NULL,
    password VARCHAR(256) NOT NULL,
    username VARCHAR(256) NOT NULL,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE
);