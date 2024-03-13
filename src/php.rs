// use std::process::Command;

use async_process::Command;
use rocket::get;
use rocket::http::ContentType;
use rocket::http::Status;

pub async fn php(file: &str) -> Result<String, ()> {
    let output = match Command::new("php").arg("-f").arg(file).output().await {
        Ok(val) => val,
        Err(_) => return Err(()),
    };
    let hello = output.stdout;
    match String::from_utf8(hello) {
        Ok(val) => {
            // println!("{}", val);
            return Ok(val);
        }
        Err(_) => {
            // println!("somthing went wrong");
            return Err(());
        }
    }
}

#[get("/test_php")]
pub async fn test_php() -> Result<(ContentType, String), Status> {
    match php("./test/test.php").await {
        Ok(val) => {
            return Ok((ContentType::HTML, val));
        }
        Err(_) => {
            return Err(Status::InternalServerError);
        }
    }
}
