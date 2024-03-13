use rocket::get;

use crate::php;
use rocket::http::ContentType;
use rocket::http::CookieJar;
use rocket::http::Status;

#[get("/history")]
/// generates the fuel history page based on a uuid.
/// cookies are not used yet but can be used to validate the users identity.
/// if cookies don`t exist return a permission denied error.
/// if an error occurs generating the page return a internal server error.
pub async fn get_history(cookies: &CookieJar<'_>) -> Result<(ContentType, String), Status> {
    match php::gen_php(
        "./php/history.html",
        vec!["190566c4-1b55-47ab-8a07-ff18765e6e5e"], // hardcoded value of uuid for this example; fix before final release
    )
    .await
    {
        Ok(val) => {
            // if it finished correctly return the page
            return Ok((ContentType::HTML, val));
        }
        Err(_) => {
            // if it returned an error send a server error
            return Err(Status::InternalServerError);
        }
    }
}
