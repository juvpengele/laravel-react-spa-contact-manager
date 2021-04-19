import React from "react";
import { Link } from "react-router-dom";

import { usePageTitle } from "../../hooks"
import AuthLayout from "../../layouts/AuthLayout";

function Login() {

    usePageTitle("Login");

    return (
        <AuthLayout>
            <div>
                <Link to="/register">
                    Register
                </Link>
                Login page
            </div>
        </AuthLayout>
        
    )
}

export default Login;