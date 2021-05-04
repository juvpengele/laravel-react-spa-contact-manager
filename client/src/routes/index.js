import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

import AuthRoutes from "./AuthRoutes";

import {
    Home, Register, Login
} from "../pages"
import Confirm from "../pages/auth/Confirm";

function Routes() {
    return (
        <Router>
            <Switch>
                <Route path='/' component={Home} exact />
                <AuthRoutes path="/auth/login" component={Login} />
                <AuthRoutes path="/auth/register" component={Register} />
                <AuthRoutes path="/auth/confirm" component={Confirm} />
            </Switch>
        </Router>

    )
}

export default Routes;