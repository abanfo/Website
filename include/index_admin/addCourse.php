
<?php
$f1 = "";
if (isset($_POST['addCourse'])) {
    $f1 = "";
} elseif (isset($_POST['clearfield'])) {
    $f1 = "";
}

if (isset($_POST['generateNumber'])) {
    $sql = "SELECT courseID FROM course ORDER BY courseID DESC limit 1";
    $result = $connection->query($sql);
    $row = mysqli_fetch_row($result);
    $lastCourseNumber = substr("$row[0]", 4);
    $newCourseNumber = $lastCourseNumber + 1;
    if (strlen($newCourseNumber) == 1) {
        $newCourseNumber = "00" . $newCourseNumber;
    } elseif (strlen($newCourseNumber) == 2) {
        $newCourseNumber = "0" . $newCourseNumber;
    } else {
    }
    $courseID = "IBIS" . $newCourseNumber;
    $f1 = $courseID;
}

$f2 = isset($_POST['addCourse']) || isset($_POST['generateNumber']) ? $_POST['newCourseName'] : "";
$f3 = isset($_POST['addCourse']) || isset($_POST['generateNumber']) ? $_POST['newCapacity'] : "";
$f4 = isset($_POST['addCourse']) || isset($_POST['generateNumber']) ? $_POST['newStudyLoad'] : "";
$f5 = "";

$allTeacherSQL = "SELECT personID, CONCAT(firstName,' ',lastName) AS instructor FROM person WHERE type='teacher'";
$result = $connection->query($allTeacherSQL);
$num_rows = mysqli_num_rows($result);
$f5b = "selected";
if ($result) {
    if ($num_rows > 0) {
        $t = (isset($_POST['addCourse']) || isset($_POST['generateNumber'])) &&  isset($_POST['newInstructor']) ? $_POST['newInstructor']:"";
        for ($x = 0; $x < $num_rows; $x++) {
            $result->data_seek($x);
            $data = $result->fetch_array();
            $allInstructor = $data['instructor'];
            $teacherID = $data['personID'];
            if($t == $teacherID){
                $f5 .= "<option selected value='$teacherID'>$allInstructor</option>";
                $f5b = "";
            }else{
                $f5 .= "<option  value='$teacherID'>$allInstructor</option>";
            }
        }
    }
}
?>



<form name="editCourse" method="post">
    <p>
        Course ID : <input type="text" name="newCourseID" readonly value="<?php echo $f1 ?>"/>
    </p>

    <p>
        Course name : <input type="text" name="newCourseName" size="50" value="<?php echo $f2 ?>"/>
    </p>

    <p>
        Student capacity: <input type="number" name="newCapacity" value="<?php echo $f3 ?>"/>
    </p>

    <p>
        Study load : <input type="number" name="newStudyLoad" value="<?php echo $f4 ?>"/>
    </p>

    <p>
        Instructor :
        <select name="newInstructor">
            <option value="" <?php echo $f5b ?> disabled></option>
            <?php echo $f5 ?>
        </select>
    </p>

    <input type='submit' name='generateNumber' value='Generate New Course Number'/>
    <input type='submit' name='refresh' value='Clear Field'/>
    <input type='submit' name='addCourse' value='Save'/> <?php addNewCourse(); ?>
</form>

<br/>
<hr/>

<p>
<h4>Upload a .csv file (for course):
    <button class="instructionButton" onclick='function1("CourseInstruction")'>
        instruction
    </button>
</h4>
<form name="import" method="post" enctype="multipart/form-data">
    <input type="file" name="file"/><br/>
    <input type="submit" name="submitCourseCSV" value="Submit"/><?php addCourseCSV(); ?>
</form>
</p>

<br/>
<hr/>

<p>
<h4>Upload a .csv file (for lesson):
    <button class="instructionButton" onclick='function1("LessonInstruction")'>
        instruction
    </button>
</h4>
<form name="import" method="post" enctype="multipart/form-data">
    <input type="file" name="file"/><br/>
    <input type="submit" name="submitLessonCSV" value="Submit"/> <?php addLessonCSV(); ?>
</form>
</p>

<div id='lightCourseInstruction' class='white_content'>
    <img src="image/instruction_course.jpg" class="instructionImage"/>
    <button class='back' onclick='function2("CourseInstruction")'>Close</button>
</div>

<div id='lightLessonInstruction' class='white_content'>
    <img src="image/instruction_lesson.jpg" class="instructionImage"/>
    <button class='back' onclick='function2("LessonInstruction")'>Close</button>
</div>