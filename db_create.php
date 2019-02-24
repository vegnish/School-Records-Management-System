<?php
$servername = "localhost";
$username   = "root";
$password   = "";
// $database   = "school";

// Create connection
// PDO method
try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS school";
    $conn->exec($sql);
    $sql = "USE school";
    $conn->exec($sql);

    echo "Connection success";
    echo "<br>";

    $sql ="CREATE table users(
        id INT( 10 ) AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR( 30 ) NOT NULL, 
        Password VARCHAR( 256 ) NOT NULL,
        Role varchar(30) NOT NULL)" ;
    $conn->exec($sql);

    echo "users table created";
    echo "<br>";

    $sql ="CREATE table class(
        classID VARCHAR( 30 ) NOT NULL PRIMARY KEY,
        className VARCHAR( 30 ) NOT NULL, 
        yearForm VARCHAR( 30 ) NOT NULL,
        yearGrade VARCHAR( 30 ) NOT NULL)" ;
    $conn->exec($sql);

    echo "class table created";
    echo "<br>";

    $sql ="CREATE table student(
        studentID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        firstName VARCHAR( 50 ) NOT NULL, 
        lastName VARCHAR( 50 ) NOT NULL, 
        gender VARCHAR( 10 ) NOT NULL,
        classID VARCHAR( 30 ) NULL,
        FOREIGN KEY (`classID`) REFERENCES `class` (`classID`) ON UPDATE CASCADE ON DELETE SET NULL)" ;
    $conn->exec($sql);

    echo "student table created";
    echo "<br>";

    $sql = "ALTER TABLE student AUTO_INCREMENT=10001;";
    $conn->exec($sql);
    echo "initial studentID set to '10001' ";
    echo "<br>";

    $sql ="CREATE table subject(
        subjectID VARCHAR( 30 ) NOT NULL PRIMARY KEY,
        subjectName VARCHAR( 30 ) NOT NULL, 
        subjectType VARCHAR( 30 ) NOT NULL)" ;
    $conn->exec($sql);

    echo "subject table created";
    echo "<br>";

    $sql ="CREATE table student_subject(
        studentID INT NOT NULL,
        subjectID VARCHAR( 30 ) NOT NULL,
        subject_score INT NULL,
        FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`) ON UPDATE CASCADE ON DELETE CASCADE)" ;
    $conn->exec($sql);

    echo "student_subject table created";
    echo "<br>";

    $sql = "INSERT INTO subject  VALUES
            ('BM0001', 'BM', 'Core'),
            ('EN1266', 'English', 'Core'),
            ('MA1408', 'Mathematic', 'Core'),
            ('SC2119', 'Science', 'Core'),
            ('GE4183', 'Geography ', 'Core'),
            ('BI0002', 'Biology', 'Selective'),
            ('CH2135', 'Chemistry', 'Selective');";
    $conn->exec($sql);

    echo "subjects inserted";
    echo "<br>";


} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
