import React from "react";

function AuthAside() {
    return (
        <div className="text-white flex flex-col items-center h-full justify-center mx-auto bg-purple-800 rounded-tl-md">
            <div className="w-3/4 ">
                <h1 className="text-4xl">Manage your contact</h1>
                <p className="pt-3">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
                <div className="flex justify-center mt-8">
                    <img src="/assets/img/auth-illustration.svg" width="300"/>
                </div>
                
            </div>
        </div>
    )
}

export default AuthAside;