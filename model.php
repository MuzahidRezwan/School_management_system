<?php
require_once __DIR__ . '/student.php';
require_once __DIR__ . '/teacher.php';
require_once __DIR__ . '/course.php';
require_once __DIR__ . '/attendance.php';

class Model {
    private $studentsFile;
    private $teachersFile;
    private $coursesFile;
    private $attendanceFile;

    public function __construct() {
        $this->studentsFile = __DIR__ . '/students.json';
        $this->teachersFile = __DIR__ . '/teachers.json';
        $this->coursesFile = __DIR__ . '/courses.json';
        $this->attendanceFile = __DIR__ . '/attendance.json';

        // Initialize files if they don't exist
        if (!file_exists($this->studentsFile)) {
            file_put_contents($this->studentsFile, json_encode([], JSON_PRETTY_PRINT));
        }
        if (!file_exists($this->teachersFile)) {
            file_put_contents($this->teachersFile, json_encode([], JSON_PRETTY_PRINT));
        }
        if (!file_exists($this->coursesFile)) {
            file_put_contents($this->coursesFile, json_encode([], JSON_PRETTY_PRINT));
        }
        if (!file_exists($this->attendanceFile)) {
            file_put_contents($this->attendanceFile, json_encode([], JSON_PRETTY_PRINT));
        }
    } // Constructor ends here

    // Student Operations
    public function getAllStudents() {
        $jsonData = file_get_contents($this->studentsFile);
        $data = json_decode($jsonData, true);
        
        if (!is_array($data)) {
            $data = [];
        }
        
        $students = [];
        foreach ($data as $studentData) {
            $students[] = new Student(
                $studentData['id'],
                $studentData['name'],
                $studentData['email'],
                $studentData['course_id'],
                $studentData['enrollment_date']
            );
        }
        return $students;
    }

    public function getStudentById($id) {
        $students = $this->getAllStudents();
        foreach ($students as $student) {
            if ($student->id == $id) {
                return $student;
            }
        }
        return null;
    }

    public function addStudent($name, $email, $course_id) {
        $students = $this->getAllStudents();
        
        $newId = 101;
        if (!empty($students)) {
            $lastStudent = end($students);
            $newId = intval($lastStudent->id) + 1;
        }
        
        $studentId = strval($newId);
        
        $students[] = new Student(
            $studentId,
            $name,
            $email,
            $course_id,
            date('Y-m-d')
        );
        
        $this->saveStudents($students);
        
        // Initialize attendance records for this student
        $this->initializeStudentAttendance($studentId, $course_id);
        
        return $studentId;
    }

    public function updateStudent($id, $name, $email, $course_id) {
        $students = $this->getAllStudents();
        foreach ($students as $student) {
            if ($student->id == $id) {
                $student->name = $name;
                $student->email = $email;
                $student->course_id = $course_id;
                break;
            }
        }
        $this->saveStudents($students);
    }

    public function deleteStudent($id) {
        $students = $this->getAllStudents();
        $updatedStudents = [];
        foreach ($students as $student) {
            if ($student->id != $id) {
                $updatedStudents[] = $student;
            }
        }
        $this->saveStudents($updatedStudents);
    }

