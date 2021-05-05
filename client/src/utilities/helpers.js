export function handleFormErrors(formErrors, onSubmittingProps) {
    Object.keys(formErrors).forEach(key => {
        onSubmittingProps.setFieldError(key, formErrors[key]);
    })
}