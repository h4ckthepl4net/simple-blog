import React, {useEffect, useRef, useState} from "react";
import {useDispatch, useSelector} from "react-redux";
import {PostsService} from "../../services/posts/PostsService";
import {setLoading, setPosts, setTotal, setPage, setViewablePost} from "../../store/posts/posts";
import {PageHeader} from "../../components/page-header/page-header";
import {PostPreview} from "../../components/post-preview/post-preview";
import './home.scss';
import '../../scss/page.scss';
import ReactPaginate from "react-paginate";
import {Link, useNavigate} from "react-router-dom";


const Home = () => {
    const navigate = useNavigate();
    const isInitializing = useRef(false);
    const isInitialized = useRef(false);
    const [error, setError] = useState(null);
    const isLoading = useSelector(state => state.posts.loading);
    const page = useSelector(state => state.posts.page);
    const limit = useSelector(state => state.posts.limit);
    const posts = useSelector(state => state.posts.posts);
    const total = useSelector(state => state.posts.total);
    const dispatch = useDispatch();

    const fetchPosts = async () => {
        dispatch(setLoading(true));
        const pageBefore = page;
        try {
            const result = await PostsService.getPosts(page, limit);
            dispatch(setPosts(result.posts));
            dispatch(setTotal(result.count));
            setError(null);
        } catch (e) {
            if (page === pageBefore) {
                dispatch(setPosts([]));
                dispatch(setTotal(0));
                console.error(e);
                setError({
                    message: "An error occurred while fetching posts.",
                    callback: fetchPosts,
                    text: "Retry",
                });
            }
        } finally {
            if (page === pageBefore) {
                dispatch(setLoading(false));
            }
        }
    }

    const viewPost = (post) => {
        // dispatch(setViewablePost(post));
        navigate(`/posts/${post.id}`);
    }

    useEffect(() => {
        if (!isInitializing.current) {
            (async () => {
                isInitializing.current = true;
                await fetchPosts();
                isInitializing.current = false;
                isInitialized.current = true;
            })();
        }
    }, []);

    useEffect(() => {
        if (isInitialized.current) {
            (async () => {
                await fetchPosts();
            })();
        }
    }, [page, limit]);

    return (
        <div className="page-container">
            <PageHeader title="Posts" loading={isLoading} error={error}/>
            <div className="posts-container">
                {
                    posts &&
                    posts.length > 0 &&
                    posts.map(post => (
                        <PostPreview key={post.id} post={post} overlay={isLoading} onClick={viewPost}/>
                    ))
                }
                {
                    (!posts || posts.length === 0) &&
                    !isLoading &&
                    <div className="posts-empty">
                        No posts
                        <Link to={"/posts/new"} className="btn btn-primary">Create one</Link>
                    </div>
                }
                {   total > limit &&
                    <ReactPaginate pageCount={total / limit}
                                   forcePage={page - 1}
                                   pageRangeDisplayed={1}
                                   marginPagesDisplayed={1}
                                   nextLabel={<span aria-hidden="true">&raquo;</span>}
                                   previousLabel={<span aria-hidden="true">&laquo;</span>}
                                   containerClassName={"pagination " + (isLoading ? "pagination-loading" : "")}
                                   pageClassName="page-item"
                                   pageLinkClassName="page-link"
                                   activeClassName="active"
                                   previousClassName="page-item"
                                   previousLinkClassName="page-link"
                                   nextClassName="page-item"
                                   nextLinkClassName="page-link"
                                   breakClassName="page-item"
                                   breakLinkClassName="page-link"
                                   disabledClassName="disabled"
                                   onPageChange={(data) => dispatch(setPage(data.selected + 1))}
                    />
                }
            </div>
        </div>
    )
};

export default Home