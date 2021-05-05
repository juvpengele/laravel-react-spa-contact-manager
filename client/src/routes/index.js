import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import React from "react";

import AuthRoutes from "./AuthRoutes";
import {
    Home, Register, Login, Dashboard
} from "../pages"
import Confirm from "../pages/auth/Confirm";
import {AuthProvider} from "../context";

import ProtectedRoutes from "./ProtectedRoutes";

function Routes() {
    return (
        <AuthProvider>
            <Router>
                <Switch>
                    <Route path='/' component={Home} exact />
                    <AuthRoutes path="/auth/login" component={Login} />
                    <AuthRoutes path="/auth/register" component={Register} />
                    <AuthRoutes path="/auth/confirm" component={Confirm} />
                    <ProtectedRoutes path="/dashboard" component={Dashboard}/>
                </Switch>
            </Router>
        </AuthProvider>
    )
}

export default Routes;