insert into users VALUES(
    gen_random_uuid (),
    'name',
    TRUE,
    '\xDEADBEEF'::bytea,
    '\xDEADBEEF'::bytea
);

insert into history VALUES(
    gen_random_uuid(),
    gen_random_uuid(),
    clock_timestamp(),
    'here',
    10,
    1.0,
    10.0
);
