#![allow(dead_code)]

use deadpool_postgres::{ManagerConfig, Runtime};
use postgres::NoTls;
use rocket::{
    fs::{relative, FileServer},
    launch, routes, Build, Rocket,
};

mod api;
mod cookie_util;
mod database;
mod frontend;
mod models;
mod php;

#[launch]
async fn rocket() -> Rocket<Build> {
    let mut config = deadpool_postgres::Config::new();
    config.dbname = Some("my_project".to_string());
    config.user = Some("andrew".to_string()); //change based on your system
    config.manager = Some(ManagerConfig {
        recycling_method: deadpool_postgres::RecyclingMethod::Fast,
    });

    let pool = config
        .create_pool(Some(Runtime::Tokio1), NoTls)
        .expect("Failed to create database pool");

    let _ = pool.get().await.expect("Connection validation failed");

    rocket::build()
        .mount("/", routes![frontend::history::get_history])
        .mount("/", FileServer::from(relative!("dist")))
        .mount("/api", routes![api::register::register])
        .manage(pool)
}
