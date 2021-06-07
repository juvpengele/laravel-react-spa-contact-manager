import React from "react";
import {Link, useLocation } from "react-router-dom";

const routes = [
    {
        name: "Tableau de bord",
        link: "/dashboard",
        icon: "la-dashboard"
    },
    {
        name: "E-mails",
        link: "/mails",
        icon: "la-envelope"
    },
    {
        name: "Groupes",
        link: "/groups",
        icon: "la-users"
    },
    {
        name: "Contacts",
        link: "/contacts",
        icon: "la-address-card"
    },
]

function Sidebar(props) {

    const location = useLocation();

    function isActive(route) {
        return location.pathname.includes(route);
    }

    function classNames() {
        return props.className + " flex flex-col p-6 justify-between";
    }

    return (
        <div className={classNames()}>
            <div className="flex flex-col ">
                <span>Contact M.</span>
                <div className="flex flex-col mt-10">
                    {
                        routes.map((route) => {
                            return (
                                <div className={` ${isActive(route.link) ? "bg-blue-200 rounded-md -pl-1" : ""} pl-2`}>
                                    <Link to={route.link} key={route.link} className={` ${isActive(route.link) ? "bg-blue-200 rounded-md " : ""}  py-2 text-darkblue flex items-center`}>
                                        <i className={ `${isActive(route.link) ? "bg-white " : "bg-blue-50 " } la ${route.icon} flex mr-2  text-xl bg-white h-full px-2 py-1 rounded-md`}/>
                                        { route.name }
                                    </Link>
                                </div>

                            )
                        })
                    }
                </div>
            </div>
            <span>
                <i className="las la-power-off mr-2" />
                Logout
            </span>
        </div>
    )
}

export default Sidebar;