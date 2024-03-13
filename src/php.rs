// use std::process::Command;

use async_process::Command;
use rocket::get;
use rocket::http::ContentType;
use rocket::http::Status;

// give a file and a Vector of arguments to pass to php
// this does not sanitise inputs before use
// make sure to do that before calling this function
pub async fn gen_php(file: &str, args: Vec<&str>) -> Result<String, ()> {
    let output = match Command::new("php")
        .arg("-f")
        .arg(file)
        .args(args)
        .output()
        .await
    {
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
    match gen_php("./test/test.php", vec!["uuid"]).await {
        Ok(val) => {
            return Ok((ContentType::HTML, val));
        }
        Err(_) => {
            return Err(Status::InternalServerError);
        }
    }
}
