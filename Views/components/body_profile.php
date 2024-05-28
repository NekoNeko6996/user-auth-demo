<?php
include "../../Server/database/connect.php";
include "../../libraries/libraries.php";

if (!isset($_COOKIE['JWT']) || !JWT::check($_COOKIE['JWT'])) {
  header("Location: /../login.php");
  exit();
}

if (!isset($payload) || empty($payload)) {
  $payload = json_decode(JWT::decode($_COOKIE['JWT'])["payload"]);
}

if (!isset($user) || empty($user)) {
  $user = DBQuery("SELECT * FROM users INNER JOIN users_info ON users.userID = users_info.userID WHERE users.userID = ?", [$payload->userID], $connect);
  if ($user['numRows'] > 0) {
    $user = $user['result'][0];
  } else {
    $user = null;
  }
}
?>

<head>
  <link rel="stylesheet" href="css/profilePage.css">
</head>

<body>
  <?php if (empty($user) || $user === null): ?>
    <p>You are not logged in</p>
  <?php endif ?>
  <div class="profile-container">
    <div class="user-info">
      <te class="profile-user-avatar-container">
        <div>
          <img class="profile-user-avatar" src="../users/imgs/avatars/default_user_avatar.jpg" alt="user avatar">
          <img class="profile-user-avatar-background"
            src="../users/imgs/avatar_backgrounds/default-user-avatar-background.jpg" alt="">

        </div>
        <div>
          <p class="profile-user-name"><?php echo $user['userName'] ?></p>
          <textarea name="user-status-t-area" id="user-status-t-area">this is your status XD</textarea>
        </div>
      </te>
      <div class="profile-user-info">
        <table cellspacing="20">
          <tr>
            <th>
              <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M12 7V12L14.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                  stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </th>
            <td>
              <p>Date Register: <?= $user['createAt'] ?></p>
            </td>
          </tr>
          <tr>
            <th>
              <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 7.00005L10.2 11.65C11.2667 12.45 12.7333 12.45 13.8 11.65L20 7" stroke="#000000"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <rect x="3" y="5" width="18" height="14" rx="2" stroke="#000000" stroke-width="2"
                  stroke-linecap="round" />
              </svg>
            </th>
            <td><?php echo $user['userEmail'] ?></td>
          </tr>
          <tr>
            <th>
              <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M3 5.5C3 14.0604 9.93959 21 18.5 21C18.8862 21 19.2691 20.9859 19.6483 20.9581C20.0834 20.9262 20.3009 20.9103 20.499 20.7963C20.663 20.7019 20.8185 20.5345 20.9007 20.364C21 20.1582 21 19.9181 21 19.438V16.6207C21 16.2169 21 16.015 20.9335 15.842C20.8749 15.6891 20.7795 15.553 20.6559 15.4456C20.516 15.324 20.3262 15.255 19.9468 15.117L16.74 13.9509C16.2985 13.7904 16.0777 13.7101 15.8683 13.7237C15.6836 13.7357 15.5059 13.7988 15.3549 13.9058C15.1837 14.0271 15.0629 14.2285 14.8212 14.6314L14 16C11.3501 14.7999 9.2019 12.6489 8 10L9.36863 9.17882C9.77145 8.93713 9.97286 8.81628 10.0942 8.64506C10.2012 8.49408 10.2643 8.31637 10.2763 8.1317C10.2899 7.92227 10.2096 7.70153 10.0491 7.26005L8.88299 4.05321C8.745 3.67376 8.67601 3.48403 8.55442 3.3441C8.44701 3.22049 8.31089 3.12515 8.15802 3.06645C7.98496 3 7.78308 3 7.37932 3H4.56201C4.08188 3 3.84181 3 3.63598 3.09925C3.4655 3.18146 3.29814 3.33701 3.2037 3.50103C3.08968 3.69907 3.07375 3.91662 3.04189 4.35173C3.01413 4.73086 3 5.11378 3 5.5Z"
                  stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </th>
            <td><?php echo $user['phone'] ?></td>
          </tr>
          <tr>
            <th>
              <svg width="30px" height="30px" viewBox="0 0 1024 1024" fill="#000000" class="icon" version="1.1"
                xmlns="http://www.w3.org/2000/svg" stroke="#000000" stroke-width="25">
                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                <g id="SVGRepo_iconCarrier">
                  <path
                    d="M512 1012.8c-253.6 0-511.2-54.4-511.2-158.4 0-92.8 198.4-131.2 283.2-143.2h3.2c12 0 22.4 8.8 24 20.8 0.8 6.4-0.8 12.8-4.8 17.6-4 4.8-9.6 8.8-16 9.6-176.8 25.6-242.4 72-242.4 96 0 44.8 180.8 110.4 463.2 110.4s463.2-65.6 463.2-110.4c0-24-66.4-70.4-244.8-96-6.4-0.8-12-4-16-9.6-4-4.8-5.6-11.2-4.8-17.6 1.6-12 12-20.8 24-20.8h3.2c85.6 12 285.6 50.4 285.6 143.2 0.8 103.2-256 158.4-509.6 158.4z m-16.8-169.6c-12-11.2-288.8-272.8-288.8-529.6 0-168 136.8-304.8 304.8-304.8S816 145.6 816 313.6c0 249.6-276.8 517.6-288.8 528.8l-16 16-16-15.2zM512 56.8c-141.6 0-256.8 115.2-256.8 256.8 0 200.8 196 416 256.8 477.6 61.6-63.2 257.6-282.4 257.6-477.6C768.8 172.8 653.6 56.8 512 56.8z m0 392.8c-80 0-144.8-64.8-144.8-144.8S432 160 512 160c80 0 144.8 64.8 144.8 144.8 0 80-64.8 144.8-144.8 144.8zM512 208c-53.6 0-96.8 43.2-96.8 96.8S458.4 401.6 512 401.6c53.6 0 96.8-43.2 96.8-96.8S564.8 208 512 208z"
                    fill="" />
                </g>
              </svg>
            </th>
            <td>
              <?php echo $user['address'] ?>
            </td>
          </tr>
          <tr>
            <th>
              <svg fill="white" width="30px" height="30px" viewBox="0 0 52 52" data-name="Layer 1"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M38.3,27.2A11.4,11.4,0,1,0,49.7,38.6,11.46,11.46,0,0,0,38.3,27.2Zm2,12.4a2.39,2.39,0,0,1-.9-.2l-4.3,4.3a1.39,1.39,0,0,1-.9.4,1,1,0,0,1-.9-.4,1.39,1.39,0,0,1,0-1.9l4.3-4.3a2.92,2.92,0,0,1-.2-.9,3.47,3.47,0,0,1,3.4-3.8,2.39,2.39,0,0,1,.9.2c.2,0,.2.2.1.3l-2,1.9a.28.28,0,0,0,0,.5L41.1,37a.38.38,0,0,0,.6,0l1.9-1.9c.1-.1.4-.1.4.1a3.71,3.71,0,0,1,.2.9A3.57,3.57,0,0,1,40.3,39.6Z"
                  stroke="#000000" stroke-width="1" />
                <circle cx="21.7" cy="14.9" r="12.9" stroke="#000000" stroke-width="3" />
                <path
                  d="M25.2,49.8c2.2,0,1-1.5,1-1.5h0a15.44,15.44,0,0,1-3.4-9.7,15,15,0,0,1,1.4-6.4.77.77,0,0,1,.2-.3c.7-1.4-.7-1.5-.7-1.5h0a12.1,12.1,0,0,0-1.9-.1A19.69,19.69,0,0,0,2.4,47.1c0,1,.3,2.8,3.4,2.8H24.9C25.1,49.8,25.1,49.8,25.2,49.8Z"
                  stroke="#000000" stroke-width="3" />
              </svg>
            </th>
            <td>Admin</td>
          </tr>
          <tr>
            <th>
              <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M14 12C14 14.7614 11.7614 17 9 17H7C4.23858 17 2 14.7614 2 12C2 9.23858 4.23858 7 7 7H7.5M10 12C10 9.23858 12.2386 7 15 7H17C19.7614 7 22 9.23858 22 12C22 14.7614 19.7614 17 17 17H16.5"
                  stroke="#000000" stroke-width="2" stroke-linecap="round" />
              </svg>
            </th>
            <td>
              <a href="<?php echo $user['webLink'] ?>" target="_blank">
                <p>
                  <?php if (strlen($user['webLink']) > 35)
                    echo substr($user['webLink'], 0, 33) . '...';
                  else
                    echo $user['webLink'];
                  ?>
                </p>
              </a>
            </td>
        </table>
      </div>
    </div>
    <div class="user-edit-info">
      <div>
        <div class="edit-info-header">
          <p>Edit Info</p>
        </div>
        <div class="edit-info-body">
          <form action="#" class="edit-info-form">
            <div>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= $user['userName'] ?>">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $user['userEmail'] ?>">
              </div>
            </div>
            <div>
              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" name="phone" id="phone" value="<?= $user['phone'] ?>">
              </div>
              <div class="form-group">
                <label for="web">Web</label>
                <input type="text" name="web" value="<?= $user['webLink'] ?>">
              </div>
            </div>
            <div>
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?= $user['address'] ?>">
              </div>
            </div>
            <span>
              <button type="submit" class="normal-button" disabled>Confirm</button>
              <button type="reset" class="normal-button">Cancel</button>
            </span>
          </form>
        </div>
      </div>
      <div>
        <div class="edit-info-header">
          <p>Change Password</p>
        </div>
        <div class="edit-info-body">
          <form action="#" class="edit-info-form" onsubmit="changePassword(event)" id="change-password-form">
            <div class="form-group">
              <label for="old-password">Old Password</label>
              <input type="password" id="old-password" name="old-password" autocomplete="on"
                oninput="onchangePassInput()">
            </div>
            <div>
              <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new-password" autocomplete="on"
                  oninput="onchangePassInput()">
              </div>
              <div class="form-group">
                <label for="confirm-new-password">Confirm New Password</label>
                <input type="password" id="confirm-new-password" name="confirm-new-password" autocomplete="on"
                  oninput="onchangePassInput()">
              </div>
            </div>
            <span>
              <button type="submit" class="normal-button" disabled id="change-password-button">Confirm</button>
              <button type="reset" class="normal-button" onclick="onchangePassInput(true)">Cancel</button>
            </span>
          </form>
        </div>
      </div>

      <div>
        <div class="edit-info-header">
          <p>Delete Account</p>
        </div>
        <div class="edit-info-body">
          <form action="#" class="edit-info-form">
            <span>
              <button type="submit" class="alert-button" disabled>DELETED MY ACCOUNT</button>
            </span>
          </form>
        </div>
      </div>
    </div>
  </div>





  <script>
    $(document).ready(() => {
      $(".loading-layer").addClass("loading-layer-hide");
    })

    $("#user-status-t-area")
      .each(function () {
        this.setAttribute(
          "style",
          `height:${this.scrollHeight}px;overflow-y:hidden;`
        );
      })
      .on("input", function () {
        this.style.height = 0;
        this.style.height = `${this.scrollHeight}px`;
      });


    function onchangePassInput(disabled) {
      const newPassInput = $("#new-password");
      const confirmNewPassInput = $("#confirm-new-password");
      if (newPassInput.val() === confirmNewPassInput.val() && newPassInput.val() !== "" && confirmNewPassInput.val() !== "") {
        $("#change-password-button").prop("disabled", false);
      } else {
        $("#change-password-button").prop("disabled", true);
      }
      if (disabled) {
        $("#change-password-button").prop("disabled", true);
      }
    }

    // check new password
    function checkPassword(pass) {
      return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(pass);
    }

    function changePassword(event) {
      event.preventDefault();

      //
      const formData = $("#change-password-form").serialize();
      const oldPassInput = $("#old-password");
      const newPassInput = $("#new-password");
      const confirmNewPassInput = $("#confirm-new-password");


      if (!checkPassword(newPassInput.val())) {
        alert("Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number and one special character");
        return;
      }

      if (newPassInput.val() === confirmNewPassInput.val() && newPassInput.val() !== "" && confirmNewPassInput.val() !== "" && oldPassInput.val() !== "") {
        $.ajax({
          type: "POST",
          url: "../Server/api/changePasswordController.php",
          data: formData,
          success: (response) => {
            try {
              response = JSON.parse(response);
              if (response.status === "success") {
                console.log(response);
                alert("Change password successfully");
              } else {
                alert(response.message);
              }
            } catch (error) {
              console.log(error);
            }
          }
        });
      } else {
        alert("New password and confirm new password must be same");
      }
    }

  </script>
</body>