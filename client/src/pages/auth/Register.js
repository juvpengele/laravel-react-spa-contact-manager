import React from "react";
import { Link } from "react-router-dom";

function Register() {
    return (
        <div>

            <h1 className="text-3xl">
                Register page
            </h1>
            <div>
                <Link to="/register">
                    Login
                </Link>
            </div>
            <div>
                <Link to="/">
                    Home
                </Link>
            </div>

        </div>
    )
}

export default Register;