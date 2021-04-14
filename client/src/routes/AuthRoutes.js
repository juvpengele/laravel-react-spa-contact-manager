import React, { useEffect } from "react";
import { Route } from "react-router-dom";

function AuthRoutes({ path, component, ...rest }) {
    useEffect(() => {
        console.log("Auth routes");
    }, []);
    
    
    return <Route component={component} {...rest} />
}

export default AuthRoutes; 