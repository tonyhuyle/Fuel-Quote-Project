insert into users VALUES(
    gen_random_uuid (),
    'name',
    '4333 University Drive',
    NULL,
    'Houston',
    'TX',
    77204,
    TRUE,
    '\xa181ca2fcea00a6c381d145178270a8a46529fb9b2367e5c7f1ba80c6d89043981717b526013c5aa93c587525aabcf87533d908aa920aa14bb49bbc4a869366b'::bytea,
    '\xef850c3f0f023d05330058877cc76804c88ac4188b270c7150935358348d1a80ee4c2649e6aac33f0eab3600b61777d6259294dadc61bef9b7ba944fcdfa6b1d'::bytea,
    'example@example.com'
);
-- these hashes and salts correspond to a password of joe


insert into history VALUES(
    gen_random_uuid(),
    gen_random_uuid(),
    clock_timestamp(),
    'here',
    10,
    1.0,
    10.0
);
