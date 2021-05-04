import React from "react";
import { Route } from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";

function AuthRoutes({ path, component, ...rest }) {
    return (
        <AuthLayout>
            <Route component={component} {...rest} />
        </AuthLayout>
    )

}

export default AuthRoutes; 