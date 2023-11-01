import React from 'react';
import { NavLink } from 'react-router-dom';
import Nav from 'react-bootstrap/Nav';
import './header.scss';

export const Header = () => {
    return (
        <Nav className="px-3 navbar navbar-expand-sm navbar-light bg-light navbar-fixed-top">
            <NavLink className="nav-link" to="/">Posts</NavLink>
            <NavLink className="nav-link" to="/posts/new">Create Post</NavLink>
        </Nav>
    );
}