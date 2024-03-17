use crate::database;
use crate::models::User;
use deadpool_postgres::Object;
use rocket::{
    http::{Cookie, CookieJar},
    time::{Duration, OffsetDateTime},
};
use sha2::Sha256;
use std::borrow::Cow;
use std::{collections::BTreeMap, str::FromStr};
use uuid::Uuid;

pub fn add_user_cookie(cookies: &CookieJar<'_>, user: &User) {
    let s = user.clone().user_id.to_string();
    let c = Cookie::new("my-cookie", s);
    cookies.add_private(c);
}

pub async fn validate_from_cookie(cookies: &CookieJar<'_>, conn: &mut Object) -> Option<User> {
    match cookies.get_private("my-cookie") {
        Some(cookie) => {
            let uuid = match Uuid::from_str(cookie.value()) {
                Ok(N) => N,
                Err(_) => return None,
            };
            return database::users::get_by_id(&uuid, conn)
                .await
                .unwrap_or(None);
        }
        None => None,
    }
}
