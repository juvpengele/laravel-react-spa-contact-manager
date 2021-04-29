import React from "react";
import { Link } from "react-router-dom";
import {usePageTitle} from "../../hooks";
import AuthLayout from "../../layouts/AuthLayout";
import * as Yup from "yup";
import { useFormik } from "formik";
import { httpClient } from "../../config";
import { Loader } from "../../components/utilities";
import { useToasts } from "react-toast-notifications"

const validationSchema = Yup.object().shape({
    name: Yup.string().required("Le nom est obligatoire"),
    username: Yup.string().required("Le nom d'utilisateur est obligatoire"),
    email: Yup.string().required("L'adresse e-mail est obligatoire").email("Veuillez fournir une adresse e-mail valide"),
    password: Yup.string().required("Le mot de passe est obligatoire").min(8, "Le mot de passe doit avoir au moins 8 caractères")
});

function Register() {
    const { addToast } = useToasts();
    const initialValues = {
        name: "",
        username: "",
        email: "",
        password: ""
    };

    function handleFormErrors(formErrors, onSubmittingProps) {
        for(let key in formErrors) {
            onSubmittingProps.setFieldError(key, formErrors[key]);
        }
    }

    async function handleSubmit(formValues, onSubmittingProps) {

        try {
            await httpClient().post("/auth/register", formValues);

            onSubmittingProps.resetForm();
            addToast("Bravo ! Votre inscription s'est bien passée... ", {
                appearance: "success",
                placement: "bottom-right"
            });

        } catch(errors) {
            if(errors.response?.data?.errors) {
                handleFormErrors(errors.response?.data?.errors, onSubmittingProps)
            }
        }
    }

    const formik = useFormik({
        initialValues,
        onSubmit: handleSubmit,
        validationSchema
    });


    usePageTitle("Register");

    return (
        <AuthLayout>
            <div className="h-full p-6 flex flex-col">
                <div className="pt-2 flex items-center justify-end">
                    Have already an account ? 
                    <Link to="/login" className="border-2 border-purple-400 text-purple-800 hover:text-white hover:bg-purple-800 text-white px-5 py-1 rounded-md ml-2">
                        Login
                    </Link>
                </div>
                <div className="flex-1 w-full lg:w-1/2 mx-auto flex flex-col justify-center">
                    <h1 className="text-4xl ">
                        Register
                    </h1>
                    <p className="mb-10"> Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    
                    <form onSubmit={formik.handleSubmit}>
                        <div className="mb-4">
                            <label htmlFor="name">Full name</label>
                            <input type="text" id="name" className="border-gray-300 border-2 rounded-md px-3 py-2 block focus:outline-none focus:shadow-outline w-full
                            " placeholder="John Doe"
                                value={formik.name}
                                {...formik.getFieldProps('name')}
                            />
                            {
                                formik.touched.name && formik.errors.name &&
                                <div className="text-sm text-red-500 mt-1">
                                    { formik.errors.name}
                                </div>
                            }
                            
                        </div>
                        <div className="mb-4">
                            <label htmlFor="username">Username</label>
                            <input type="text" id="username" className="border-gray-300 border-2 rounded-md px-3 py-2 block focus:outline-none focus:shadow-outline w-full
                            " 
                            placeholder="JohnDoe"
                            value={formik.username}
                                {...formik.getFieldProps('username')}
                            />
                            {
                                formik.touched.username && formik.errors.username &&
                                <div className="text-sm text-red-500 mt-1">
                                    { formik.errors.username}
                                </div>
                            }
                        </div>
                        <div className="mb-4">
                            <label htmlFor="email">Email</label>
                            <input type="email" id="email" className="border-gray-300 border-2 rounded-md px-3 py-2 block focus:outline-none focus:shadow-outline w-full
                            "
                            placeholder="john@example.com"
                            value={formik.email}
                            {...formik.getFieldProps('email')}
                            />
                            {
                                formik.touched.email && formik.errors.email &&
                                <div className="text-sm text-red-500 mt-1">
                                    { formik.errors.email}
                                </div>
                            }
                        </div>
                        <div className="mb-4">
                            <label htmlFor="password">Password</label>
                            <input type="password" id="password" className="
                            border-gray-300 border-2 rounded-md px-3 py-2 block focus:outline-none focus:shadow-outline w-full
                            " placeholder="********"
                            value={formik.password}
                            {...formik.getFieldProps('password')}
                            />
                            {
                                formik.touched.password && formik.errors.password &&
                                <div className="text-sm text-red-500 mt-1">
                                    { formik.errors.password}
                                </div>
                            }
                        </div>
                        <div className="flex items-center justify-end pt-6">
                            <Link className="border-gray-400 border-2 text-gray-700 bg-white-800 text-white px-5 py-2 rounded-md mr-2" to="/">
                                Go home
                            </Link>
                            <button className="border-2 border-purple-400 text-white bg-purple-800 text-white px-5 py-2 rounded-md
                             flex justify-center items-center"
                                disabled={! formik.isValid || formik.isSubmitting}
                            >
                                { formik.isSubmitting && <Loader className="mr-2"/> }
                                Register
                            </button>
                        </div>
                    </form>  
                </div>
            </div>
        </AuthLayout>
    )
}

export default Register;