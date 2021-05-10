import React, {useContext, useEffect} from "react";
import { Route, useHistory } from "react-router-dom";
import AuthLayout from "../layouts/AuthLayout";
import {AuthContext} from "../context";
import {useToasts} from "react-toast-notifications";

function AuthRoutes({ path, component, ...rest }) {

    const history = useHistory();
    const { auth }= useContext(AuthContext)
    const { addToast } = useToasts()

    useEffect(() =>  {
        redirectIfAuth();
    }, [ auth ]);

    function redirectIfAuth() {
        if(auth) {
            history.push("/dashboard");
            addToast("Vous êtes authentifié", {
                appearance: "info"
            })
        }
    }

    return (
        <AuthLayout>
            <Route component={component} {...rest} />
        </AuthLayout>
    )

}

export default AuthRoutes; 