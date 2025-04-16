<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bootstrap Modal Form Example</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Trigger Button -->
<button class="btn btn-primary mt-5 ms-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Open Form Modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="myForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Submit Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="username" class="form-label">Username:</label>
          <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Toast (positioned bottom right) -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
  <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toastBody">Success!</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/assets/js/utility/form-handler.js"></script>

<script>
// Mock showToast function using Bootstrap toast
function showToast(title, message, type) {
  const toastEl = document.getElementById('liveToast');
  const toastBody = document.getElementById('toastBody');
  toastBody.textContent = message;
  toastEl.className = `toast align-items-center text-white bg-${type} border-0`;
  new bootstrap.Toast(toastEl).show();
}

// Use your form handler function
handleFormSubmission("myForm", "/test-modal");
</script>
</body>
</html>
