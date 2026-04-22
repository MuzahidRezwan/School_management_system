<?php
class Teacher {
    public $id;
    public $name;
    public $email;
    public $subject;

    public function __construct($id, $name, $email, $subject) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
    }
}
?>