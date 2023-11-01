import React from "react";
import "bootstrap/dist/js/bootstrap.bundle.min";
import "bootstrap/dist/css/bootstrap.min.css";
import {Route, Routes} from "react-router-dom";
import Home from "./pages/home/home";
import {Header} from "./components/header/header";
import NewPost from "./pages/new-post/new-post";
import ViewPost from "./pages/view-post/view-post";
import {NotFound} from "./pages/not-found/not-found";

const App = () => {
    return (
        <div>
            <Header/>
            <Routes>
                <Route path="/" element={<Home/>}/>
                <Route path="/posts/new" element={<NewPost/>}/>
                <Route path="/posts/:id" element={<ViewPost/>}/>
                <Route path="*" element={<NotFound/>}/>
            </Routes>
        </div>
    )
}

export default App