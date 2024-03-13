insert into users VALUES(
    gen_random_uuid (),
    'name',
    TRUE,
    '\xDEADBEEF'::bytea,
    '\xDEADBEEF'::bytea
);

