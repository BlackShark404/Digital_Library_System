function handleAjaxFormSubmit(formId, actionUrl, successCallback, errorCallback) {
    const form = document.getElementById(formId);

    if (!form) {
        console.error(`Form with id "${formId}" not found`);
        return;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const data = {};

        formData.forEach((value, key) => {
            data[key] = value;
        });

        try {
            const response = await axios.post(actionUrl, JSON.stringify(data), {
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            // Pass the entire response data to successCallback
            successCallback(response.data);
        } catch (err) {
            console.error(err);
            errorCallback('Something went wrong. Please try again.');
        }
    });
}
