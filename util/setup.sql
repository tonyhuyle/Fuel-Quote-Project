
CREATE TABLE users (
    user_id UUID PRIMARY KEY,
    username TEXT NOT NULL,
    address_1 TEXT,
    address_2 TEXT,
    city TEXT,
    state TEXT,
    zipcode int,
    done_setup  boolean NOT NULL,
    password_hash BYTEA NOT NULL,
    password_salt BYTEA NOT NULL,
    email TEXT
);


CREATE TABLE fuel_quotes (
    id UUID PRIMARY KEY,
    owner UUID NOT NULL,
    date timestamp,
    address TEXT,
    gallons int,
    price real,
    total real
);

CREATE OR REPLACE FUNCTION create_profile_after_user_insert()
RETURNS TRIGGER AS $$
BEGIN
   INSERT INTO profiles(userid) VALUES (NEW.userid);
   RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_user_insert
AFTER INSERT ON users
FOR EACH ROW EXECUTE FUNCTION create_profile_after_user_insert();


