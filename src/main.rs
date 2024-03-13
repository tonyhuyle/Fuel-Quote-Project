use rocket::{
    fs::{relative, FileServer},
    launch, routes, Build, Rocket,
};

mod frontend;
mod php;

#[launch]
async fn rocket() -> Rocket<Build> {
    // php::php("./test/test.php").await;

    rocket::build()
        .mount("/", routes![frontend::history::get_history])
        .mount("/", FileServer::from(relative!("dist")))
}
