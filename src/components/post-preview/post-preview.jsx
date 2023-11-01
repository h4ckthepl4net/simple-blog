import React, {useMemo} from "react";
import './post-preview.scss';

const visibleCategoriesCount = 3;

export const PostPreview = ({ post }) => {
    const previewCategories = useMemo(() => post.categories?.slice(0, visibleCategoriesCount), [post.categories]);
    return (
        <div className="post-preview-container">
            <div className="post-author-title-container">
                <span className="post-author">Author: {post.author}</span>
                <h6 title={post.title}>{post.title}</h6>
            </div>
            {
                previewCategories && previewCategories.length > 0 &&
                <div className="post-categories-container">
                    {
                        previewCategories.map(category => (
                            <span key={category} className="post-category">{category}</span>
                        ))
                    }
                    {
                        post.categories.length > visibleCategoriesCount &&
                        <span className="post-category">
                            +{post.categories.length - visibleCategoriesCount}
                        </span>
                    }
                </div>
            }
            {
                !previewCategories && <div className="post-categories-container">No categories</div>
            }
        </div>
    );
};