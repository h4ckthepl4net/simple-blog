import { configureStore } from "@reduxjs/toolkit";
import postsReducers from "./posts/posts";
import authReducers from "./auth/auth";

export default configureStore({
    reducer: {
        posts: postsReducers,
        auth: authReducers,
    }
});