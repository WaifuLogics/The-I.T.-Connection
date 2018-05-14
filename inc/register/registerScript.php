<?php
  $username = $_POST['register-username'];
  $email = $_POST['register-email'];
  $passowrd = password_hash($_POST['register_password'], PASSWORD_BCRYPT);
