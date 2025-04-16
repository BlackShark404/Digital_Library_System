<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission Example</title>
    <!-- Include Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

    <h1>Submit your information</h1>

    <!-- Form to collect data -->
    <form id="myForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br><br>

        <button type="submit">Submit</button>
    </form>

    <br>    

    <a href="/view">View Data</a>

    <script src="/assets/js/utility/formSubmit.js"></script>
    <script>
        // Make sure this URL is exactly correct - '/test' not '/tes'
        handleFormSubmission('myForm', '/test'); 
    </script>

</body>
</html>