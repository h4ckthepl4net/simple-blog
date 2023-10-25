import {Post} from "../../models/Post";

export function constructPost(postData) {
    return new Post(
        postData.id,
        postData.title,
        postData.content,
        postData.categories,
        postData.user_id,
        postData.created_at,
    );
}