import React from "react";
import { Link } from "react-router-dom";

import { usePageTitle } from "../../hooks"
import AuthLayout from "../../layouts/AuthLayout";

function Login() {

    usePageTitle("Login");

    return (
        <AuthLayout>
            <div className="h-full p-6 flex flex-col">
                <div className="pt-2 flex items-center justify-end">
                    Create a new account ? 
                    <Link to="/register" className="border-2 border-purple-400 text-purple-800 hover:text-white hover:bg-purple-800 text-white px-5 py-1 rounded-md ml-2">
                        Sign up
                    </Link>
                </div>
                <div className="flex-1 md:w-full lg:w-1/2 mx-auto flex flex-col justify-center">
                    <h1 className="text-4xl ">
                        Login
                    </h1>
                    <p className="mb-10"> Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    
                    <form>
                        
                        <div className="mb-4">
                            <label for="username">Username / email</label>
                            <input type="text" id="username" className="border-gray-300 border-2 rounded-md px-3 py-2 block focus:outline-none focus:shadow-outline w-full
                            " 
                            placeholder="JohnDoe"
                            />
                        </div>
                        <div className="mb-4">
                            <label for="password">Password</label>
                            <input type="password" id="password" className="
                            border-gray-300 border-2 rounded-md px-3 py-2 block focus:outline-none focus:shadow-outline w-full
                            " placeholder="********"/>
                        </div>
                        <div className="flex items-center justify-end pt-6">
                            <Link className="border-gray-400 border-2 text-gray-700 bg-white-800 text-white px-5 py-2 rounded-md mr-2" to="/">
                                Go home
                            </Link>
                            <button className="border-2 border-purple-400 text-white bg-purple-800 text-white px-5 py-2 rounded-md">
                                Login
                            </button>
                        </div>
                    </form>  
                </div>
            </div>
        </AuthLayout>
    )
}

export default Login;