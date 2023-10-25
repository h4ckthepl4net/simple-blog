export class ApiServiceException extends Error {
    name = "ApiServiceException";

    constructor(cause, message) {
        super(message);
    }
}