// ajaxForm.js
function handleAjaxFormSubmit(formId, actionUrl, successCallback, errorCallback) {
    const form = document.getElementById(formId);

    if (!form) {
        console.error(`Form with id "${formId}" not found`);
        return;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();  // Prevent the default form submission

        const formData = new FormData(form);
        const data = {};

        formData.forEach((value, key) => {
            data[key] = value;
        });

        try {
            const response = await axios.post(actionUrl, data);

            if (response.data.success) {
                // Call success callback (e.g., redirect, success message, etc.)
                successCallback(response.data);
            } else {
                // Call error callback (e.g., display error message)
                errorCallback(response.data.message);
            }
        } catch (err) {
            console.error(err);
            errorCallback('Something went wrong. Please try again.');
        }
    });
}
