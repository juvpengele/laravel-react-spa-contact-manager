import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import React from "react";

import AuthRoutes from "./AuthRoutes";
import {
    Home, Register, Login, Dashboard
} from "../pages"
import Confirm from "../pages/auth/Confirm";
import {AuthProvider} from "../context";

import ProtectedRoutes from "./ProtectedRoutes";
import Groups from "../pages/Groups";

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
                    <ProtectedRoutes path="/groups" component={Groups}/>
                </Switch>
            </Router>
        </AuthProvider>
    )
}

export default Routes;