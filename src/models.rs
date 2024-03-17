use postgres::Row;
use serde::{Deserialize, Serialize};
use std::num::NonZeroU32;
use uuid::Uuid;

use ring::{
    digest,
    pbkdf2::{self, Algorithm},
    rand::{self, SecureRandom},
};
const CREDENTIAL_LEN: usize = digest::SHA512_OUTPUT_LEN;
static ALGORITHM: Algorithm = pbkdf2::PBKDF2_HMAC_SHA512;

// CREATE TABLE users (
//     user_id UUID PRIMARY KEY,
//     username TEXT NOT NULL,
//     address_1 TEXT,
//     address_2 TEXT,
//     city TEXT,
//     state TEXT,
//     done_setup  boolean NOT NULL,
//     password_hash BYTEA NOT NULL,
//     password_salt BYTEA NOT NULL
// );

#[derive(Debug, Serialize, Deserialize)]
pub struct User {
    pub user_id: Uuid,
    pub username: String,
    pub address_1: Option<String>,
    pub address_2: Option<String>,
    pub city: Option<String>,
    pub state: Option<String>,
    pub done_setup: bool,
    pub password_hash: Vec<u8>,
    pub password_salt: Vec<u8>,
}

impl User {
    pub fn new(username: String, password: String) -> Self {
        let n_iter = NonZeroU32::new(100_000).unwrap();
        let rng = rand::SystemRandom::new();

        let mut salt = [0u8; CREDENTIAL_LEN];
        let mut hash = [0u8; CREDENTIAL_LEN];

        rng.fill(&mut salt).expect("Failed to generate salt");
        pbkdf2::derive(ALGORITHM, n_iter, &salt, password.as_bytes(), &mut hash);
        let vec_hash = Vec::from(hash);
        let vec_salt = Vec::from(salt);
        User {
            user_id: Uuid::new_v4(),
            username,
            address_1: None,
            address_2: None,
            city: None,
            state: None,
            done_setup: false,
            password_hash: vec_hash,
            password_salt: vec_salt,
        }
    }
}

impl From<&Row> for User {
    fn from(value: &Row) -> Self {
        User {
            user_id: value.get("user_id"),
            username: value.get("username"),
            address_1: value.get("address_1"),
            address_2: value.get("address_2"),
            city: value.get("city"),
            state: value.get("state"),
            done_setup: value.get("done_setup"),
            password_hash: value.get("password_hash"),
            password_salt: value.get("password_salt"),
        }
    }
}
