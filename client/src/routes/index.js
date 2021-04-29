import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

import AuthRoutes from "./AuthRoutes";

import {
    Home, Register, Login
} from "../pages"

function Routes() {
    return (
        <Router>
            <Switch>
                <Route path='/' component={Home} exact />
                <AuthRoutes path="/login" component={Login} />
                <AuthRoutes path="/register" component={Register} />
            </Switch>
        </Router>

    )
}

export default Routes;