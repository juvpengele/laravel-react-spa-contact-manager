import React, { useEffect, useContext } from "react";
import { Route, useHistory } from "react-router-dom";
import { AuthContext } from "../context";
import {useToasts} from "react-toast-notifications";

function ProtectedRoutes({ path, component, ...rest }) {

    const { auth } = useContext(AuthContext);
    const { addToast } = useToasts();
    const history = useHistory();

    useEffect(() => {
        redirectGuest()
    }, [auth]);

    function redirectGuest() {

        if(! auth) {
            history.push("/auth/login");
            addToast("Vous n'avez pas le droit d'accéder à cette page", {
                appearance: 'error',
            })
        }
    }

    return <Route component={component} {...rest} />
    
}

export default ProtectedRoutes;