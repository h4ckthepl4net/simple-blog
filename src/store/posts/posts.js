import { createSlice } from '@reduxjs/toolkit'

export const counterSlice = createSlice({
    name: 'posts',
    initialState: {
        page: 1,
        limit: 10,
        initialized: false,
        initializing: false,
        editablePost: null,
        posts: [],
        activeUserPosts: [],
    },
    reducers: {
        setEditablePost: (state, action) => {
            state.editablePost = action.payload;
        },
        removeEditablePost: (state) => {
            state.editablePost = null;
        },
        setPosts: (state, action) => {
            state.posts = action.payload;
        },
        setActiveUserPosts: (state, action) => {
            state.activeUserPosts = action.payload;
        },
        incrementPage: (state) => {
            state.page += 1;
        },
        changeLimit: (state, action) => {
            state.limit = action.payload;
        },
        setInitialized: (state, action) => {
            state.initialized = action.payload;
        },
        setInitializing: (state, action) => {
            state.initializing = action.payload;
        },
    },
});
export const {
    setActiveUserPosts,
    setEditablePost,
    setPosts,
    removeEditablePost,
    incrementPage,
    changeLimit,
    setInitialized,
    setInitializing,
} = counterSlice.actions

export default counterSlice.reducer