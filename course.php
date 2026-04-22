<?php
class Course {
    public $id;
    public $name;
    public $teacher_id;
    public $schedule;

    public function __construct($id, $name, $teacher_id, $schedule) {
        $this->id = $id;
        $this->name = $name;
        $this->teacher_id = $teacher_id;
        $this->schedule = $schedule;
    }
}
?>