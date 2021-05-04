import React from "react";
import { Link } from "react-router-dom";

import { usePageTitle } from "../../hooks"

import * as Yup from "yup";
import { Formik, Form, Field, ErrorMessage} from "formik";
import {httpClient} from "../../config";
import {handleFormErrors} from "../../utilities/helpers";


const validationSchema = Yup.object().shape({
    email: Yup.string().required("L'adresse e-mail est obligatoire").email("Veuillez fournir une adresse e-mail valide"),
    password: Yup.string().required("Le mot de passe est obligatoire")
});
 
function Login() {
    usePageTitle("Login");
    const initialValues = {
        email: "",
        password: ""
    };

    async function handleSubmit(formValues, onSubmittingProps) {
        try {
            const response = await httpClient().post("/auth/login", formValues);
            console.log(response)
        } catch(errors) {
            if(errors.response?.data?.errors) {
                handleFormErrors(errors.response?.data?.errors, onSubmittingProps)
            }
        }

    }

    usePageTitle("Login");

    return (
        <div className="h-full p-6 flex flex-col">
            <div className="pt-2 flex items-center justify-end">
                Create a new account ?
                <Link to="/auth/register"
                      className="border-2 border-purple-400 text-purple-800 hover:text-white hover:bg-purple-800 text-white px-5 py-1 rounded-md ml-2">
                    Sign up
                </Link>
            </div>
            <div className="flex-1 md:w-full lg:w-1/2 mx-auto flex flex-col justify-center">
                <h1 className="text-4xl ">
                    Login
                </h1>
                <p className="mb-10"> Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>

                <Formik onSubmit={handleSubmit} initialValues={initialValues} validationSchema={validationSchema}>
                    {
                        (formik) => (
                            <Form>
                                <div className="mb-4">
                                    <label htmlFor="email">Email</label>
                                    <Field name="email" type="text" id="email" className="form-input"
                                           placeholder="JohnDoe"/>
                                    <ErrorMessage name="email" className="text-sm text-red-500 mt-1"
                                                  component="div"/>
                                </div>
                                <div className="mb-4">
                                    <label htmlFor="password">Password</label>
                                    <Field name="password" type="password" id="password"
                                           className="form-input"
                                           placeholder="********"/>
                                    <ErrorMessage name="password" className="text-sm text-red-500 mt-1"
                                                  component="div"/>

                                </div>
                                <div className="flex items-center justify-end pt-6">
                                    <Link
                                        className="border-gray-400 border-2 text-gray-700 bg-white-800 text-white px-5 py-2 rounded-md mr-2"
                                        to="/">
                                        Go home
                                    </Link>
                                    <button
                                        className="border-2 border-purple-400 text-white bg-purple-800 text-white px-5 py-2 rounded-md"
                                        disabled={!formik.isValid || formik.isSubmitting}
                                    >
                                        Login
                                    </button>
                                </div>
                            </Form>
                        )
                    }
                </Formik>
            </div>
        </div>
    )
}

export default Login;