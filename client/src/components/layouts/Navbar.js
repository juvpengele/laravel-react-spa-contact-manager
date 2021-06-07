import React from "react";
import {Link, useHistory, useLocation } from "react-router-dom";

const linksMap = [
    {
        name: "Mails",
        link: "/mails"
    },
    {
        name: "Groups",
        link: "/dashboard"
    },
    {
        name: "Contacts",
        link: "/mails"
    }
]

function Navbar() {


    const [userDropdownOpen, setUserDropdownOpen] = React.useState(false)

    function toggleUserDropdown() {
        setUserDropdownOpen((userDropdownOpen) => !userDropdownOpen);
    }


    return (
        <div className="flex justify-end rounded ">
            <div className="pr-8 pt-5">
                <a href="#" className="mr-6 text-xl">
                    <i className="la la-bell"></i>
                </a>
                <a href="#" onClick={toggleUserDropdown}>
                    <span className="mr-2">
                        User
                    </span>

                    <i className="la la-angle-down"></i>
                </a>
                <div className={
                    userDropdownOpen ? "origin-top-right absolute right-5 mt-4 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 " : "hidden"
                }>
                    <div className="py-1 " role="menu" aria-orientation="vertical"
                         aria-labelledby="options-menu">
                        <a href="#"
                           className="block block px-4 py-2 text-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-100 dark:hover:text-white dark:hover:bg-gray-600"
                           role="menuitem">
                            <span className="flex flex-col">
                                <span>
                                    Account
                                </span>
                            </span>
                        </a>
                        <a href="#"
                           className="block block px-4 py-2 text-md text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-100 dark:hover:text-white dark:hover:bg-gray-600"
                           role="menuitem">
                                <span className="flex flex-col">
                                    <span>
                                        Logout
                                    </span>
                                </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Navbar;