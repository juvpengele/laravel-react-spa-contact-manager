import React from "react";
import AuthAside from "../components/auth/AuthAside"

function AuthLayout({ children }) {
    return (
        <div className="h-screen">
            <div className="flex h-full">
                <div className="w-1/3 p-3 h-100">
                    <AuthAside />
                </div>
                <div className="w-2/3 h-100">
                    { children }
                </div>
            </div>
        </div>
       
    )
}

export default AuthLayout;