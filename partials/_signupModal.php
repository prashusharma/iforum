<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Register on YourQueries</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/ITFORUM/partials/_handleSignup.php" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="signupName" class="form-label">Name</label>
            <input type="text" class="form-control" id="signupName" name="signupName" >
            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
          </div>
          <div class="mb-3">
            <label for="signupEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="signupEmail" name="signupEmail" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="signupPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="signupPassword" name="signupPassword">
          </div>
          <div class="mb-3">
            <label for="signupCPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="signupCPassword" name="signupCPassword">
          </div>
          
          <button type="submit" class="btn btn-primary">Signup</button>
        </div>
        
      </form>
    </div>
  </div>
</div>