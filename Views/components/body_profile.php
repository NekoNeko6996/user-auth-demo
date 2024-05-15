<?php



?>

<head>
  <link rel="stylesheet" href="css/profilePage.css">
</head>

<body>
  <div class="profile-container">
    <div class="user-info">
      <div class="profile-user-avatar-container">
        <img class="profile-user-avatar" src="../users/imgs/avatars/default_user_avatar.jpg" alt="user avatar">
        <img class="profile-user-avatar-background"
          src="../users/imgs/avatar_backgrounds/default-user-avatar-background.jpg" alt="">
      </div>
      <div class="profile-user-info">
        <p>Welcome back! Nguyen Hoang Nam</p>
        <table cellspacing="20">
          <tr>
            <th>Email:</th>
            <td>h7qFP@example.com</td>
          </tr>
          <tr>
            <th>Phone:</th>
            <td>0123456789</td>
          </tr>
          <tr>
            <th>Address:</th>
            <td>
              Hau Giang
            </td>
          </tr>
          <tr>
            <th>Role:</th>
            <td>Admin</td>
          </tr>
          <tr>
            <th>Web:</th>
            <td>
              <a href="http://localhost" target="_blank">http://localhost</a>
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
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="text" id="phone" name="phone">
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" id="address" name="address">
            </div>
            <div class="form-group">
            <label for="web">Web</label>
              <input type="text" name="web">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>





  <script>
    $(document).ready(() => {
      $(".loading-layer").addClass("loading-layer-hide");
    })
  </script>
</body>