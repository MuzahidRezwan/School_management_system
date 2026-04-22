<?php
class Student {
    public $id;
    public $name;
    public $email;
    public $course_id;
    public $enrollment_date;

    public function __construct($id, $name, $email, $course_id, $enrollment_date) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->course_id = $course_id;
        $this->enrollment_date = $enrollment_date;
    }
}
?>