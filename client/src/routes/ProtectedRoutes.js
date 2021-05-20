import React, { useEffect, useContext } from "react";
import { Route, useHistory } from "react-router-dom";
import { AuthContext } from "../context";
import AppLayout from "../layouts/AppLayout";

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

    return (
        <AppLayout>
            <Route component={component} {...rest} />
        </AppLayout>
    )
    
}

export default ProtectedRoutes;