import {ApiService} from "../api/ApiService";
import ApiEndpoints from "../../helpers/constants/api-endpoints";
import {PostsServiceException} from "./PostsServiceException";
import {constructPost} from "../../helpers/functions/constructPost";
import {AxiosError} from "axios";

export class PostsService {

    static async getPost(id) {
        try {
            const endpoint = ApiEndpoints.getPost.replace(':id', id);
            const response = await ApiService.get(endpoint);
            return constructPost(response.data);
        } catch (e) {
            if (e instanceof AxiosError) {
                if (e.response?.status === 404) {
                    throw new PostsServiceException(e, "Post not found");
                }
            }
            throw new PostsServiceException(e, "Failed to get post");
        }
    }


    static async getPosts(page = 1, limit = 10, authoredByCurrentUser = false) {
        try {
            const params = {
                page,
                limit,
            };
            if (authoredByCurrentUser) {
                params.own = 1;
            }
            const response = await ApiService.get(ApiEndpoints.getPosts, {
                params,
            });
            return {
                posts: response.data.posts.map((el) => constructPost(el)),
                count: response.data.count,
            };
        } catch (e) {
            console.log(e);
            throw new PostsServiceException(e, `Failed to get posts ${ authoredByCurrentUser ? 'of current user' : '' }`);
        }
    }

    static async createPost(title, content, categories) {
        try {
            const response = await ApiService.post(ApiEndpoints.createPost, {
                title,
                content,
                categories,
            });
            return constructPost({
                title,
                content,
                categories: categories.join(','),
                id: response.data.postId,
                created_at: new Date(),
            });
        } catch (e) {
            throw new PostsServiceException(e, "Failed to create post");
        }
    }

    static async deletePost(id) {
        try {
            const endpoint = ApiEndpoints.deletePost.replace(':id', id);
            return ApiService.delete(endpoint);
        } catch (e) {
            throw new PostsServiceException(e, "Failed to delete post");
        }
    }

    static async editPost(id, data) {
        try {
            const endpoint = ApiEndpoints.editPost.replace(':id', id);
            const response = await ApiService.patch(endpoint, data);
            return response.data.postId;
        } catch (e) {
            throw new PostsServiceException(e, "Failed to edit post");
        }
    }


}