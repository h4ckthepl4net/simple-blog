import React from "react";
import {PageHeader} from "../../components/page-header/page-header";

export const NewPost = () => {
    return (
        <div>
            <PageHeader title="New Post" loading={false}/>
        </div>
    );
};

export default NewPost;