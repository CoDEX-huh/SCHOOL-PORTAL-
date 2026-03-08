<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$role = $_SESSION['role'] ?? '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>School Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">School Portal</a>
    <div class="navbar-nav">
      <?php if($role==='Admin'): ?>
        <a class="nav-link" href="admin_users.php">Users</a>
        <a class="nav-link" href="admin_courses.php">Courses</a>
        <a class="nav-link" href="admin_subjects.php">Subjects</a>
      <?php endif; ?>
      <?php if($role==='Professor'): ?>
        <a class="nav-link" href="professor_exams.php">Exams</a>
        <a class="nav-link" href="professor_grades.php">Grades</a>
      <?php endif; ?>
      <?php if($role==='Student'): ?>
        <a class="nav-link" href="student_enrollment.php">Enrollment</a>
        <a class="nav-link" href="student_grades.php">My Grades</a>
      <?php endif; ?>
      <a class="nav-link" href="lost_found.php">Lost & Found</a>
      <a class="nav-link" href="claims.php">Claims</a>
      <a class="nav-link" href="announcements.php">Announcements</a>
      <?php if(isset($_SESSION['token'])): ?><a class="nav-link" href="logout.php">Logout</a><?php endif; ?>
    </div>
  </div>
</nav>
<div class="container">
