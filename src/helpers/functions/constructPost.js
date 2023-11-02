import {Post} from "../../models/Post";

export function constructPost(postData) {
    return {
        id: postData.id,
        title: postData.title,
        content: postData.content,
        author: postData.username,
        categories: postData.categories.split(','),
        date: postData.created_at,
    };
}