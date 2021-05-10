import React, { useEffect, useContext } from "react";
import { Route, useHistory } from "react-router-dom";
import { AuthContext } from "../context";

function ProtectedRoutes({ path, component, ...rest }) {

    const { auth } = useContext(AuthContext);
    const history = useHistory();

    useEffect(() => {
        redirectGuest()
    }, [auth]);

    function redirectGuest() {

        if(! auth) {
            history.push("/auth/login");
        }
    }

    return <Route component={component} {...rest} />
    
}

export default ProtectedRoutes;