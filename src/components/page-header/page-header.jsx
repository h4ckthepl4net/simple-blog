import React from 'react';
import {Spinner} from "react-bootstrap";
import "./page-header.scss";

export const PageHeader = ({title, loading}) => {
    return (
        <div className="page-header">
            <h1>
                {title}
            </h1>
            {
                loading &&
                <Spinner animation="border" role="status" className="page-header-spinner"/>
            }
        </div>
    )
}