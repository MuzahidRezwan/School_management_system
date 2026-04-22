<?php
class Attendance {
    public $id;
    public $student_id;
    public $course_id;
    public $date;
    public $status;
    public $teacher_id;

    public function __construct($id, $student_id, $course_id, $date, $status, $teacher_id) {
        $this->id = $id;
        $this->student_id = $student_id;
        $this->course_id = $course_id;
        $this->date = $date;
        $this->status = $status;
        $this->teacher_id = $teacher_id;
    }
}
?>