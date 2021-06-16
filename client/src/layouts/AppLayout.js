import React from "react";
import Navbar from "../components/layouts/Navbar";
import Sidebar from "../components/layouts/Sidebar";

function AppLayout({ children }) {
    return (
        <div className="flex">
            <Sidebar className="w-1/5"/>
            <div className="bg-white py-5 pr-3 min-h-screen w-4/5">
                <div className="bg-blue-100 h-full rounded-3xl">
                    <Navbar/>
                    { children }
                </div>
            </div>
        </div>
    )
}

export default AppLayout