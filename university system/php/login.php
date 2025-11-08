<?php
session_start();

// بيانات المستخدمين (مؤقتة)
$users = [
    'admin@edu.com' => ['password' => '123456', 'role' => 'admin', 'name' => 'المدير'],
    'instructor@edu.com' => ['password' => '123456', 'role' => 'instructor', 'name' => 'المحاضر'],
    'student@edu.com' => ['password' => '123456', 'role' => 'student', 'name' => 'الطالب'],
    'coordinator@edu.com' => ['password' => '123456', 'role' => 'coordinator', 'name' => 'المنسق']
];

if($_POST['action'] == 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if(isset($users[$email]) && $users[$email]['password'] == $password) {
        $_SESSION['user'] = [
            'email' => $email,
            'role' => $users[$email]['role'],
            'name' => $users[$email]['name']
        ];
        echo json_encode(['success' => true, 'role' => $users[$email]['role']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'بيانات الدخول خاطئة']);
    }
}
?>