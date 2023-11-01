import React, {useEffect, useRef} from "react";
import {useDispatch, useSelector} from "react-redux";
import {PostsService} from "../../services/posts/PostsService";
import {setInitialized, setInitializing, setPosts, setTotal} from "../../store/posts/posts";
import {PageHeader} from "../../components/page-header/page-header";
import {PostPreview} from "../../components/post-preview/post-preview";
import './home.scss';


const Home = () => {
    const isInitializingRef = useRef(false);
    const isInitialized = useSelector(state => state.posts.initialized);
    const isInitializing = useSelector(state => state.posts.initializing);
    const page = useSelector(state => state.posts.page);
    const limit = useSelector(state => state.posts.limit);
    const posts = useSelector(state => state.posts.posts);
    const dispatch = useDispatch();

    useEffect(() => {
        if (!isInitialized && !isInitializingRef.current) {
            isInitializingRef.current = true;
            dispatch(setInitializing(true));
            (async () => {
                const result = await PostsService.getPosts(page, limit);
                dispatch(setPosts(result.posts));
                dispatch(setTotal(result.total));
                dispatch(setInitialized(true));
                isInitializingRef.current = false;
                dispatch(setInitializing(false));
            })();
        }
    }, []);

    useEffect(() => {

    }, [page]);

    return (
        <div>
            <PageHeader title="Posts" loading={isInitializing}/>
            <div className="posts-container">
                {
                    posts.map(post => (
                        <PostPreview key={post.id} post={post}/>
                    ))
                }
                <ul className="pagination">
                    <li className="page-item">
                        <a className="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <li className="page-item">
                        <a className="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    )
};

export default Home