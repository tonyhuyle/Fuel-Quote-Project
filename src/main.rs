use rocket::{
    fs::{relative, FileServer},
    launch, routes, Build, Rocket,
};

mod php;

#[launch]
async fn rocket() -> Rocket<Build> {
    // php::php("./test/test.php").await;

    rocket::build().mount("/", routes![php::test_php])
    // .mount("/", FileServer::from(relative!("static")))
}
