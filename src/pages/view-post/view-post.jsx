import React, {useEffect, useRef, useState} from "react";
import {Link, useNavigate, useParams} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {setViewablePost, removeViewablePost} from "../../store/posts/posts";
import {PostsService} from "../../services/posts/PostsService";
import {PageHeader} from "../../components/page-header/page-header";
import './view-post.scss';
import {Button} from "react-bootstrap";

export const ViewPost = () => {
    const { id } = useParams();
    const [isLoading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const isFetching = useRef(false);
    const postData = useSelector(state => state.posts.viewablePost);
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const fetchPost = async () => {
        try {
            setLoading(true);
            isFetching.current = true;
            const post = await PostsService.getPost(id);
            dispatch(setViewablePost(post));
        } catch (e) {
            console.error(e);
            setError({
                message: "An error occurred while fetching post. " + e.message,
                callback: fetchPost,
                text: "Retry",
            });
        } finally {
            isFetching.current = false;
            setLoading(false);
        }
    }

    const handleDelete = async () => {
        try {
            setLoading(true);
            await PostsService.deletePost(id);
            dispatch(removeViewablePost());
            navigate("/");
        } catch (e) {
            console.error(e);
            setError({
                message: "An error occurred while deleting post. " + e.message,
                callback: handleDelete,
                text: "Retry",
            });
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        if (!isFetching.current && (!postData || postData.id !== Number(id))) {
            (async () => {
                await fetchPost();
            })();
        }
    }, []);

    return (
        <div className="page-container">
            <PageHeader title={`Post ${id}`} loading={isLoading} error={error}/>
            {postData && postData.id === Number(id) && (
                <div className="post-container">
                    <div className="post-container-actions">
                        <Link to="/">&lt; Posts</Link>
                        <Button variant="primary" onClick={handleDelete}>Delete</Button>
                    </div>
                    <h5 className="post-title">
                        {postData.title}
                    </h5>
                    <div className="post-categories-container">
                        {postData.categories.map((category, index) => (
                            <div key={index} className="post-category">
                                {category}
                            </div>
                        ))}
                    </div>
                    <div className="post-content">
                        {postData.content}
                    </div>
                </div>
            )}
        </div>
    );
};

export default ViewPost;