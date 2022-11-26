CREATE TABLE IF NOT EXISTS songs (
    creator_id uuid primary key DEFAULT uuid_generate_v4(),
    subscriber_id uuid REFERENCES users (user_id) ON UPDATE CASCADE on DELETE SET NULL,
    status ENUM('ACCEPTED','REJECTED','PENDING') NOT NULL DEFAULT 'PENDING'
);