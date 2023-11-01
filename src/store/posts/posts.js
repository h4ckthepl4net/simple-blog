import { createSlice } from '@reduxjs/toolkit'

export const counterSlice = createSlice({
    name: 'posts',
    initialState: {
        page: 1,
        limit: 1,
        loading: false,
        editablePost: null,
        posts: [],
        total: 0,
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
        setTotal: (state, action) => {
            state.total = action.payload;
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
        setLoading: (state, action) => {
            state.loading = action.payload;
        },
        setPage: (state, action) => {
            state.page = action.payload;
        },
    },
});
export const {
    setActiveUserPosts,
    setEditablePost,
    setPosts,
    setTotal,
    removeEditablePost,
    incrementPage,
    changeLimit,
    setLoading,
    setPage,
} = counterSlice.actions

export default counterSlice.reducer