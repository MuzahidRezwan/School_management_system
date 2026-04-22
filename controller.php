<?php
require_once __DIR__ . '/model.php';

class Controller {
    private $model;

    public function __construct() {
        $this->model = new Model();
    }

    public function invoke() {
        $message = '';
        $action = $_GET['action'] ?? 'dashboard';
        $userType = $_GET['type'] ?? 'admin'; // admin, teacher, student
        $userId = $_GET['user_id'] ?? '';
        
        // Handle POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postAction = $_POST['action'] ?? '';
            
            // Admin Actions
            if ($postAction === 'add_student') {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $course_id = trim($_POST['course_id'] ?? '');
                
                if ($name && $email && $course_id) {
                    $newStudentId = $this->model->addStudent($name, $email, $course_id);
                    // Initialize attendance for the new student
                    $this->model->initializeStudentAttendance($newStudentId, $course_id);
                    header("Location: index.php?message=Student added successfully");
                    exit;
                }
            }
            
            if ($postAction === 'add_teacher') {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $subject = trim($_POST['subject'] ?? '');
                
                if ($name && $email && $subject) {
                    $this->model->addTeacher($name, $email, $subject);
                    header("Location: index.php?message=Teacher added successfully");
                    exit;
                }
            }
            
            if ($postAction === 'add_course') {
                $name = trim($_POST['name'] ?? '');
                $teacher_id = trim($_POST['teacher_id'] ?? '');
                $schedule = trim($_POST['schedule'] ?? '');
                
                if ($name && $teacher_id && $schedule) {
                    $this->model->addCourse($name, $teacher_id, $schedule);
                    header("Location: index.php?message=Course added successfully");
                    exit;
                }
            }
            
            // Teacher Actions
            if ($postAction === 'mark_attendance') {
                $student_id = $_POST['student_id'] ?? '';
                $course_id = $_POST['course_id'] ?? '';
                $date = $_POST['date'] ?? date('Y-m-d');
                $status = $_POST['status'] ?? '';
                $teacher_id = $_POST['teacher_id'] ?? '';
                
                if ($student_id && $course_id && $status && $teacher_id) {
                    $this->model->markAttendance($student_id, $course_id, $date, $status, $teacher_id);
                    header("Location: index.php?type=teacher&user_id=" . urlencode($teacher_id) . "&message=Attendance marked successfully");
                    exit;
                }
            }
            
            // Bulk Attendance Marking
            if ($postAction === 'mark_bulk_attendance') {
                $course_id = $_POST['course_id'] ?? '';
                $date = $_POST['date'] ?? date('Y-m-d');
                $teacher_id = $_POST['teacher_id'] ?? '';
                $attendance_data = $_POST['attendance'] ?? [];
                
                if ($course_id && $teacher_id && !empty($attendance_data)) {
                    foreach ($attendance_data as $student_id => $status) {
                        if ($status) {
                            $this->model->markAttendance($student_id, $course_id, $date, $status, $teacher_id);
                        }
                    }
                    header("Location: index.php?type=teacher&user_id=" . urlencode($teacher_id) . "&message=Bulk attendance marked successfully");
                    exit;
                }
            }
        }
        
        // Handle GET actions
        if ($action === 'delete_student' && isset($_GET['id'])) {
            $this->model->deleteStudent($_GET['id']);
            header("Location: index.php?message=Student deleted successfully");
            exit;
        }
        
        if ($action === 'delete_teacher' && isset($_GET['id'])) {
            $this->model->deleteTeacher($_GET['id']);
            header("Location: index.php?message=Teacher deleted successfully");
            exit;
        }
        
        if ($action === 'delete_course' && isset($_GET['id'])) {
            $this->model->deleteCourse($_GET['id']);
            header("Location: index.php?message=Course deleted successfully");
            exit;
        }
        
