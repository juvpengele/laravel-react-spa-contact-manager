import React, {useContext} from "react";
import { AuthContext } from "../../context";

function Navbar() {

    const [userDropdownOpen, setUserDropdownOpen] = React.useState(false);
    const { auth } = useContext(AuthContext);


    function toggleUserDropdown() {
        setUserDropdownOpen((userDropdownOpen) => !userDropdownOpen);
    }

    return (
        <div className="flex justify-end pr-6 pt-5 rounded ">
            <a href="#" className="mr-10 text-3xl">
                <i className="la la-bell"></i>
            </a>
            <a href="#" onClick={toggleUserDropdown} className="flex items-center">
                <span className="mr-2">
                    <img src={ auth?.auth?.avatar } alt="" width="30"/>
                </span>
            </a>

        </div>
    )
}

export default Navbar;