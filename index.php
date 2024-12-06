<!DOCTYPE html>
<html>
<head>
  <style>
    p {
      color: red;
      font-size: 12px;
    }
    table {
      width: 50%;
      margin: auto;
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 10px;
    }
    td {
      padding: 10px;
    }
    input, select {
      width: 100%;
      padding: 8px;
    }
    .submit-btn {
      width: 100%;
      padding: 10px;
      background: linear-gradient(to right, #FF66B2, #FF3385, #FF6699, #FF99CC); /* Pink gradient */
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .submit-btn:hover {
      background: linear-gradient(to right, #FF3385, #FF66B2, #FF99CC, #FF6699); /* Reverse gradient for hover effect */
    }
    .gender-options {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .gender-options label {
      margin: 0;
    }
  </style>
  <script>
    function validateForm() {
      let isValid = true;

      const name = document.getElementById('name').value;
      const age = document.getElementById('age').value;
      const gender = document.querySelector('input[name="gender"]:checked');
      const sport = document.getElementById('sport').value;
      const file = document.getElementById('profile_pic').files[0];

      if (name === "" || !/^[a-zA-Z\s]+$/.test(name)) {
        document.getElementById('name_error').innerText = "Please enter a valid name.";
        isValid = false;
      } else {
        document.getElementById('name_error').innerText = "";
      }

      if (age === "" || isNaN(age) || age < 5 || age > 100) {
        document.getElementById('age_error').innerText = "Please enter a valid age (5-100).";
        isValid = false;
      } else {
        document.getElementById('age_error').innerText = "";
      }

      if (!gender) {
        document.getElementById('gender_error').innerText = "Please select your gender.";
        isValid = false;
      } else {
        document.getElementById('gender_error').innerText = "";
      }

      if (sport === "-1") {
        document.getElementById('sport_error').innerText = "Please select a sport.";
        isValid = false;
      } else {
        document.getElementById('sport_error').innerText = "";
      }

      if (!file) {
        document.getElementById('file_error').innerText = "Please upload your profile picture.";
        isValid = false;
      } else if (file.size > 2097152) {
        document.getElementById('file_error').innerText = "File size must be less than 2MB.";
        isValid = false;
      } else {
        document.getElementById('file_error').innerText = "";
      }

      return isValid;
    }
  </script>
</head>
<body>
  <h1 style="text-align: center;">Sports Form</h1>
  <form method="POST" action="" onsubmit="return validateForm()" enctype="multipart/form-data">
    <table>
      <tr>
        <td>Name:</td>
        <td><input type="text" id="name" name="name"></td>
        <td><p id="name_error"></p></td>
      </tr>
      <tr>
        <td>Age:</td>
        <td><input type="number" id="age" name="age"></td>
        <td><p id="age_error"></p></td>
      </tr>
      <tr>
        <td>Gender:</td>
        <td>
          <div class="gender-options">
            <input type="radio" id="male" name="gender" value="Male">
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="Female">
            <label for="female">Female</label>
          </div>
        </td>
        <td><p id="gender_error"></p></td>
      </tr>
      <tr>
        <td>Sport:</td>
        <td>
          <select id="sport" name="sport">
            <option value="-1">Select Sport</option>
            <option value="Football">Football</option>
            <option value="Cricket">Cricket</option>
            <option value="Basketball">Basketball</option>
            <option value="Badminton">Badminton</option>
          </select>
        </td>
        <td><p id="sport_error"></p></td>
      </tr>
      <tr>
        <td>Profile Picture:</td>
        <td><input type="file" id="profile_pic" name="profile_pic"></td>
        <td><p id="file_error"></p></td>
      </tr>
      <tr>
        <td colspan="3"><input type="submit" value="Register" class="submit-btn"></td>
      </tr>
    </table>
  </form>
</body>
</html>




  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $sport = $_POST['sport'];
    $file = "asha";

    // File upload
    if (is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
      $file = "uploads/" . basename($_FILES['profile_pic']['name']);
      move_uploaded_file($_FILES['profile_pic']['tmp_name'], $file);
    }

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "asha");
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO registrations (name, age, gender, sport, profile_pic) 
            VALUES ('$name', '$age', '$gender', '$sport', '$file')";
    if (mysqli_query($conn, $sql)) {
      echo "<p style='text-align:center;color:green;'>Registration successful!</p>";
    } else {
      echo "<p style='text-align:center;color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }

    mysqli_close($conn);
  }
  ?>
</body>
</html>
