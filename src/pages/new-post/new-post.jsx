import React, {useRef, useState} from "react";
import {PageHeader} from "../../components/page-header/page-header";
import {Button, Form} from "react-bootstrap";
import '../../scss/page.scss';
import './new-post.scss';
import {Link} from "react-router-dom";
import {PostsService} from "../../services/posts/PostsService";

const categoryRegex = /^[a-zA-Z0-9]+$/;

export const NewPost = () => {
    const formState = useRef({
        title: '',
        content: '',
    });
    const [formErrors, setFormErrors] = useState({
        title: null,
        content: null,
    });
    const [error, setError] = useState(null);
    const [posting, setPosting] = useState(false);
    const [validated, setValidated] = useState(false);
    const [categories, setCategories] = useState([]);

    const handlePost = async () => {
        setPosting(true);
        try {
            await PostsService.createPost(formState.current.title, formState.current.content, categories);
            setError(null);
        } catch (e) {
            console.error(e);
            setError({
                message: "An error occurred while posting.",
                callback: handlePost,
                text: "Retry",
            });
        } finally {
            setPosting(false);
        }
    };

    const handleCategoryKeyDown = (event) => {
        if (
            (
                event.key === 'Enter' ||
                event.key === ',' ||
                event.key === ';' ||
                event.key === ' '
            )
        ) {
            event.preventDefault();
            event.stopPropagation();
            if (event.target.value && event.target.value.length <= 50 && categoryRegex.test(event.target.value)) {
                categories.push(event.target.value.toLowerCase());
                const set = new Set(categories);
                setCategories([...set]);
                event.target.value = '';
                setFormErrors({
                    ...formErrors,
                    categories: false,
                });
            } else if (event.target.value.length > 50) {
                setFormErrors({
                    ...formErrors,
                    categories: true,
                });
            }
        }
    }

    const handleInputChange = (event) => {
        formState.current[event.target.name] = event.target.value;
        if (event.target.name === 'title') {
            if (event.target.value.length < 5 || event.target.value.length > 255) {
                setFormErrors({
                    ...formErrors,
                    title: true,
                    categories: false,
                })
            } else {
                setFormErrors({
                    ...formErrors,
                    title: false,
                    categories: false,
                });
            }
        }
        if (event.target.name === 'content') {
            if (event.target.value.length < 30 || event.target.value.length > 1000) {
                setFormErrors({
                    ...formErrors,
                    content: true,
                    categories: false,
                })
            } else {
                setFormErrors({
                    ...formErrors,
                    content: false,
                    categories: false,
                });
            }
        }
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        event.stopPropagation();
        const isValid = event.currentTarget.checkValidity();
        if (isValid) {
            (async () => {
                await handlePost();
            })();
        }
        setValidated(true);
    }

    const removeCategory = (category) => {
        setCategories(categories.filter(c => c !== category));
    }

    const handleReset = () => {
        setValidated(false);
        setCategories([]);
        formState.current = {
            title: '',
            content: '',
        };
    }

    return (
        <div className="page-container">
            <PageHeader title="New Post" loading={posting} error={error}/>
            <Form noValidate validated={validated} onSubmit={handleSubmit} onChange={handleInputChange}>
                <Form.Group className="mb-3" controlId="newPostForm.titleInput">
                    <Form.Label>Post Title</Form.Label>
                    <Form.Control required type="text" name="title" isInvalid={formErrors.title}/>
                    <Form.Control.Feedback type="invalid">
                        Post title is required to be 5-255 characters long.
                    </Form.Control.Feedback>
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Post Categories</Form.Label>
                    <Form.Control isInvalid={categories.length > 10 || formErrors.categories} type="text" onKeyDown={handleCategoryKeyDown}/>
                    <Form.Control.Feedback type="invalid">
                        You can choose 0-10 categories. Categories must be 1-50 characters long and contain only letters and numbers.
                    </Form.Control.Feedback>
                    <Form.Control.Feedback className="new-post-categories-container">
                        {
                            categories.map(category => (
                                <div title="Click to remove" key={category} className="post-category" onClick={() => removeCategory(category)}>{category}</div>
                            ))
                        }
                    </Form.Control.Feedback>
                </Form.Group>
                <Form.Group className="mb-3" controlId="newPostForm.contentTextArea">
                    <Form.Label>Post Content</Form.Label>
                    <Form.Control required as="textarea" rows={5} name="content" isInvalid={formErrors.content}/>
                    <Form.Control.Feedback type="invalid">
                        Post content is required to be 30-1000 characters long.
                    </Form.Control.Feedback>
                </Form.Group>
                <div className="new-post-form-action-container">
                    <Button type="submit" variant="primary" disabled={posting}>
                        Create Post
                    </Button>
                    <Button type="reset" variant="light" disabled={posting} onClick={handleReset}>
                        Reset Form
                    </Button>
                    <Link to="/" className="btn btn-secondary" variant="secondary" disabled={posting}>
                        Cancel
                    </Link>
                </div>
            </Form>
        </div>
    );
};

export default NewPost;