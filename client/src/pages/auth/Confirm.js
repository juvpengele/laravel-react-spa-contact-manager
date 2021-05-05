import React  from "react";
import {Link, useHistory } from "react-router-dom";
import MaskInput from 'react-maskinput';
import { useFormik} from "formik";
import * as Yup from "yup"
import {Loader} from "../../components/utilities";
import {httpClient} from "../../config";
import {handleFormErrors} from "../../utilities/helpers";
import { useToasts } from "react-toast-notifications";
import {usePageTitle} from "../../hooks";
import {AuthContext} from "../../context";

const validationSchema = Yup.object().shape({
    token: Yup.string().required("Le champ est requis")
                    .min(5, "Le token doit avoir 5 caractères")
                    .max(5, "Le token doit avoir 5 caractères")
})

function Confirm() {

    usePageTitle("Confirm your email");

    const formik = useFormik({
        initialValues: {
            token: ""
        },
        validationSchema,
        onSubmit: confirmToken
    });
    const { addToast } = useToasts();
    const history = useHistory();
    const { login } = React.useContext(AuthContext)


    async function confirmToken(formValues, onSubmittingProps) {
        try {
            const { data } = await httpClient().post("/auth/confirm", formValues);
            addToast("Votre e-mail a été confirmée avec succès");

            login(data);
            history.push("/dashboard")
        } catch(errors) {
            if(errors.response?.data?.errors) {
                handleFormErrors(errors.response?.data?.errors, onSubmittingProps)
            }
        }
    }


    return (
        <div className="h-screen flex items-center justify-center flex-col">
            <div className="flex-1 md:w-full lg:w-1/2 mx-auto flex flex-col justify-center">
                <form action="" onSubmit={formik.handleSubmit}>
                    <h1 className="text-4xl mb-5">Confirm your email.</h1>
                    <div className="mb-4 mt-4">
                        <label htmlFor="password">Token</label>
                        <MaskInput alwaysShowMask maskChar=""
                                   mask="*****"
                                   className="form-input"
                                   placeholder="Enter the token you received by email"
                                   { ...formik.getFieldProps("token") }
                        />
                        { formik.errors.token &&  <span className="text-sm text-red-500 mt-1">{ formik.errors.token}</span> }
                    </div>
                    <div className="flex items-center justify-end pt-6">
                        <Link
                            className="border-gray-400 border-2 text-gray-700 bg-white-800 text-white px-5 py-2 rounded-md mr-2"
                            to="/auth/register">
                            <i className="la la-arrow-left mr-2"></i>
                            Back to registration
                        </Link>
                        <button
                            className="border-2 border-purple-400 text-white bg-purple-800 text-white px-5 py-2 rounded-md
                             flex justify-center items-center"
                            disabled={! formik.isValid || formik.isSubmitting}
                            type="submit"
                        >
                            { formik.isSubmitting && <Loader className="mr-2"/> }
                            Confirm
                        </button>
                    </div>
                </form>

            </div>

        </div>
    )
}

export default Confirm;