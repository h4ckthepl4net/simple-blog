import {User} from "../../contexts/auth/models/User";

export function constructUser(userData) {
    return new User(
        userData.id,
        userData.username,
        userData.password,
    );
}