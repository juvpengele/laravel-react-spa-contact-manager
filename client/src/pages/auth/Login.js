import React from "react";
import { Link } from "react-router-dom";

function Login() {
    return (
        <div>
            <Link to="/register">
                Register
            </Link>
            Login page
        </div>
    )
}

export default Login;