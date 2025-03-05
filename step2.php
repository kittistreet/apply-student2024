<?php 
session_start();
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">ข้อมูลรูปแบบการสมัครและข้อมูลการศึกษาเบื่องต้น</h6>
    </div>
    <div class="card-body">

        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">รูปแบบการสมัคร</label>
                <select class="form-control" id="type_application" name="type_application">
                    <option value="">-โปรดเลือกรูปแบบการสมัคร-</option>
                    <?php
                    // ดึงข้อมูลจากตาราง type_application
                    $stmt = $conn->prepare("SELECT ID_Type, Type_name FROM type_application WHERE Status = 1");
                    $stmt->execute();
                    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($applications as $app) {
                        echo '<option value="' . htmlspecialchars($app['ID_Type']) . '">' . htmlspecialchars($app['Type_name']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">หลักสูตรที่สมัคร</label>
                <select class="form-control" id="course" name="course">
                    <option value="">-โปรดเลือกหลักสูตร-</option>
                </select>
            </div>
        </div>


        <hr>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const educationSelect = document.getElementById("education");
                const educationInput = document.getElementById("education_L_1");
                const eduOtherDiv = document.getElementById("edu_other");
                const eduOtherInput = document.getElementById("Educationlevel_O");

                educationSelect.addEventListener("change", function() {
                    const selectedOption = educationSelect.options[educationSelect.selectedIndex];

                    if (selectedOption.value === "8") {
                        // แสดงช่องป้อนข้อมูลเมื่อเลือก "อื่นๆ โปรดระบุ"
                        eduOtherDiv.hidden = false;
                        eduOtherInput.disabled = false;
                        educationInput.placeholder = "โปรดระบุระดับการศึกษา...";

                        // ถ่ายโอนค่าจาก Educationlevel_O ไปยัง education_L_1
                        eduOtherInput.addEventListener('input', function() {
                            educationInput.value = eduOtherInput.value;
                        });
                    } else {
                        // ซิงค์ค่ากับ placeholder
                        eduOtherDiv.hidden = true;
                        eduOtherInput.disabled = true;
                        educationInput.placeholder = selectedOption.text;
                        educationInput.value = ""; // ล้างค่าเมื่อไม่ใช่ตัวเลือก 'อื่นๆ'
                    }
                });
            });
        </script>


        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ระดับการศึกษา</label>
                <select class="form-control" id="education" name="education">
                    <option>-โปรดเลือกระดับการศึกษา-</option>
                    <option value="1">มัธยมศึกษา 6 (ม.6)</option>
                    <option value="2">ประกาศนียบัตรวิชาชีพ (ปวช.)</option>
                    <option value="3">ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส.)</option>
                    <option value="4">การศึกษานอกระบบและการศึกษาตามอัธยาศัย (กศน.)</option>
                    <option value="5">ระดับปริญญาตรี (ป.ตรี)</option>
                    <option value="6">ระดับปริญญาโท (ป.โท)</option>
                    <option value="7">ระดับปริญญาโท (ป.เอก)</option>
                    <option value="8">อื่นๆ โปรดระบุ </option>
                </select>
            </div>
        </div>
        <div class="form-group row" id="edu_other" hidden>
            <div class="col-sm-12 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user" id="Educationlevel_O" name="Educationlevel_O"
                    placeholder="โปรดระบุระดับการศึกษา..." disabled>
            </div>
        </div>




        <script>
            document.getElementById("education").addEventListener("change", function() {
                var educationInput = document.getElementById("Educationlevel_O");
                var parentDiv = educationInput.closest(".form-group.row");

                if (this.value === "8") {
                    parentDiv.hidden = false; // แสดงช่องกรอกข้อมูล
                    educationInput.disabled = false; // เปิดใช้งานช่องกรอกข้อมูล
                } else {
                    parentDiv.hidden = true; // ซ่อนช่องกรอกข้อมูล
                    educationInput.disabled = true; // ปิดการใช้งานช่องกรอกข้อมูล
                }
            });
        </script>



        <?php
        try {
            $stmt = $conn->prepare("SELECT Name_plan FROM study_plan");
            $stmt->execute();
            $studyPlans = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            $studyPlans = [];
        }
        ?>

        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user" id="edu_plan" name="edu_plan"
                    placeholder="โปรดระบุแผนการเรียน... (สายวิทย์-คณิต, ศิลป์-ภาษา, ศิลป์-คํานวณ, อื่นๆ )" list="edu_plan_list">
                <datalist id="edu_plan_list">
                    <?php foreach ($studyPlans as $plan): ?>
                        <option value="<?php echo htmlspecialchars($plan); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const inputField = document.getElementById("edu_plan");

                inputField.addEventListener("change", function() {
                    let value = inputField.value.trim();
                    if (value !== "") {
                        fetch('save_plan.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'plan=' + encodeURIComponent(value)
                        });
                    }
                });
            });
        </script>
















        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <input type="text" class="form-control form-control-user" id="gpa" name="gpa"
                    placeholder="เกรดเฉลี่ยสะสม... (GPA)">
            </div>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const gpaInput = document.getElementById("gpa");
                const typeApplication = document.getElementById("type_application");
                const course = document.getElementById("course");
                const modalBody = document.querySelector("#logoutModal .modal-body");
                const logoutModal = new bootstrap.Modal(document.getElementById("logoutModal"));

                let courseData = {}; // เก็บข้อมูลหลักสูตรและ GPA ที่ดึงมา

                function showModal(message) {
                    modalBody.innerHTML = message;
                    logoutModal.show();
                }

                function validateGPA() {
                    let gpaValue = parseFloat(gpaInput.value);
                    let typeValue = typeApplication.value;
                    let courseValue = course.value;

                    if (isNaN(gpaValue) || gpaValue < 0 || gpaValue > 4.00) {
                        showModal("กรุณากรอกค่า GPA ให้ถูกต้อง (0.00 - 4.00)");
                        gpaInput.value = "";
                        gpaInput.focus();
                        return;
                    }

                    gpaInput.value = gpaValue.toFixed(2); // ปัดค่าให้เป็นทศนิยม 2 ตำแหน่งเสมอ

                    if (!typeValue || !courseValue) {
                        showModal("กรุณาเลือกรูปแบบการสมัครและหลักสูตรก่อนกรอก GPA");
                        gpaInput.value = "";
                        return;
                    }

                    // ตรวจสอบ GPA ที่ดึงมาจากฐานข้อมูล
                    if (courseData[courseValue]) {
                        let minGPA = parseFloat(courseData[courseValue].GPA).toFixed(2); // แปลงค่าเป็นทศนิยม 2 ตำแหน่ง

                        if (gpaValue < parseFloat(minGPA)) {
                            showModal(`สำหรับการสมัคร ${typeApplication.options[typeApplication.selectedIndex].text} ${courseData[courseValue].Name_Course} ต้องมี GPA ไม่น้อยกว่า ${minGPA}`);
                            gpaInput.value = "";
                            gpaInput.focus();
                        }
                    }
                }

                function resetGPA() {
                    gpaInput.value = "";
                }




                typeApplication.addEventListener("change", function() {
                    let typeId = this.value;
                    course.innerHTML = '<option value="">-โปรดเลือกหลักสูตร-</option>'; // ล้างค่าเก่า
                    courseData = {}; // ล้างข้อมูลหลักสูตรเก่าด้วย

                    if (!typeId) return;

                    // ส่งค่าไปยัง get_courses.php ด้วย AJAX
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "get_courses.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            let courses = JSON.parse(xhr.responseText);

                            courses.forEach(function(courseItem) {
                                let option = document.createElement("option");
                                option.value = courseItem.ID_Course;
                                option.textContent = courseItem.Name_Course;
                                course.appendChild(option);

                                // บันทึกค่า GPA ไว้เพื่อตรวจสอบ
                                courseData[courseItem.ID_Course] = {
                                    Name_Course: courseItem.Name_Course,
                                    GPA: parseFloat(courseItem.GPA).toFixed(2) // แปลงเป็นทศนิยม 2 ตำแหน่ง
                                };
                            });
                        }
                    };

                    xhr.send("type_id=" + encodeURIComponent(typeId));
                });

                gpaInput.addEventListener("change", validateGPA);
                course.addEventListener("change", resetGPA);
            });
        </script>




        <hr>



        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ข้อมูลการลงทะเบียน TCAS</label>
                <select class="form-control" name="tcas" id="tcas">
                    <option>-โปรดเลือกข้อมูลการลงทะเบียน TCAS-</option>
                    <option value="1">ลงทะเบียน TCAS เรียบร้อย</option>
                    <option value="0">ยังไม่ได้ลงทะเบียน TCAS</option>
                </select>
            </div>
        </div>


        <button type="button" class="btn btn-primary btn-user btn-block" id="next-2" disabled>NEXT</button>
        <button type="button" class="btn btn-warning btn-user btn-block" id="prev-2">BACK</button>




        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const requiredFields = [
                    "type_application",
                    "course",
                    "education",
                    "edu_plan",
                    "gpa",
                    "tcas"
                ];

                const next2Button = document.getElementById("next-2");

                function checkFormCompletion() {
                    let allFilled = true;

                    requiredFields.forEach(fieldId => {
                        let field = document.getElementById(fieldId);

                        if (field && !field.disabled) { // ✅ ข้ามฟิลด์ที่ถูกปิดการใช้งาน
                            if (field.tagName === "SELECT") {
                                if (field.value === "" || field.value.startsWith("-โปรดเลือก")) {
                                    allFilled = false;
                                }
                            } else if (field.tagName === "INPUT") {
                                if (field.type === "text" || field.type === "number") {
                                    if (field.value.trim() === "") {
                                        allFilled = false;
                                    }
                                } else if (field.type === "radio" || field.type === "checkbox") {
                                    let name = field.name;
                                    let checked = document.querySelector(`input[name="${name}"]:checked`);
                                    if (!checked) {
                                        allFilled = false;
                                    }
                                }
                            }
                        }
                    });

                    next2Button.disabled = !allFilled;
                }


                // ตรวจสอบค่าทุกครั้งที่มีการเปลี่ยนแปลง
                requiredFields.forEach(fieldId => {
                    let field = document.getElementById(fieldId);
                    if (field) {
                        field.addEventListener("input", checkFormCompletion);
                        field.addEventListener("change", checkFormCompletion);
                    }
                });



                // ตรวจสอบค่าเริ่มต้นเมื่อโหลดหน้า
                checkFormCompletion();
            });
        </script>








        <hr>

    </div>
</div>