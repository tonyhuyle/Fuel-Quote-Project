use serde::{Deserialize, Serialize};
use uuid::Uuid;

#[derive(Debug, Serialize, Deserialize)]
pub struct DumbUser {
    pub user_id: Uuid,
    pub username: String,
    pub address_1: Option<String>,
    pub address_2: Option<String>,
    pub city: Option<String>,
    pub state: Option<String>,
    pub done_setup: bool,
}

impl DumbUser {
    pub fn new(username: String) -> Self {
        DumbUser {
            user_id: Uuid::new_v4(),
            username,
            address_1: None,
            address_2: None,
            city: None,
            state: None,
            done_setup: false,
        }
    }
}
