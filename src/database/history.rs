use deadpool_postgres::Object;
use std::num::NonZeroU32;
use uuid::Uuid;

use crate::*;

use models::History;

/// returns a Vec of history of all transactions owned by id
///
/// this has not been tested yet
pub async fn get_by_owner(id: &Uuid, conn: &mut Object) -> Result<Vec<History>, postgres::Error> {
    let row_vec = conn
        .query("SELECT * FROM history where owner = $1", &[id])
        .await?;
    Ok(row_vec.into_iter().map(|r| (&r).into()).collect())
}

/// inserts value into history table
/// returns num of rows changed or Error
///
/// this has not been tested yet
pub async fn insert_history(history: History, conn: &mut Object) -> Result<u64, postgres::Error> {
    conn.execute("insert into history values ($1)", &[&history])
        .await
}
