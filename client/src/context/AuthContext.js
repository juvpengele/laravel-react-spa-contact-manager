import React, {useState, createContext, useEffect} from "react";
import Storage from "../utilities/Storage";

const AuthContext = createContext({
    auth: {}
});

const AuthProvider = ({ children}) => {
   const [auth, setAuth] = useState({});

   function authenticateUser() {
       const auth = Storage.get("auth");

       if(auth) {
           setAuth(auth);
       }
   }

   useEffect(() => {
        authenticateUser();
   }, []);

   function login(auth) {
       Storage.add("auth", auth)
       setAuth(auth);
   }

   function logOut() {
        Storage.remove("auth");
        setAuth({})
   }

   function isLoggedIn() {
        return !! auth;
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