<?php
// upload.php
session_start();

// تأكد أن المستخدم محاضر
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'instructor') {
    echo json_encode(['success' => false, 'message' => '❌ غير مسموح للوصول']);
    exit;
}

// بيانات المواد (مؤقتة)
$courses = [
    'CS101' => 'تطوير الويب',
    'CS102' => 'قواعد البيانات', 
    'MATH101' => 'الرياضيات'
];

if ($_POST['action'] == 'upload_file') {
    $courseCode = $_POST['course_code'];
    $fileName = $_POST['file_name'];
    $fileType = $_POST['file_type'];
    
    // تحقق من البيانات
    if (empty($courseCode) || empty($fileName)) {
        echo json_encode(['success' => false, 'message' => '❌ جميع الحقول مطلوبة']);
        exit;
    }
    
    if (!isset($courses[$courseCode])) {
        echo json_encode(['success' => false, 'message' => '❌ المادة غير موجودة']);
        exit;
    }
    
    // محاكاة حفظ الملف (في الواقع بتكون $_FILES)
    $uploadData = [
        'id' => uniqid(),
        'course_code' => $courseCode,
        'course_name' => $courses[$courseCode],
        'file_name' => $fileName,
        'file_type' => $fileType,
        'instructor' => $_SESSION['user']['name'],
        'upload_date' => date('Y-m-d H:i:s'),
        'size' => '2.4 MB' // محاكاة
    ];
    
    // هنا بتكون عملية رفع الملف الحقيقية
    // move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $fileName);
    
    echo json_encode([
        'success' => true, 
        'message' => '✅ تم رفع الملف بنجاح',
        'file' => $uploadData
    ]);
    exit;
}

// جلب الملفات للمادة
if ($_POST['action'] == 'get_files') {
    $courseCode = $_POST['course_code'];
    
    // ملفات وهمية (في الواقع بتكون من قاعدة بيانات)
    $sampleFiles = [
        [
            'id' => '1',
            'name' => 'محاضرة HTML.pdf',
            'type' => 'pdf',
            'size' => '2.1 MB',
            'date' => '2023-11-15'
        ],
        [
            'id' => '2', 
            'name' => 'فيديو CSS.mp4',
            'type' => 'video',
            'size' => '45.2 MB',
            'date' => '2023-11-14'
        ]
    ];
    
    echo json_encode([
        'success' => true,
        'files' => $sampleFiles
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Action not found']);
?>