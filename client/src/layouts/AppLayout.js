import React from "react";
import Navbar from "../components/layouts/Navbar";

function AppLayout({ children }) {
    return (
        <div>
            <Navbar/>
            <div className="bg-blue-50 min-h-screen">
                { children }
            </div>

        </div>
    )
}

export default AppLayout