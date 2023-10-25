export class AuthServiceException extends Error {
    name = "AuthServiceException";

    constructor(cause, message) {
        super(message);
    }
}