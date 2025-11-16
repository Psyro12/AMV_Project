<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: content-type");

include "db.php";

$method = $_SERVER['REQUEST_METHOD'];
$path = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
$courseId = $path[2] ?? null; // /course_service/courses/1

if ($path[1] !== "courses") {
    echo json_encode(["error" => "Invalid endpoint"]);
    exit;
}

switch ($method) {

    case "GET":
        if ($courseId) {
            $result = $conn->query("SELECT * FROM courses WHERE course_id = $courseId");
            echo json_encode($result->fetch_assoc());
        } else {
            $result = $conn->query("SELECT * FROM courses");
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        }
        break;

    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $desc = $data['description'];
        $teacher = $data['teacher_id'];

        $sql = "INSERT INTO courses (name, description, teacher_id) VALUES ('$name', '$desc', $teacher)";
        $conn->query($sql);

        echo json_encode(["message" => "Course created"]);
        break;

    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $units = $data['units'];

        $sql = "UPDATE courses SET name='$name', units=$units WHERE course_id = $courseId";
        $conn->query($sql);

        echo json_encode(["message" => "Course updated"]);
        break;

    case "DELETE":
        $conn->query("DELETE FROM courses WHERE course_id = $courseId");
        echo json_encode(["message" => "Course deleted"]);
        break;

    default:
        echo json_encode(["error" => "Invalid method"]);
}
?>
