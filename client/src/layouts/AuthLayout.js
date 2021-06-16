import React from "react";
import AuthAside from "../components/auth/AuthAside"

function AuthLayout({ children }) {
    return (
        <div className="h-screen">
            <div className="flex h-full">
                <div className="p-3 h-100 hidden lg:block lg:w-1/3">
                    <AuthAside />
                </div>
                <div className="w-full lg:w-2/3 h-100">
                    { children }
                </div>
            </div>
        </div>
    )
}

export default AuthLayout;