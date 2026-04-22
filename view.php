<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .nav {
            background: #f8f9fa;
            padding: 15px 30px;
            border-bottom: 2px solid #e0e0e0;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .nav a {
            padding: 10px 20px;
            background: white;
            border: 2px solid #667eea;
            color: #667eea;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .nav a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .content {
            padding: 30px;
        }
        
        .message {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 5px solid #28a745;
            animation: slideIn 0.5s ease;
        }
        
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .section {
            margin-bottom: 40px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        /* Add this to the existing style section in view.php */

.nav {
    position: relative;
    z-index: 100;
}

[id$="Dropdown"] {
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

[id$="Dropdown"] a {
    transition: all 0.2s;
}

[id$="Dropdown"] a:hover {
    background: #667eea !important;
    color: white !important;
    transform: translateX(5px);
}

.student-link {
    transition: all 0.2s;
    border-left: 3px solid transparent;
}

.student-link:hover {
    border-left-color: #667eea;
    padding-left: 12px !important;
}

#studentSearch {
    transition: all 0.3s;
}

#studentSearch:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Export button hover effect */
a[href*="action=export"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
}

/* Responsive design for mobile */
@media (max-width: 768px) {
    .nav {
        flex-direction: column;
    }
    
    [id$="Dropdown"] {
        position: static !important;
        width: 100%;
        margin-top: 10px;
    }
    
    .stats-card {
        width: 100%;
    }
}
        .section h2 {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
            display: inline-block;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #f56565 0%, #c53030 100%);
            box-shadow: 0 4px 15px rgba(245, 101, 101, 0.4);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        table th,
        table td {
            padding: 15px;
            text-align: left;
        }
        
        table tbody tr {
            border-bottom: 1px solid #e0e0e0;
            transition: background 0.3s;
        }
        
        table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .warning {
            background: #fff3cd !important;
            color: #856404;
            font-weight: 600;
        }
        
        .danger {
            background: #f8d7da !important;
            color: #721c24;
            font-weight: 600;
        }
        
        .success {
            background: #d4edda !important;
            color: #155724;
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-present {
            background: #28a745;
            color: white;
        }
        
        .badge-absent {
            background: #dc3545;
            color: white;
        }
        
        .badge-late {
            background: #ffc107;
            color: #333;
        }
        
        .stats-card {
            display: inline-block;
            padding: 20px;
            margin: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            min-width: 200px;
            text-align: center;
        }
        
        .stats-card h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .stats-card .percentage {
            font-size: 3em;
            font-weight: bold;
            color: #333;
        }
        
        .attendance-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .action-links .view {
            color: #667eea;
        }
        
        .action-links .delete {
            color: #dc3545;
        }
        
        .action-links a:hover {
            background: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Student Attendance Management System</h1>
            <p>Track, Manage, and Analyze Student Attendance</p>
        </div>
        
<div class="nav">
    <a href="index.php?type=admin">🏠 Admin Dashboard</a>
    
    <!-- Teacher Dropdown -->
    <div style="position: relative; display: inline-block;">
        <a href="#" onclick="toggleDropdown('teacherDropdown')" style="display: inline-block;">👨‍🏫 Teacher Login ▼</a>
        <div id="teacherDropdown" style="display: none; position: absolute; background: white; border: 2px solid #667eea; border-radius: 10px; padding: 15px; min-width: 250px; z-index: 1000; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
            <h4 style="margin-bottom: 10px; color: #667eea;">Select Teacher</h4>
            <?php 
            $allTeachers = $this->model->getAllTeachers();
            foreach ($allTeachers as $teacher): 
            ?>
                <a href="index.php?type=teacher&user_id=<?php echo urlencode($teacher->id); ?>" 
                   style="display: block; padding: 8px; margin: 5px 0; background: #f8f9fa; border-radius: 5px; color: #333; text-decoration: none;">
                    <?php echo htmlspecialchars($teacher->name); ?> (<?php echo htmlspecialchars($teacher->subject); ?>)
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Student Dropdown -->
    <div style="position: relative; display: inline-block;">
        <a href="#" onclick="toggleDropdown('studentDropdown')" style="display: inline-block;">👨‍🎓 Student Login ▼</a>
        <div id="studentDropdown" style="display: none; position: absolute; background: white; border: 2px solid #667eea; border-radius: 10px; padding: 15px; min-width: 250px; max-height: 400px; overflow-y: auto; z-index: 1000; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
            <h4 style="margin-bottom: 10px; color: #667eea;">Select Student</h4>
            <input type="text" id="studentSearch" placeholder="🔍 Search student..." 
                   style="width: 100%; padding: 8px; margin-bottom: 10px; border: 2px solid #e0e0e0; border-radius: 5px;"
                   onkeyup="filterStudents()">
            <div id="studentList">
                <?php 
                $allStudents = $this->model->getAllStudents();
                foreach ($allStudents as $student): 
                ?>
                    <a href="index.php?type=student&user_id=<?php echo urlencode($student->id); ?>" 
                       class="student-link"
                       style="display: block; padding: 8px; margin: 5px 0; background: #f8f9fa; border-radius: 5px; color: #333; text-decoration: none;">
                        <?php echo htmlspecialchars($student->name); ?> (ID: <?php echo htmlspecialchars($student->id); ?>)
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
function toggleDropdown(id) {
    var dropdown = document.getElementById(id);
    var allDropdowns = document.querySelectorAll('[id$="Dropdown"]');
    
    allDropdowns.forEach(function(d) {
        if (d.id !== id) {
            d.style.display = 'none';
        }
    });
    
    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'block';
    } else {
        dropdown.style.display = 'none';
    }
}

function filterStudents() {
    var input = document.getElementById('studentSearch');
    var filter = input.value.toUpperCase();
    var studentList = document.getElementById('studentList');
    var links = studentList.getElementsByClassName('student-link');
    
    for (var i = 0; i < links.length; i++) {
        var text = links[i].textContent || links[i].innerText;
        if (text.toUpperCase().indexOf(filter) > -1) {
            links[i].style.display = '';
        } else {
            links[i].style.display = 'none';
        }
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.matches('[onclick*="toggleDropdown"]')) {
        var dropdowns = document.querySelectorAll('[id$="Dropdown"]');
        dropdowns.forEach(function(dropdown) {
            dropdown.style.display = 'none';
        });
    }
});
</script>
        
        <div class="content">
            <?php if (!empty($message)): ?>
                <div class="message">
                    ✅ <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($userType === 'admin'): ?>
                <!-- Admin Dashboard -->
                <div class="section">
                    <h2>➕ Add New Student</h2>
                    <form method="POST" class="form-grid">
                        <input type="hidden" name="action" value="add_student">
                        <div class="form-group">
                            <label>Student Name:</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Course:</label>
                            <select name="course_id" required>
                                <option value="">Select Course</option>
                                <?php foreach ($data['courses'] as $course): ?>
                                    <option value="<?php echo htmlspecialchars($course->id); ?>">
                                        <?php echo htmlspecialchars($course->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Add Student</button>
                        </div>
                    </form>
                </div>
                
                <div class="section">
                    <h2>👨‍🏫 Add New Teacher</h2>
                    <form method="POST" class="form-grid">
                        <input type="hidden" name="action" value="add_teacher">
                        <div class="form-group">
                            <label>Teacher Name:</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Subject:</label>
                            <input type="text" name="subject" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Add Teacher</button>
                        </div>
                    </form>
                </div>
                
                <div class="section">
                    <h2>📖 Add New Course</h2>
                    <form method="POST" class="form-grid">
                        <input type="hidden" name="action" value="add_course">
                        <div class="form-group">
                            <label>Course Name:</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Teacher:</label>
                            <select name="teacher_id" required>
                                <option value="">Select Teacher</option>
                                <?php foreach ($data['teachers'] as $teacher): ?>
                                    <option value="<?php echo htmlspecialchars($teacher->id); ?>">
                                        <?php echo htmlspecialchars($teacher->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Schedule:</label>
                            <input type="text" name="schedule" placeholder="e.g., Mon/Wed 10:00 AM" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Add Course</button>
                        </div>
                    </form>
                </div>
                
                <div class="section">
                    <h2>👨‍🎓 Students List</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Enrollment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['students'] as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student->id); ?></td>
                                    <td><?php echo htmlspecialchars($student->name); ?></td>
                                    <td><?php echo htmlspecialchars($student->email); ?></td>
                                    <td><?php echo htmlspecialchars($student->course_id); ?></td>
                                    <td><?php echo htmlspecialchars($student->enrollment_date); ?></td>
                                    <td class="action-links">
                                        <a href="index.php?action=delete_student&id=<?php echo urlencode($student->id); ?>" 
                                           class="delete" onclick="return confirm('Delete this student?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="section">
                    <h2>⚠️ Students Below 75% Attendance</h2>
                    <?php foreach ($data['courses'] as $course): ?>
                        <?php if (!empty($data['below_threshold'][$course->id])): ?>
                            <h3><?php echo htmlspecialchars($course->name); ?></h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Attendance %</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['below_threshold'][$course->id] as $item): ?>
                                        <tr class="danger">
                                            <td><?php echo htmlspecialchars($item['student']->id); ?></td>
                                            <td><?php echo htmlspecialchars($item['student']->name); ?></td>
                                            <td><?php echo $item['percentage']; ?>%</td>
                                            <td><span class="badge badge-absent">Below Threshold</span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                
            <?php elseif ($userType === 'teacher' && isset($data['teacher'])): ?>
                <!-- Teacher Dashboard -->
                <div class="section">
                    <h2>👨‍🏫 Welcome, <?php echo htmlspecialchars($data['teacher']->name); ?></h2>
                    <p>Subject: <?php echo htmlspecialchars($data['teacher']->subject); ?></p>
                </div>
                
                <div class="section">
                    <h2>📝 Mark Attendance</h2>
                    <div class="attendance-form">
                        <form method="POST" class="form-grid">
                            <input type="hidden" name="action" value="mark_attendance">
                            <input type="hidden" name="teacher_id" value="<?php echo htmlspecialchars($userId); ?>">
                            
                            <div class="form-group">
                                <label>Select Course:</label>
                                <select name="course_id" id="courseSelect" required>
                                    <option value="">Select Course</option>
                                    <?php foreach ($data['courses'] as $course): ?>
                                        <option value="<?php echo htmlspecialchars($course->id); ?>">
                                            <?php echo htmlspecialchars($course->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Select Student:</label>
                                <select name="student_id" required>
                                    <option value="">Select Student</option>
                                    <?php foreach ($data['students'] as $student): ?>
                                        <option value="<?php echo htmlspecialchars($student->id); ?>">
                                            <?php echo htmlspecialchars($student->name); ?> (ID: <?php echo htmlspecialchars($student->id); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Date:</label>
                                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="status" required>
                                    <option value="Present">✅ Present</option>
                                    <option value="Absent">❌ Absent</option>
                                    <option value="Late">⏰ Late</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn">Mark Attendance</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="section">
                    <h2>📊 Attendance Records</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Course</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $teacherAttendance = array_filter($data['attendance'], function($att) use ($userId) {
                                return $att->teacher_id == $userId;
                            });
                            foreach ($teacherAttendance as $att): 
                                $student = $this->model->getStudentById($att->student_id);
                                $course = null;
                                foreach ($data['courses'] as $c) {
                                    if ($c->id == $att->course_id) {
                                        $course = $c;
                                        break;
                                    }
                                }
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($att->date); ?></td>
                                    <td><?php echo htmlspecialchars($att->student_id); ?></td>
                                    <td><?php echo $student ? htmlspecialchars($student->name) : 'N/A'; ?></td>
                                    <td><?php echo $course ? htmlspecialchars($course->name) : 'N/A'; ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo strtolower($att->status); ?>">
                                            <?php echo htmlspecialchars($att->status); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="section">
                    <h2>⚠️ Students Below 75% Attendance</h2>
                    <?php foreach ($data['courses'] as $course): ?>
                        <?php if (!empty($data['below_threshold'][$course->id])): ?>
                            <h3><?php echo htmlspecialchars($course->name); ?></h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Attendance %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['below_threshold'][$course->id] as $item): ?>
                                        <tr class="danger">
                                            <td><?php echo htmlspecialchars($item['student']->id); ?></td>
                                            <td><?php echo htmlspecialchars($item['student']->name); ?></td>
                                            <td><?php echo $item['percentage']; ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                
          <?php elseif ($userType === 'student' && isset($data['student'])): ?>
    <!-- Enhanced Student Dashboard -->
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>👨‍🎓 Welcome, <?php echo htmlspecialchars($data['student']->name); ?></h2>
                <p>Student ID: <?php echo htmlspecialchars($data['student']->id); ?></p>
                <p>Email: <?php echo htmlspecialchars($data['student']->email); ?></p>
                <p>Enrolled Since: <?php echo htmlspecialchars($data['student']->enrollment_date); ?></p>
            </div>
            <div style="text-align: right;">
                <a href="index.php?type=student&user_id=<?php echo urlencode($userId); ?>&action=export" 
                   style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">
                    📥 Export Attendance
                </a>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="section">
        <h2>📊 My Attendance Overview</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <?php 
            $totalPercentage = 0;
            $courseCount = 0;
            foreach ($data['attendance_summary'] as $summary): 
                $totalPercentage += $summary['percentage'];
                $courseCount++;
                $course = $summary['course'];
                $percentage = $summary['percentage'];
                $statusClass = $percentage >= 75 ? 'success' : 'danger';
                $statusIcon = $percentage >= 75 ? '✅' : '⚠️';
            ?>
                <div class="stats-card <?php echo $statusClass; ?>" style="flex: 1; min-width: 200px;">
                    <h3><?php echo htmlspecialchars($course->name); ?></h3>
                    <div class="percentage" style="font-size: 2.5em;"><?php echo $percentage; ?>%</div>
                    <p>📅 <?php echo htmlspecialchars($course->schedule); ?></p>
                    <p>👨‍🏫 Teacher ID: <?php echo htmlspecialchars($course->teacher_id); ?></p>
                    <?php if ($percentage < 75): ?>
                        <span class="badge badge-absent">⚠️ Below 75% - Need Improvement</span>
                    <?php elseif ($percentage >= 90): ?>
                        <span class="badge badge-present">🏆 Excellent Attendance!</span>
                    <?php else: ?>
                        <span class="badge badge-present">✅ Good Standing</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            
            <?php if ($courseCount > 0): ?>
                <?php $averagePercentage = round($totalPercentage / $courseCount, 2); ?>
                <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h3 style="color: white;">📈 Overall Average</h3>
                    <div class="percentage" style="color: white;"><?php echo $averagePercentage; ?>%</div>
                    <p>Across All Courses</p>
                    <span class="badge" style="background: rgba(255,255,255,0.3); color: white;">
                        <?php echo $averagePercentage >= 75 ? '✅ On Track' : '⚠️ Needs Attention'; ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Detailed Attendance History -->
    <div class="section">
        <h2>📅 My Complete Attendance History</h2>
        
        <?php
        // Get detailed attendance with course names
        $detailedAttendance = $this->model->getDetailedStudentAttendance($userId);
        
        if (!empty($detailedAttendance)):
            // Group by course
            $attendanceByCourse = [];
            foreach ($detailedAttendance as $record) {
                $courseName = $record['course_name'];
                if (!isset($attendanceByCourse[$courseName])) {
                    $attendanceByCourse[$courseName] = [];
                }
                $attendanceByCourse[$courseName][] = $record;
            }
        ?>
        
        <?php foreach ($attendanceByCourse as $courseName => $records): ?>
            <div style="margin-bottom: 30px;">
                <h3 style="color: #667eea; margin-bottom: 15px;">
                    📚 <?php echo htmlspecialchars($courseName); ?>
                    <span style="font-size: 0.9em; color: #666; margin-left: 10px;">
                        (Teacher: <?php echo htmlspecialchars($records[0]['teacher_name']); ?>)
                    </span>
                </h3>
                
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Status</th>
                            <th>Marked By</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $presentCount = 0;
                        $totalCount = 0;
                        foreach ($records as $record): 
                            $att = $record['attendance'];
                            $statusClass = '';
                            $points = 0;
                            
                            if ($att->status == 'Present') {
                                $statusClass = 'badge-present';
                                $points = 1;
                                $presentCount++;
                                $totalCount++;
                            } elseif ($att->status == 'Absent') {
                                $statusClass = 'badge-absent';
                                $points = 0;
                                $totalCount++;
                            } elseif ($att->status == 'Late') {
                                $statusClass = 'badge-late';
                                $points = 0.5;
                                $presentCount += 0.5;
                                $totalCount++;
                            } else {
                                $statusClass = '';
                                $points = '-';
                            }
                            
                            $date = new DateTime($att->date);
                            $dayName = $date->format('l');
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($att->date); ?></td>
                                <td><?php echo $dayName; ?></td>
                                <td>
                                    <?php if ($att->status != 'Not Marked'): ?>
                                        <span class="badge <?php echo $statusClass; ?>">
                                            <?php echo htmlspecialchars($att->status); ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #999;">⏳ Not Yet Marked</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($att->teacher_id); ?></td>
                                <td><?php echo $points; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php if ($totalCount > 0): ?>
                            <tr style="background: #f8f9fa; font-weight: bold;">
                                <td colspan="4" style="text-align: right;">Course Attendance Rate:</td>
                                <td><?php echo round(($presentCount / $totalCount) * 100, 2); ?>%</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
        
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 10px;">
                <p style="font-size: 1.2em; color: #666;">📝 No attendance records found.</p>
                <p style="color: #999;">Your attendance will be recorded when classes begin.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Attendance Tips -->
    <div class="section">
        <h2>💡 Attendance Tips</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div style="padding: 20px; background: #e3f2fd; border-radius: 10px;">
                <h3 style="color: #1976d2;">✅ Present</h3>
                <p>Full credit (1 point) - You were present for the entire class</p>
            </div>
            <div style="padding: 20px; background: #fff3e0; border-radius: 10px;">
                <h3 style="color: #f57c00;">⏰ Late</h3>
                <p>Half credit (0.5 points) - You arrived after class started</p>
            </div>
            <div style="padding: 20px; background: #ffebee; border-radius: 10px;">
                <h3 style="color: #c62828;">❌ Absent</h3>
                <p>No credit (0 points) - You were not present in class</p>
            </div>
        </div>
        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 10px;">
            <p><strong>📌 Minimum Requirement:</strong> You need at least <strong>75% attendance</strong> to be in good standing.</p>
            <p><strong>⚠️ Warning:</strong> Students below 75% may face academic consequences.</p>
        </div>
    </div>
<?php endif; ?>
        </div>
    </div>
</body>
</html>