        // Handle student search (AJAX)
        if ($action === 'search_student') {
            $searchTerm = $_GET['search'] ?? '';
            $students = $this->model->getAllStudents();
            $filteredStudents = [];
            
            foreach ($students as $student) {
                if (stripos($student->name, $searchTerm) !== false || 
                    stripos($student->id, $searchTerm) !== false ||
                    stripos($student->email, $searchTerm) !== false) {
                    $filteredStudents[] = [
                        'id' => $student->id,
                        'name' => $student->name,
                        'email' => $student->email,
                        'course_id' => $student->course_id,
                        'enrollment_date' => $student->enrollment_date
                    ];
                }
            }
            
            header('Content-Type: application/json');
            echo json_encode($filteredStudents);
            exit;
        }
        
        // Handle attendance export for student
        if ($action === 'export' && $userType === 'student' && $userId) {
            $detailedAttendance = $this->model->getDetailedStudentAttendance($userId);
            $student = $this->model->getStudentById($userId);
            
            if ($student) {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="attendance_' . preg_replace('/[^a-zA-Z0-9]/', '_', $student->name) . '.csv"');
                
                $output = fopen('php://output', 'w');
                
                // Add UTF-8 BOM for Excel compatibility
                fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
                
                fputcsv($output, ['STUDENT ATTENDANCE REPORT']);
                fputcsv($output, ['Student Name:', $student->name]);
                fputcsv($output, ['Student ID:', $student->id]);
                fputcsv($output, ['Email:', $student->email]);
                fputcsv($output, ['Generated:', date('Y-m-d H:i:s')]);
                fputcsv($output, []);
                fputcsv($output, ['Date', 'Day', 'Course', 'Status', 'Teacher', 'Points', 'Remarks']);
                
                $totalPoints = 0;
                $totalClasses = 0;
                
                foreach ($detailedAttendance as $record) {
                    $att = $record['attendance'];
                    $points = 0;
                    $remarks = '';
                    
                    if ($att->status == 'Present') {
                        $points = 1;
                        $remarks = 'Full attendance';
                        $totalPoints += 1;
                        $totalClasses++;
                    } elseif ($att->status == 'Late') {
                        $points = 0.5;
                        $remarks = 'Partial attendance';
                        $totalPoints += 0.5;
                        $totalClasses++;
                    } elseif ($att->status == 'Absent') {
                        $points = 0;
                        $remarks = 'Absent';
                        $totalClasses++;
                    } else {
                        $points = '-';
                        $remarks = 'Not yet marked';
                    }
                    
                    $date = new DateTime($att->date);
                    $dayName = $date->format('l');
                    
                    fputcsv($output, [
                        $att->date,
                        $dayName,
                        $record['course_name'],
                        $att->status,
                        $record['teacher_name'],
                        $points,
                        $remarks
                    ]);
                }
                
                fputcsv($output, []);
                fputcsv($output, ['SUMMARY']);
                
                if ($totalClasses > 0) {
                    $percentage = round(($totalPoints / $totalClasses) * 100, 2);
                    fputcsv($output, ['Total Classes:', $totalClasses]);
                    fputcsv($output, ['Total Points:', $totalPoints]);
                    fputcsv($output, ['Attendance Percentage:', $percentage . '%']);
                    fputcsv($output, ['Status:', $percentage >= 75 ? 'Good Standing' : 'Below Threshold - Needs Improvement']);
                }
                
                fclose($output);
                exit;
            }
        }
        