    private function saveStudents($students) {
        $data = [];
        foreach ($students as $student) {
            $data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'course_id' => $student->course_id,
                'enrollment_date' => $student->enrollment_date
            ];
        }
        file_put_contents($this->studentsFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    // Teacher Operations
    public function getAllTeachers() {
        $jsonData = file_get_contents($this->teachersFile);
        $data = json_decode($jsonData, true);
        
        if (!is_array($data)) {
            $data = [];
        }
        
        $teachers = [];
        foreach ($data as $teacherData) {
            $teachers[] = new Teacher(
                $teacherData['id'],
                $teacherData['name'],
                $teacherData['email'],
                $teacherData['subject']
            );
        }
        return $teachers;
    }

    public function getTeacherById($id) {
        $teachers = $this->getAllTeachers();
        foreach ($teachers as $teacher) {
            if ($teacher->id == $id) {
                return $teacher;
            }
        }
        return null;
    }

    public function addTeacher($name, $email, $subject) {
        $teachers = $this->getAllTeachers();
        
        $newId = 1;
        if (!empty($teachers)) {
            $lastTeacher = end($teachers);
            $newId = intval(substr($lastTeacher->id, 1)) + 1;
        }
        
        $teachers[] = new Teacher(
            'T' . str_pad($newId, 3, '0', STR_PAD_LEFT),
            $name,
            $email,
            $subject
        );
        
        $this->saveTeachers($teachers);
    }

    public function deleteTeacher($id) {
        $teachers = $this->getAllTeachers();
        $updatedTeachers = [];
        foreach ($teachers as $teacher) {
            if ($teacher->id != $id) {
                $updatedTeachers[] = $teacher;
            }
        }
        $this->saveTeachers($updatedTeachers);
    }

    private function saveTeachers($teachers) {
        $data = [];
        foreach ($teachers as $teacher) {
            $data[] = [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'email' => $teacher->email,
                'subject' => $teacher->subject
            ];
        }
        file_put_contents($this->teachersFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    // Course Operations
    public function getAllCourses() {
        $jsonData = file_get_contents($this->coursesFile);
        $data = json_decode($jsonData, true);
        
        if (!is_array($data)) {
            $data = [];
        }
        
        $courses = [];
        foreach ($data as $courseData) {
            $courses[] = new Course(
                $courseData['id'],
                $courseData['name'],
                $courseData['teacher_id'],
                $courseData['schedule']
            );
        }
        return $courses;
    }

    public function getCourseById($id) {
        $courses = $this->getAllCourses();
        foreach ($courses as $course) {
            if ($course->id == $id) {
                return $course;
            }
        }
        return null;
    }

    public function addCourse($name, $teacher_id, $schedule) {
        $courses = $this->getAllCourses();
        
        $newId = 1;
        if (!empty($courses)) {
            $lastCourse = end($courses);
            $newId = intval(substr($lastCourse->id, 1)) + 1;
        }
        
        $courses[] = new Course(
            'C' . str_pad($newId, 3, '0', STR_PAD_LEFT),
            $name,
            $teacher_id,
            $schedule
        );
        
        $this->saveCourses($courses);
    }

    public function deleteCourse($id) {
        $courses = $this->getAllCourses();
        $updatedCourses = [];
        foreach ($courses as $course) {
            if ($course->id != $id) {
                $updatedCourses[] = $course;
            }
        }
        $this->saveCourses($updatedCourses);
    }

    private function saveCourses($courses) {
        $data = [];
        foreach ($courses as $course) {
            $data[] = [
                'id' => $course->id,
                'name' => $course->name,
                'teacher_id' => $course->teacher_id,
                'schedule' => $course->schedule
            ];
        }
        file_put_contents($this->coursesFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function getStudentsByCourse($course_id) {
        $students = $this->getAllStudents();
        $courseStudents = [];
        foreach ($students as $student) {
            if ($student->course_id == $course_id) {
                $courseStudents[] = $student;
            }
        }
        return $courseStudents;
    }

    // Attendance Operations
    public function getAllAttendance() {
        $jsonData = file_get_contents($this->attendanceFile);
        $data = json_decode($jsonData, true);
        
        if (!is_array($data)) {
            $data = [];
        }
        
        $attendance = [];
        foreach ($data as $attData) {
            $attendance[] = new Attendance(
                $attData['id'],
                $attData['student_id'],
                $attData['course_id'],
                $attData['date'],
                $attData['status'],
                $attData['teacher_id']
            );
        }
        return $attendance;
    }

    public function markAttendance($student_id, $course_id, $date, $status, $teacher_id) {
        $attendance = $this->getAllAttendance();
        
        // Check if attendance already marked for this student on this date for this course
        foreach ($attendance as $att) {
            if ($att->student_id == $student_id && 
                $att->course_id == $course_id && 
                $att->date == $date) {
                // Update existing attendance
                $att->status = $status;
                $att->teacher_id = $teacher_id;
                $this->saveAttendance($attendance);
                return;
            }
        }
        
        $newId = 1;
        if (!empty($attendance)) {
            $lastAtt = end($attendance);
            $newId = intval(substr($lastAtt->id, 1)) + 1;
        }
        
        $attendance[] = new Attendance(
            'A' . str_pad($newId, 3, '0', STR_PAD_LEFT),
            $student_id,
            $course_id,
            $date,
            $status,
            $teacher_id
        );
        
        $this->saveAttendance($attendance);
    }

    private function saveAttendance($attendance) {
        $data = [];
        foreach ($attendance as $att) {
            $data[] = [
                'id' => $att->id,
                'student_id' => $att->student_id,
                'course_id' => $att->course_id,
                'date' => $att->date,
                'status' => $att->status,
                'teacher_id' => $att->teacher_id
            ];
        }
        file_put_contents($this->attendanceFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    // Initialize attendance for new student
    public function initializeStudentAttendance($student_id, $course_id) {
        $attendance = $this->getAllAttendance();
        
        // Check if student already has any attendance records
        $hasRecords = false;
        foreach ($attendance as $att) {
            if ($att->student_id == $student_id && $att->course_id == $course_id) {
                $hasRecords = true;
                break;
            }
        }
        
        // If no records exist, create an initial record for today
        if (!$hasRecords) {
            $newId = 1;
            if (!empty($attendance)) {
                $lastAtt = end($attendance);
                $newId = intval(substr($lastAtt->id, 1)) + 1;
            }
            
            $attendance[] = new Attendance(
                'A' . str_pad($newId, 3, '0', STR_PAD_LEFT),
                $student_id,
                $course_id,
                date('Y-m-d'),
                'Not Marked',
                'SYSTEM'
            );
            
            $this->saveAttendance($attendance);
        }
    }

    // Get detailed student attendance
    public function getDetailedStudentAttendance($student_id) {
        $attendance = $this->getAllAttendance();
        $courses = $this->getAllCourses();
        $teachers = $this->getAllTeachers();
        
        $detailedAttendance = [];
        
        foreach ($attendance as $att) {
            if ($att->student_id == $student_id) {
                $courseName = 'Unknown Course';
                $teacherName = 'Unknown Teacher';
                
                foreach ($courses as $course) {
                    if ($course->id == $att->course_id) {
                        $courseName = $course->name;
                        
                        foreach ($teachers as $teacher) {
                            if ($teacher->id == $course->teacher_id) {
                                $teacherName = $teacher->name;
                                break;
                            }
                        }
                        break;
                    }
                }
                
                $detailedAttendance[] = [
                    'attendance' => $att,
                    'course_name' => $courseName,
                    'teacher_name' => $teacherName
                ];
            }
        }
        
        // Sort by date (newest first)
        usort($detailedAttendance, function($a, $b) {
            return strtotime($b['attendance']->date) - strtotime($a['attendance']->date);
        });
        
        return $detailedAttendance;
    }

    // Get course dates
    public function getCourseDates($course_id) {
        $attendance = $this->getAllAttendance();
        $dates = [];
        
        foreach ($attendance as $att) {
            if ($att->course_id == $course_id) {
                $dates[$att->date] = true;
            }
        }
        
        $uniqueDates = array_keys($dates);
        sort($uniqueDates);
        return $uniqueDates;
    }

    // Attendance Statistics
    public function getStudentAttendancePercentage($student_id, $course_id) {
        $attendance = $this->getAllAttendance();
        $courseAttendance = array_filter($attendance, function($att) use ($student_id, $course_id) {
            return $att->student_id == $student_id && $att->course_id == $course_id;
        });
        
        $totalClasses = count($courseAttendance);
        if ($totalClasses == 0) return 0;
        
        $presentCount = 0;
        foreach ($courseAttendance as $att) {
            if ($att->status == 'Present') {
                $presentCount++;
            }
            if ($att->status == 'Late') {
                $presentCount += 0.5; // Count Late as half present
            }
        }
        
        return round(($presentCount / $totalClasses) * 100, 2);
    }

    public function getStudentAttendanceByCourse($student_id) {
        $courses = $this->getAllCourses();
        $attendanceSummary = [];
        
        foreach ($courses as $course) {
            $percentage = $this->getStudentAttendancePercentage($student_id, $course->id);
            $attendanceSummary[] = [
                'course' => $course,
                'percentage' => $percentage,
                'below_threshold' => $percentage < 75
            ];
        }
        
        return $attendanceSummary;
    }

    public function getStudentsBelowThreshold($course_id, $threshold = 75) {
        $students = $this->getAllStudents();
        $belowThreshold = [];
        
        foreach ($students as $student) {
            if ($student->course_id == $course_id) {
                $percentage = $this->getStudentAttendancePercentage($student->id, $course_id);
                if ($percentage < $threshold) {
                    $belowThreshold[] = [
                        'student' => $student,
                        'percentage' => $percentage
                    ];
                }
            }
        }
        
        return $belowThreshold;
    }
}
?>