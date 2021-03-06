import React, {useState, createContext } from "react";
import Storage from "../utilities/Storage";


const AuthContext = createContext({
    auth: null
});

const AuthProvider = ({ children}) => {

    function initialAuthState() {
        const auth = Storage.get("auth");

        return auth ? { auth } : null;
    }

    const [auth, setAuth] = useState(() => initialAuthState());


   function login(auth, callback) {
       setAuth(auth);
       Storage.add("auth", auth);

       return true;
   }

   function logOut() {
        Storage.remove("auth");
        setAuth({})
   }

   function isLoggedIn() {
       if(auth) {
           return auth.auth.hasOwnProperty("api_token") || false;
       }

       return false;
   }

   return (
       <AuthContext.Provider value={{ auth, login, logOut, isLoggedIn }}>
           { children }
       </AuthContext.Provider>
   )

}

export {
    AuthContext,
    AuthProvider
}