import React, { useContext, useEffect } from "react";
import {Link, useLocation, useHistory } from "react-router-dom";
import { AuthContext } from "../../context";

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
    const { logOut } = useContext(AuthContext);

    function isActive(route) {
        return location.pathname.includes(route);
    }

    function classNames() {
        return props.className + " flex flex-col p-6 justify-between";
    }

    function logOutUser(event) {
        event.preventDefault();
        logOut();
    }

    return (
        <div className={classNames()}>
            <div className="flex flex-col ">
                <span>Contact M.</span>
                <div className="flex flex-col mt-12">
                    {
                        routes.map((route) => {
                            return (
                                <div className={` ${isActive(route.link) ? "bg-blue-200 rounded-md -pl-1" : ""} pl-2 mt-2`} key={route.name}>
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
            <div>
                <a href="#" className="py-2 text-darkblue flex items-center" onClick={logOutUser}>
                    <i className="las la-power-off flex mr-2  text-xl bg-white h-full px-2 py-1 rounded-md bg-blue-50" />
                    Logout
                </a>
            </div>
        </div>
    )
}

export default Sidebar;