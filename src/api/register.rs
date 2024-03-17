use crate::models::User;
use crate::{cookie_util, database};
use deadpool_postgres::Pool;

use rocket::{
    debug,
    form::Form,
    http::{CookieJar, Status},
    post,
    response::Redirect,
    uri, FromForm, State,
};

#[derive(FromForm, Debug)]
pub struct RegisterForm {
    username: String,
    password: String,
}

// curl -X POST "localhost:8000/api/register" -F username=joe -F password=joe
#[post("/register", data = "<form>")]
pub async fn register(
    form: Form<RegisterForm>,
    pool: &State<Pool>,
    cookies: &CookieJar<'_>,
) -> Result<Redirect, Status> {
    let mut conn = pool.get().await.unwrap();
    let user = User::new(form.username.clone(), form.password.clone());

    match database::users::create(&user, &mut conn).await {
        Ok(_) => {
            cookie_util::add_user_cookie(&cookies, &user);
            Ok(Redirect::to(uri!("/profile/profile.html")))
        }
        Err(e) => {
            debug!("{}", e);
            Ok(Redirect::to(uri!("/register?error")))
        }
    }
}
