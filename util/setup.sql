
CREATE TABLE users (
    user_id UUID PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    done_setup  boolean NOT NULL,
    password_hash BYTEA NOT NULL,
    password_salt BYTEA NOT NULL
);


