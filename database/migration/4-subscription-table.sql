CREATE TABLE IF NOT EXISTS subcriptions (
    creator_id SERIAL primary key,
    subscriber_id INTEGER REFERENCES users (user_id) ON UPDATE CASCADE on DELETE SET NULL,
    status ENUM('ACCEPTED','REJECTED','PENDING') NOT NULL DEFAULT 'PENDING'
);