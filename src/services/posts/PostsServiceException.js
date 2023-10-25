export class PostsServiceException extends Error {
    name = "PostsServiceException";

    constructor(cause, message) {
        super(message);
    }
}