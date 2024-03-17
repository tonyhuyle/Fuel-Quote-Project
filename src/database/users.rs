use deadpool_postgres::Object;
use std::num::NonZeroU32;
use uuid::Uuid;

use ring::{
    digest,
    pbkdf2::{self, Algorithm},
    rand::{self, SecureRandom},
};

const CREDENTIAL_LEN: usize = digest::SHA512_OUTPUT_LEN;
static ALGORITHM: Algorithm = pbkdf2::PBKDF2_HMAC_SHA512;

use crate::models::User;

pub async fn create(user: &User, conn: &mut Object) -> Result<u64, postgres::Error> {
    conn.execute(
        "INSERT INTO users VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)",
        &[
            &user.user_id,
            &user.username,
            &user.address_1,
            &user.address_2,
            &user.city,
            &user.state,
            &user.done_setup,
            &user.password_hash,
            &user.password_salt,
        ],
    )
    .await
}

/// given a username and password return the user it coresponds to.
/// if user does not exist return None.
/// if there is an error return an Err.
pub async fn validate(
    username: &String,
    password: &String,
    conn: &mut Object,
) -> Result<Option<User>, postgres::Error> {
    let user_opt = conn
        .query_opt("SELECT * FROM users WHERE username=$1 LIMIT 1", &[username])
        .await?;
    let user: User = match user_opt {
        Some(row) => (&row).into(),
        None => return Ok(None),
    };
    let hash = user.password_hash.clone();
    let salt = user.password_salt.clone();

    let n_iter = NonZeroU32::new(100_000).unwrap();
    let verified = pbkdf2::verify(ALGORITHM, n_iter, &salt, password.as_bytes(), &hash);

    if verified.is_ok() {
        Ok(Some(user))
    } else {
        Ok(None)
    }
}

/// return the User that coresponds to an Uuid
/// if user does not exist return None.
/// if there is an error return an Err.
pub async fn get_by_id(id: &Uuid, conn: &mut Object) -> Result<Option<User>, postgres::Error> {
    let row_opt = conn
        .query_opt("SELECT * FROM users WHERE user_id=$1 LIMIT 1", &[id])
        .await?;
    Ok(row_opt.map(|r| (&r).into()))
}
