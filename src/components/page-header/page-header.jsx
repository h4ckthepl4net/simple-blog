import React from 'react';
import {Button, Spinner} from "react-bootstrap";
import "./page-header.scss";

export const PageHeader = ({title, loading, error}) => {
    return (
        <div className="page-header">
            <h1>
                {title}
            </h1>
            {
                loading &&
                <Spinner animation="border" role="status" className="page-header-spinner"/>
            }
            {
                error &&
                <div className="page-header-error">
                    {error.message}
                    <Button className="page-header-error-action btn-secondary" onClick={error.callback}>
                        {error.text}
                    </Button>
                </div>
            }
        </div>
    )
}