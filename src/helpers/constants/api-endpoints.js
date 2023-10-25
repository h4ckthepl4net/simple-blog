const ApiEndpoints = {
    user: '/auth/me',
    signIn: '/auth/login',
    register: '/auth/register',
    getPosts: '/posts',
    getPost: '/posts/:id',
    deletePost: '/posts/:id',
    editPost: '/posts/:id',
    createPost: '/posts/new',
}

export default ApiEndpoints;