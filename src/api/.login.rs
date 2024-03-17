use deadpool_postgres::{Object, Pool};
use uuid::Uuid;

use rocket::{
    debug,
    form::Form,
    fs::TempFile,
    get,
    http::{Cookie, CookieJar, Status},
    post,
    response::Redirect,
    serde::json::Json,
    time::Duration,
    uri, warn, FromForm, State,
};

#[derive(FromForm, Debug)]
pub struct LoginForm {
    username: String,
    password: String,
}

#[post("/login", data = "<form>")]
pub async fn login(
    form: Form<LoginForm>,
    pool: &State<Pool>,
    cookies: &CookieJar<'_>,
) -> Result<Redirect, Status> {
    let mut conn = pool.get().await.unwrap();
    match database::users::validate(&form.username, &form.password, &mut conn).await {
        Ok(user_opt) => match user_opt {
            Some(user) => {
                let jwt = jwt_util::generate_jwt(&user, Duration::hours(2));
                let c = Cookie::new("jwt", jwt);
                cookies.add(c);
                Ok(Redirect::to(uri!("/profile/profile.html")))
            }
            None => Ok(Redirect::to(uri!("/login.html"))),
        },

        Err(e) => {
            println!("{}", e);
            Err(Status::InternalServerError)
        }
    }
}
