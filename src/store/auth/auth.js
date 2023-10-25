import {createSlice} from '@reduxjs/toolkit'

export const authSlice = createSlice({
    name: 'auth',
    initialState: {
        token: null,
        currentUser: null,

    },
    reducers: {
        setCurrentUser: (state, action) => {
            state.currentUser = action.payload;
        },
        storeToken: (state, action) => {
            state.token = action.payload;
        },
        removeToken: (state) => {
            state.token = null;
        },
        removeCurrentUser: (state) => {
            state.currentUser = null;
        },
    },
})

export const {
    removeCurrentUser,
    removeToken,
    setCurrentUser,
    storeToken,
} = authSlice.actions

export default authSlice.reducer