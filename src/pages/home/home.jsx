import React, {useEffect} from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import {Spinner, Button} from "react-bootstrap";
import {useDispatch, useSelector} from "react-redux";
import {PostsService} from "../../services/posts/PostsService";
import { setInitialized, setInitializing, setPosts } from "../../store/posts/posts";


const Home = () => {
    const isInitialized = useSelector(state => state.posts.initialized);
    const isInitializing = useSelector(state => state.posts.initializing);
    const page = useSelector(state => state.posts.page);
    const limit = useSelector(state => state.posts.limit);
    const dispatch = useDispatch();

    useEffect(() => {
        if (!isInitialized && !isInitializing) {
            dispatch(setInitializing(true));
            (async () => {
                const posts = await PostsService.getPosts(page, limit);
                dispatch(setPosts(posts));
                dispatch(setInitialized(true));
                dispatch(setInitializing(false));
            })();
        }
    }, []);

    return (
        <div>
            <h1>Home</h1>
            <Button>
                button
            </Button>
            {
                isInitializing &&
                <Spinner animation="border" role="status">
                    <span className="visually-hidden">Loading...</span>
                </Spinner>
            }
        </div>
    )
}

export default Home