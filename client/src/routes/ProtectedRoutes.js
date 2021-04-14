import React, { useEffect } from "react";
import { Route } from "react-router-dom";

function ProtectedRoutes({ path, component, ...rest }) {
    useEffect(() => {
        console.log("Protected routes");
    }, []);


    return <Route component={component} {...rest} />
}

export default ProtectedRoutes;