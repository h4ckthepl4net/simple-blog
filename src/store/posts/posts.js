import { createSlice } from '@reduxjs/toolkit'

export const counterSlice = createSlice({
    name: 'posts',
    initialState: {
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
    },
});
export const {
    setActiveUserPosts,
    setEditablePost,
    setPosts,
    removeEditablePost,
} = counterSlice.actions

export default counterSlice.reducer