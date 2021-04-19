import React from "react";
import { Route } from "react-router-dom";

function AuthRoutes({ path, component, ...rest }) {

    return <Route component={component} {...rest} />

}

export default AuthRoutes; 