        // Handle course attendance export for teacher
        if ($action === 'export_course' && $userType === 'teacher' && $userId && isset($_GET['course_id'])) {
            $course_id = $_GET['course_id'];
            $course = $this->model->getCourseById($course_id);
            $students = $this->model->getStudentsByCourse($course_id);
            
            if ($course) {
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="course_attendance_' . $course_id . '.csv"');
                
                $output = fopen('php://output', 'w');
                fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
                
                fputcsv($output, ['COURSE ATTENDANCE REPORT']);
                fputcsv($output, ['Course:', $course->name]);
                fputcsv($output, ['Course ID:', $course->id]);
                fputcsv($output, ['Teacher:', $this->model->getTeacherById($course->teacher_id)->name]);
                fputcsv($output, ['Generated:', date('Y-m-d H:i:s')]);
                fputcsv($output, []);
                fputcsv($output, ['Student ID', 'Student Name', 'Email', 'Attendance %', 'Status']);
                
                foreach ($students as $student) {
                    $percentage = $this->model->getStudentAttendancePercentage($student->id, $course_id);
                    $status = $percentage >= 75 ? 'Good Standing' : 'Below Threshold';
                    
                    fputcsv($output, [
                        $student->id,
                        $student->name,
                        $student->email,
                        $percentage . '%',
                        $status
                    ]);
                }
                
                fclose($output);
                exit;
            }
        }
        
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        }
        
        // Prepare data for view based on user type
        $data = [];
        
        if ($userType === 'admin') {
            $data['students'] = $this->model->getAllStudents();
            $data['teachers'] = $this->model->getAllTeachers();
            $data['courses'] = $this->model->getAllCourses();
            $data['attendance'] = $this->model->getAllAttendance();
            
            // Get students below threshold for each course
            $data['below_threshold'] = [];
            foreach ($data['courses'] as $course) {
                $data['below_threshold'][$course->id] = $this->model->getStudentsBelowThreshold($course->id);
            }
            
            // Calculate overall statistics
            $data['stats'] = [
                'total_students' => count($data['students']),
                'total_teachers' => count($data['teachers']),
                'total_courses' => count($data['courses']),
                'total_attendance_records' => count($data['attendance'])
            ];
        }
        
        if ($userType === 'teacher' && $userId) {
            $data['teacher'] = $this->model->getTeacherById($userId);
            $data['courses'] = array_filter($this->model->getAllCourses(), function($course) use ($userId) {
                return $course->teacher_id == $userId;
            });
            $data['students'] = $this->model->getAllStudents();
            $data['attendance'] = $this->model->getAllAttendance();
            
            // Get students below threshold for teacher's courses
            $data['below_threshold'] = [];
            foreach ($data['courses'] as $course) {
                $data['below_threshold'][$course->id] = $this->model->getStudentsBelowThreshold($course->id);
            }
            
            // Get detailed course information with student counts
            $data['course_details'] = [];
            foreach ($data['courses'] as $course) {
                $studentsInCourse = array_filter($data['students'], function($student) use ($course) {
                    return $student->course_id == $course->id;
                });
                
                $data['course_details'][$course->id] = [
                    'student_count' => count($studentsInCourse),
                    'below_threshold_count' => count($data['below_threshold'][$course->id] ?? [])
                ];
            }
        }
        
        if ($userType === 'student' && $userId) {
            $data['student'] = $this->model->getStudentById($userId);
            
            if ($data['student']) {
                $data['attendance_summary'] = $this->model->getStudentAttendanceByCourse($userId);
                $data['detailed_attendance'] = $this->model->getDetailedStudentAttendance($userId);
                $data['courses'] = $this->model->getAllCourses();
                
                // Calculate overall attendance percentage
                $totalPercentage = 0;
                $courseCount = 0;
                foreach ($data['attendance_summary'] as $summary) {
                    $totalPercentage += $summary['percentage'];
                    $courseCount++;
                }
                $data['overall_percentage'] = $courseCount > 0 ? round($totalPercentage / $courseCount, 2) : 0;
                
                // Get course details for enrolled courses
                $data['enrolled_courses'] = [];
                foreach ($data['courses'] as $course) {
                    if ($course->id == $data['student']->course_id) {
                        $data['enrolled_courses'][] = [
                            'course' => $course,
                            'teacher' => $this->model->getTeacherById($course->teacher_id),
                            'attendance_percentage' => $this->model->getStudentAttendancePercentage($userId, $course->id)
                        ];
                    }
                }
            } else {
                // Student not found, redirect to student selection
                $message = 'Student not found. Please select a valid student.';
                $userType = 'admin';
            }
        }
        
        // Pass message to view
        $data['message'] = $message;
        $data['userType'] = $userType;
        $data['userId'] = $userId;
        
        require __DIR__ . '/view.php';
    }
}
?>