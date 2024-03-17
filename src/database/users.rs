use deadpool_postgres::Object;
use uuid::Uuid;

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

pub async fn get_by_id(id: &Uuid, conn: &mut Object) -> Result<Option<User>, postgres::Error> {
    let row_opt = conn
        .query_opt("SELECT * FROM users WHERE user_id=$1 LIMIT 1", &[id])
        .await?;
    Ok(row_opt.map(|r| (&r).into()))
}
