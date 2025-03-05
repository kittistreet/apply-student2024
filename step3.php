<?php
session_start();
?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">ข้อมูลประวัติส่วนตัว</h6>
    </div>
    <div class="card-body">



        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 1 ข้อมูลประวัติส่วนตัว</h5>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2 mb-3 mb-sm-0">
                <label style="font-weight: bold;">คำนำหน้า<font style="color:crimson;">*</font></label>
                <select class="form-control" id="Title" name="Title">
                    <option>-โปรดระบุ-</option>
                    <option value="1">นาย</option>
                    <option value="2">นาง</option>
                    <option value="3">นางสาว</option>
                </select>
            </div>
            <div class="col-sm-5 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ชื่อ<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" id="firstname" name="firstname" placeholder="ระบุชื่อ...">
            </div>
            <div class="col-sm-5 mb-3 mb-sm-0">
                <label style="font-weight: bold;">สกุล<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" id="lastname" name="lastname" placeholder="ระบุนามสกุล...">
            </div>
        </div>


        <script>
            $(document).ready(function() {
                $("#multiStepForm").validate({
                    errorClass: "state-error",
                    validClass: "state-success",
                    errorElement: "em",

                    rules: {
                        firstname: {
                            required: true
                        },
                        lastname: {
                            required: true
                        }
                    },

                    messages: {
                        firstname: {
                            required: "Enter first name"
                        },
                        lastname: {
                            required: "Enter last name"
                        }
                    },

                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass(errorClass).removeClass(validClass);
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass(errorClass).addClass(validClass);
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element);
                    },

                    submitHandler: function(form) {
                        alert("Form submitted successfully!");
                        form.submit();
                    }
                });
            });
        </script>
<button type="submit">Submit</button>

        <div class="form-group row">
            <div class="col-sm-2 mb-3 mb-sm-0">
                <label style="font-weight: bold;">คำนำหน้า(ENG.)<font style="color:crimson;">*</font></label>
                <select class="form-control" id="Catholic_N" name="Catholic_N">
                    <option>-โปรดระบุ-</option>
                    <option value="1">Mr.</option>
                    <option value="2">Mrs.</option>
                    <option value="3">Miss.</option>
                </select>
            </div>
            <div class="col-sm-5 mb-3 mb-sm-0">
                <label style="font-weight: bold;">Firstname<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" id="gradYear_${recordCount}" placeholder="ระบุชื่อ Eng...">
            </div>
            <div class="col-sm-5 mb-3 mb-sm-0">
                <label style="font-weight: bold;">Lastname<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" id="gradYear_${recordCount}" placeholder="ระบุนามสกุล Eng...">
            </div>
        </div>















        <div class="form-group row">

            <div class="col-sm-2 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ปี/เดือน/วันเกิด<font style="color:crimson;">*</font></label>
                <select class="form-control" id="year" onchange="updateMonthAndDay()">
                    <option value="" selected>-ปีเกิด-</option>
                    <script>
                        let currentYear = new Date().getFullYear() + 543; // แปลงเป็น พ.ศ.
                        for (let i = currentYear; i >= currentYear - 100; i--) {
                            document.write(`<option value="${i}">${i}</option>`);
                        }
                    </script>
                </select>
            </div>

            <div class="col-sm-3 mb-3 mb-sm-0">
                <label for="month" class="form-label"> <br> </label>
                <select class="form-control" id="month" onchange="updateDays()" disabled>
                    <option value="" selected>-เดือนเกิด-</option>
                    <option value="1">มกราคม</option>
                    <option value="2">กุมภาพันธ์</option>
                    <option value="3">มีนาคม</option>
                    <option value="4">เมษายน</option>
                    <option value="5">พฤษภาคม</option>
                    <option value="6">มิถุนายน</option>
                    <option value="7">กรกฎาคม</option>
                    <option value="8">สิงหาคม</option>
                    <option value="9">กันยายน</option>
                    <option value="10">ตุลาคม</option>
                    <option value="11">พฤศจิกายน</option>
                    <option value="12">ธันวาคม</option>
                </select>
            </div>

            <div class="col-sm-2 mb-3 mb-sm-0">
                <label for="day" class="form-label"> <br> </label>
                <select class="form-control" id="day" disabled onchange="calculateAge()">
                    <option value="" selected>-วันเกิด-</option>
                </select>
            </div>



            <div class="col-sm-2 mb-3 mb-sm-0">
                <label for="age" style="font-weight: bold;">อายุ</label>
                <input type="text" class="form-control form-control-user" id="age" name="age" placeholder=" " disabled>
            </div>



            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">เพศ<font style="color:crimson;">*</font></label>
                <select class="form-control" id="Catholic_N" name="Catholic_N">
                    <option>-โปรดระบุ-</option>
                    <option value="1">หญิง</option>
                    <option value="2">ชาย</option>
                </select>
            </div>


            <!-- <div class="col-sm-12 mb-3 mb-sm-0"><br>
                <label for="birthDateEN" style="font-weight: bold;">วัน/เดือน/ปี ค.ศ. (เก็บไว้ส่งค่าเข้าฐานข้อมูล)</label>
                <input type="text" class="form-control form-control-user" id="birthDateEN" name="birthDateEN" placeholder=" " disabled>
            </div> -->



            <script>
                function updateMonthAndDay() {
                    const yearBuddhist = document.getElementById("year").value;
                    const monthSelect = document.getElementById("month");
                    const daySelect = document.getElementById("day");

                    if (yearBuddhist) {
                        monthSelect.disabled = false;
                    } else {
                        monthSelect.disabled = true;
                        daySelect.disabled = true;
                        monthSelect.value = "";
                        daySelect.innerHTML = '<option value="" selected>เลือกวัน</option>';
                    }
                }

                function updateDays() {
                    const yearBuddhist = document.getElementById("year").value;
                    const month = document.getElementById("month").value;
                    const daySelect = document.getElementById("day");

                    if (month) {
                        daySelect.disabled = false;
                        let yearGregorian = yearBuddhist - 543; // แปลงเป็น ค.ศ.
                        let daysInMonth = new Date(yearGregorian, month, 0).getDate();
                        daySelect.innerHTML = '<option value="" selected>เลือกวัน</option>';
                        for (let i = 1; i <= daysInMonth; i++) {
                            daySelect.innerHTML += `<option value="${i}">${i}</option>`;
                        }
                    } else {
                        daySelect.disabled = true;
                        daySelect.innerHTML = '<option value="" selected>เลือกวัน</option>';
                    }
                }

                function calculateAge() {
                    const yearBuddhist = document.getElementById("year").value;
                    const month = document.getElementById("month").value;
                    const day = document.getElementById("day").value;
                    const ageInput = document.getElementById("age");
                    const birthDateEN = document.getElementById("birthDateEN");

                    if (yearBuddhist && month && day) {
                        let yearGregorian = yearBuddhist - 543;
                        let birthDate = new Date(yearGregorian, month - 1, day);
                        let today = new Date();
                        let age = today.getFullYear() - birthDate.getFullYear();
                        let m = today.getMonth() - birthDate.getMonth();
                        let d = today.getDate() - birthDate.getDate();

                        if (m < 0 || (m === 0 && d < 0)) {
                            age--;
                        }
                        ageInput.placeholder = age + " ปี";
                        birthDateEN.placeholder = `${yearGregorian}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    } else {
                        ageInput.placeholder = "";
                        birthDateEN.placeholder = "";
                    }
                }
            </script>


        </div>





        <div class="form-group row">

            <div class="col-sm-2 mb-3 mb-sm-0">
                <label for="age" style="font-weight: bold;">เชื้อชาติ<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุเชื้อชาติ">
            </div>
            <div class="col-sm-2 mb-3 mb-sm-0">
                <label for="age" style="font-weight: bold;">สัญชาติ<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุสัญชาติ">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="age" style="font-weight: bold;">ศาสนา<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุศาสนา">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">จังหวัดที่เกิด<font style="color:crimson;">*</font></label>
                <select class="form-control" id="province_5" name="province_b">
                    <option value="">-โปรดเลือกจังหวัด-</option>
                </select>
            </div>
        </div>


        <div class="form-group row">

            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="age" style="font-weight: bold;">รหัสบัตรประจำตัวประชาชน/Passport<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุรหัสบัตรประจำตัวประชาชน">
            </div>
            <div class="col-sm-2 mb-3 mb-sm-0">
                <label for="age" style="font-weight: bold;">วันที่ออกบัตร<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" data-provide="datepicker" data-date-language="th-th" name=" " placeholder="ระบุวันที่ออกบัตร" readonly>
            </div>
            <div class="col-sm-2 mb-3 mb-sm-0">
                <label for="age" style="font-weight: bold;">บัตรหมดอายุ<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" data-provide="datepicker" data-date-language="th-th" name=" " placeholder="ระบุวันที่บัตรหมดอายุ" readonly>
            </div>

            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ออกให้ ณ จังหวัด<font style="color:crimson;">*</font></label>
                <select class="form-control" id="province_6" name="province_b">
                    <option value="">-โปรดเลือกจังหวัด-</option>
                </select>
            </div>

        </div>









        <br><br>









        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 2 ที่อยู่ปัจจุบัน
                </h5>
            </div>
        </div>



        <div class="form-group row">
            <div class="col-sm-8 mb-3 mb-sm-0">
                <label style="font-weight: bold;">บ้านเลขที่, ซอย, หมู่, ถนน<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name="Address1" placeholder="ระบุบ้านเลขที่, ซอย, หมู่, ถนน... ">
            </div>

            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">จังหวัด<font style="color:crimson;">*</font></label>
                <select class="form-control" id="province_7" name="province_1">
                    <option value="">-โปรดเลือกจังหวัด-</option>
                </select>
            </div>

        </div>

        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">เขต/อำเภอ<font style="color:crimson;">*</font></label>
                <select class="form-control" id="District_1" name="District_1">
                    <option value="">-โปรดเลือก เขต/อำเภอ-</option>
                </select>
            </div>

            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">แขวง/ตำบล<font style="color:crimson;">*</font></label>
                <select class="form-control" id="Sub_District_1" name="Sub_District_1">
                    <option value="">-โปรดเลือก แขวง/ตำบล-</option>
                </select>
            </div>

            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">รหัสไปรษณีย์<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" id="zipcode_1" name="zipcode_1" placeholder="ระบุรหัสไปรษณีย์...">
            </div>
        </div>





        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">โทรศัพท์(มือถือ)<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name="Phone_1" placeholder="ระบุเบอร์โทรศัพท์...">
            </div>

            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ID Line</label>
                <input type="text" class="form-control form-control-user" name="IDLine" placeholder="ระบุไอดีไลน์...">
            </div>

            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">อีเมล<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name="Email_1" placeholder="ระบุอีเมล...">
            </div>
        </div>


        <br><br>

        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 3 ข้อมูลประวัติสุขภาพ
                </h5>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">น้ำหนัก<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" placeholder="ระบุน้ำหนัก... (กิโลกรัม)">
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ส่วนสูง<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" placeholder="ระบุส่วนสูง...(เซนติเมตร)">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ประวัติการแพ้ยา<font style="color:crimson;">*</font></label>
                <select class="form-control" id="allergy">
                    <option value="">-โปรดเลือก ประวัติการแพ้ยา-</option>
                    <option value="1">ไม่มี ประวัติการแพ้ยา</option>
                    <option value="2">มี ประวัติการแพ้ยา</option>
                </select>
            </div>

            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;"><br></label>
                <input type="text" class="form-control form-control-user" id="allergy_h" placeholder="ระบุประวัติการแพ้ยา..." disabled>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">โรคประจำตัว<font style="color:crimson;">*</font></label>
                <select class="form-control" id="disease">
                    <option value="">-โปรดเลือก-</option>
                    <option value="1">ไม่มี โรคประจำตัว</option>
                    <option value="2">มี โรคประจำตัว</option>
                </select>
            </div>

            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;"><br></label>
                <input type="text" class="form-control form-control-user" id="disease_h" placeholder="ระบุโรคประจำตัว..." disabled>
            </div>
        </div>



        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ความสามารถพิเศษ (ด้านกีฬา, ด้านดนตรี, ด้านภาษา, อื่น ๆ โปรดระบุ)</label>
                <textarea class="form-control" aria-label="With textarea" placeholder="ระบุความสามารถพิเศษ..."></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customCheck">
                <label class="custom-control-label" for="customCheck">
                    <font style="color:crimson;">*</font>ข้าพเจ้าสมบูรณ์ทั้งร่างกาย จิตใจและปราศจากโรคอันเป็นอุปสรรคต่อการศึกษา
                </label>
            </div>
        </div>















        <br><br>
        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 4 การขอทุนการศึกษาและกองทุนเงินกู้ยืม
                </h5>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ความประสงค์ขอกู้ทุนการศึกษา<font style="color:crimson;">*</font></label>
                <select class="form-control" id="disease">
                    <option value="">-โปรดเลือกความประสงค์ขอกู้ทุนการศึกษา-</option>
                    <option value="1">ไม่มีความประสงค์ขอกู้ทุนการศึกษา</option>
                    <option value="2">มีความประสงค์ขอกู้ทุนการศึกษา (กยศ.)</option>
                    <option value="2">มีความประสงค์ขอกู้ทุนการศึกษา (กรอ.)</option>
                </select>
            </div>


        </div>
















        <br><br>
        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 5 ประวัติการศึกษา
                </h5>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">โรงเรียนในเครือคาทอลิก<font style="color:crimson;">*</font></label>
                <select class="form-control" id="Catholic_N" name="Catholic_N">
                    <option>-โปรดเลือกโรงเรียนในเครือคาทอลิก-</option>
                    <option>ใช่</option>
                    <option>ไม่ใช่</option>

                </select>
            </div>
        </div>

        <hr>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const addButton = document.getElementById("addRecord");
                const container = document.getElementById("educationContainer");
                let recordCount = 1; // เริ่มต้นที่ 1 แถว

                // โหลดจังหวัดจาก JSON
                function loadProvinces(selectElement) {
                    fetch("json/thai_provinces.json")
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(province => {
                                let option = document.createElement("option");
                                option.value = province.id;
                                option.textContent = province.name_th;
                                selectElement.appendChild(option);
                            });
                        })
                        .catch(error => console.error("Error loading provinces:", error));
                }

                // โหลดจังหวัดสำหรับ dropdown แรก
                loadProvinces(document.getElementById("province_1"));
                loadProvinces(document.getElementById("province_5"));
                loadProvinces(document.getElementById("province_6"));
                loadProvinces(document.getElementById("province_8"));
                loadProvinces(document.getElementById("province_9"));

                addButton.addEventListener("click", function() {
                    if (recordCount < 3) { // จำกัดไม่เกิน 3 แถว
                        recordCount++;

                        // สร้างแถวใหม่
                        const newRow = document.createElement("div");
                        newRow.classList.add("form-group", "row");
                        newRow.setAttribute("id", `record_${recordCount}`);
                        newRow.innerHTML = `
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ระดับการศึกษา</label>
                <input type="text" class="form-control form-control-user" id="education_L_${recordCount}" placeholder="ระบุระดับการศึกษาเพิ่มเติม">
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ชื่อสถานศึกษา</label>
                <input type="text" class="form-control form-control-user" id="schoolName_${recordCount}" placeholder="ระบุชื่อสถานศึกษา...">
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">จังหวัด</label>
                <select class="form-control" id="province_${recordCount}" name="province">
                    <option value="">-เลือกจังหวัด-</option>
                </select>
            </div>
            <div class="col-sm-2 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ปีที่สำเร็จการศึกษา</label>
                <input type="text" class="form-control form-control-user" id="gradYear_${recordCount}" placeholder="ระบุ(พ.ศ.)...">
            </div>
            <div class="col-sm-1 mb-3 mb-sm-0 d-flex align-items-end">
                <button type="button" class="btn btn-danger delRecord" data-id="${recordCount}">ลบ</button>
            </div>
            `;

                        container.appendChild(newRow);

                        // โหลดข้อมูลจังหวัดใน select ใหม่ที่ถูกสร้างขึ้น
                        loadProvinces(document.getElementById(`province_${recordCount}`));

                        // ปิดปุ่ม Add ถ้าถึง 3 record
                        if (recordCount >= 3) {
                            addButton.disabled = true;
                        }
                    }
                });

                // ฟังก์ชันลบแถว
                container.addEventListener("click", function(event) {
                    if (event.target.classList.contains("delRecord")) {
                        const rowId = event.target.getAttribute("data-id");
                        const rowToRemove = document.getElementById(`record_${rowId}`);

                        if (rowToRemove) {
                            rowToRemove.remove();
                            recordCount--;

                            // เปิดปุ่ม Add ใหม่ถ้าจำนวนแถวน้อยกว่า 3
                            if (recordCount < 3) {
                                addButton.disabled = false;
                            }
                        }
                    }
                });
            });
        </script>

        <div id="educationContainer">
            <div class="form-group row" id="record_1">
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">ระดับการศึกษา<font style="color:crimson;">*</font></label>
                    <input type="text" class="form-control form-control-user" id="education_L_1" disabled>
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">ชื่อสถานศึกษา<font style="color:crimson;">*</font></label>
                    <input type="text" class="form-control form-control-user" id="schoolName_1" placeholder="โปรดระบุชื่อสถานศึกษา...">
                </div>
                <div class="col-sm-3 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">จังหวัด<font style="color:crimson;">*</font></label>
                    <select class="form-control" id="province_1" name="province">
                        <option value="">-โปรดเลือกจังหวัด-</option>
                    </select>
                </div>
                <div class="col-sm-2 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">ปีที่สำเร็จการศึกษา<font style="color:crimson;">*</font></label>
                    <input type="text" class="form-control form-control-user" id="gradYear_1" placeholder="โปรดระบุ(พ.ศ.)...">
                </div>
            </div>
        </div>

        <!-- ปุ่มเพิ่มแถว -->
        <button type="button" id="addRecord" class="btn btn-primary">เพิ่มข้อมูลระดับการศึกษาอื่น</button>






        <br><br><br>
        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 6 ข้อมูลบิดา-มารดา <font style="font-size: 14px; color:crimson; ">*กรณีไม่มีข้อมูลให้ใส่ ขีด(-)</font>
                </h5>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ชื่อบิดา<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุชื่อบิดา...">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">นามสกุล<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุนามสกุล...">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">สถานภาพการมีชีวิต<font style="color:crimson;">*</font></label>
                <select class="form-control" name=" ">
                    <option value="">-โปรดเลือกสถานภาพ-</option>
                    <option value="1">มีชีวิต</option>
                    <option value="2">เสียชีวิต</option>
                    <option value="2">สาบสูญ</option>
                    <option value="2">คนไร้ความสามารถ</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">อายุ</label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุอายุบิดา...">
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">อาชีพ</label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุอาชีพบิดา...">
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ที่อยู่ปัจจุบันจังหวัด</label>
                <select class="form-control" id="province_8" name="province_f">
                    <option value="">-โปรดเลือกจังหวัด-</option>
                </select>
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุเบอร์โทรศัพท์...">
            </div>
        </div>

        <br>

        <hr>


        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ชื่อมารดา<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุชื่อมารดา...">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">นามสกุล<font style="color:crimson;">*</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุนามสกุล...">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label style="font-weight: bold;">สถานภาพการมีชีวิต<font style="color:crimson;">*</font></label>
                <select class="form-control" name=" ">
                    <option value="">-โปรดเลือกสถานภาพ-</option>
                    <option value="1">มีชีวิต</option>
                    <option value="2">เสียชีวิต</option>
                    <option value="2">สาบสูญ</option>
                    <option value="2">คนไร้ความสามารถ</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">อายุ</label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุอายุมารดา...">
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">อาชีพ</label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุอาชีพมารดา...">
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ที่อยู่ปัจจุบันจังหวัด</label>
                <select class="form-control" id="province_9" name="province_m">
                    <option value="">-โปรดเลือกจังหวัด-</option>
                </select>
            </div>
            <div class="col-sm-3 mb-3 mb-sm-0">
                <label style="font-weight: bold;">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุเบอร์โทรศัพท์...">
            </div>
        </div>






        <br><br>
        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 7 ระหว่างการสมัครสามารถติดต่อข้าพเจ้าได้ที่
                </h5>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">สถาณีรถไฟฟ้าที่อยู่ใกล้ <font style="font-size: 14px; color:crimson; ">*กรณีไม่ได้อยู่ใกล้สถานีรถไฟฟ้า BTS/MRT ให้ใส่ ขีด(-)</font></label>
                <input type="text" class="form-control form-control-user" name=" " placeholder="ระบุสถาณีรถไฟฟ้าที่อยู่ใกล้...">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ที่อยู่ที่ใช้ในการติดต่อ<font style="color:crimson;">*</font></label>
                <select class="form-control" id="Address_2" name="Address_2">
                    <option value="">-โปรดเลือกที่อยู่ที่ใช้ในการติดต่อ-</option>
                    <option value="1">ใช้ที่อยู่ปัจจุบันในการติดต่อ</option>
                    <option value="2">ใช้ที่อยู่ใหม่ในการติดต่อ</option>
                </select>
            </div>
        </div>



        <div id="addhome" hidden>

            <div class="form-group row">
                <div class="col-sm-8 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">บ้านเลขที่, ซอย, หมู่, ถนน<font style="color:crimson;">*</font></label>
                    <input type="text" class="form-control form-control-user" placeholder="ระบุบ้านเลขที่, ซอย, หมู่, ถนน... " disabled>
                </div>

                <div class="col-sm-4 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">จังหวัด<font style="color:crimson;">*</font></label>
                    <select class="form-control" id="province_10" name="province_h" disabled>
                        <option value="">-โปรดเลือกจังหวัด-</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">เขต/อำเภอ<font style="color:crimson;">*</font></label>
                    <select class="form-control" id="District_2" name="District_2" disabled>
                        <option value="">-โปรดเลือก เขต/อำเภอ-</option>
                    </select>
                </div>

                <div class="col-sm-4 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">แขวง/ตำบล<font style="color:crimson;">*</font></label>
                    <select class="form-control" id="Sub_District_2" name="Sub_District_2" disabled>
                        <option value="">-โปรดเลือก แขวง/ตำบล-</option>
                    </select>
                </div>

                <div class="col-sm-4 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">รหัสไปรษณีย์<font style="color:crimson;">*</font></label>
                    <input type="text" class="form-control form-control-user" id="zipcode_2" placeholder="ระบุรหัสไปรษณีย์..." disabled>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">โทรศัพท์(มือถือ)<font style="color:crimson;">*</font></label>
                    <input type="text" class="form-control form-control-user" placeholder="ระบุเบอร์โทรศัพท์..." disabled>
                </div>

                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">อีเมล<font style="color:crimson;">*</font></label>
                    <input type="text" class="form-control form-control-user" placeholder="ระบุอีเมล..." disabled>
                </div>
            </div>

        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const addressSelect = document.getElementById("Address_2");
                const addHomeSection = document.getElementById("addhome");
                const inputs = addHomeSection.querySelectorAll("input, select");

                addressSelect.addEventListener("change", function() {
                    if (this.value === "2") {
                        addHomeSection.hidden = false;
                        inputs.forEach(input => input.disabled = false);
                    } else {
                        addHomeSection.hidden = true;
                        inputs.forEach(input => {
                            input.disabled = true;
                            if (input.tagName === "INPUT") input.value = ""; // ล้างค่าช่อง input
                            if (input.tagName === "SELECT") input.selectedIndex = 0; // รีเซ็ตค่า select
                        });
                    }
                });
            });
        </script>












        <script>
            let provinces = [];
            let amphures = [];
            let tambons = [];

            // โหลดข้อมูลจากไฟล์ JSON
            $(document).ready(function() {
                $.when(
                    $.getJSON("json/thai_provinces.json", function(data) {
                        provinces = data;
                    }),
                    $.getJSON("json/thai_amphures.json", function(data) {
                        amphures = data;
                    }),
                    $.getJSON("json/thai_tambons.json", function(data) {
                        tambons = data;
                    })
                ).done(function() {
                    // เติมข้อมูลจังหวัดใน dropdown
                    provinces.forEach(province => {
                        $('#province_7').append($('<option>', {
                            value: province.id,
                            text: province.name_th
                        }));
                        $('#province_10').append($('<option>', {
                            value: province.id,
                            text: province.name_th
                        }));
                    });
                });
            });

            // เมื่อเลือกจังหวัด
            $('#province_7').change(function() {
                let provinceId = $(this).val();
                $('#District_1').empty().append('<option value="">-โปรดเลือก เขต/อำเภอ-</option>');
                $('#Sub_District_1').empty().append('<option value="">-โปรดเลือก แขวง/ตำบล-</option>');
                $('#zipcode_1').val('');

                let filteredAmphures = amphures.filter(a => a.province_id == provinceId);
                filteredAmphures.forEach(amphure => {
                    $('#District_1').append($('<option>', {
                        value: amphure.id,
                        text: amphure.name_th
                    }));
                });
            });

            // เมื่อเลือกเขต/อำเภอ
            $('#District_1').change(function() {
                let amphureId = $(this).val();
                $('#Sub_District_1').empty().append('<option value="">-โปรดเลือก แขวง/ตำบล-</option>');
                $('#zipcode_1').val('');

                let filteredTambons = tambons.filter(t => t.amphure_id == amphureId);
                filteredTambons.forEach(tambon => {
                    $('#Sub_District_1').append($('<option>', {
                        value: tambon.id,
                        text: tambon.name_th,
                        "data-zipcode": tambon.zip_code
                    }));
                });
            });

            // เมื่อเลือกแขวง/ตำบล
            $('#Sub_District_1').change(function() {
                let zipCode = $('option:selected', this).data('zipcode');
                $('#zipcode_1').val(zipCode || '');
            });

            // เมื่อเลือกจังหวัด
            $('#province_10').change(function() {
                let provinceId = $(this).val();
                $('#District_2').empty().append('<option value="">-โปรดเลือก เขต/อำเภอ-</option>');
                $('#Sub_District_2').empty().append('<option value="">-โปรดเลือก แขวง/ตำบล-</option>');
                $('#zipcode_2').val('');

                let filteredAmphures = amphures.filter(a => a.province_id == provinceId);
                filteredAmphures.forEach(amphure => {
                    $('#District_2').append($('<option>', {
                        value: amphure.id,
                        text: amphure.name_th
                    }));
                });
            });

            // เมื่อเลือกเขต/อำเภอ
            $('#District_2').change(function() {
                let amphureId = $(this).val();
                $('#Sub_District_2').empty().append('<option value="">-โปรดเลือก แขวง/ตำบล-</option>');
                $('#zipcode_2').val('');

                let filteredTambons = tambons.filter(t => t.amphure_id == amphureId);
                filteredTambons.forEach(tambon => {
                    $('#Sub_District_2').append($('<option>', {
                        value: tambon.id,
                        text: tambon.name_th,
                        "data-zipcode": tambon.zip_code
                    }));
                });
            });

            // เมื่อเลือกแขวง/ตำบล
            $('#Sub_District_2').change(function() {
                let zipCode = $('option:selected', this).data('zipcode');
                $('#zipcode_2').val(zipCode || '');
            });
        </script>






        <br><br>
        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 8 แนบหลักฐานการสมัครเรียน
                </h5>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">สำเนาบัตรประชาชน <font style="font-size: 14px; color:crimson;">*ใช้ไฟล์ .PDF เท่านั้น</font></label>

                <input type="file" class="form-control" id="file_idcard" aria-describedby="inputGroupFileAddon01">
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">สำเนาทะเบียนบ้าน <font style="font-size: 14px; color:crimson;">*ใช้ไฟล์ .PDF เท่านั้น</font></label>

                <input type="file" class="form-control" id="file_Housereg" aria-describedby="inputGroupFileAddon01">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">สำเนาใบ ปพ.1 (ด้านหน้า) <font style="font-size: 14px; color:crimson;">*ใช้ไฟล์ .PDF เท่านั้น</font></label>
                <input type="file" class="form-control" id=" " aria-describedby="inputGroupFileAddon01">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">สำเนาใบ ปพ.1 (ด้านหลัง) <font style="font-size: 14px; color:crimson;">*ใช้ไฟล์ .PDF เท่านั้น</font></label>
                <input type="file" class="form-control" id=" " aria-describedby="inputGroupFileAddon01">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">
                    <font style="font-size: 14px; color:crimson;">(ถ้ามี) </font> ผลคะแนนTGAT <font style="font-size: 14px; color:crimson;">*ใช้ไฟล์ .PDF เท่านั้น</font>
                </label>
                <input type="file" class="form-control" id=" " aria-describedby="inputGroupFileAddon01">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">
                    <font style="font-size: 14px; color:crimson;">(ถ้ามี) </font> ผลคะแนนTPAT <font style="font-size: 14px; color:crimson;">*ใช้ไฟล์ .PDF เท่านั้น</font>
                </label>
                <input type="file" class="form-control" id=" " aria-describedby="inputGroupFileAddon01">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label style="font-weight: bold;">
                    <font style="font-size: 14px; color:crimson;">(ถ้ามี) </font> ผลคะแนน A-Level <font style="font-size: 14px; color:crimson;">*ใช้ไฟล์ .PDF เท่านั้น</font>
                </label>
                <input type="file" class="form-control" id=" " aria-describedby="inputGroupFileAddon01">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-8 mb-3 mb-sm-0">
                <label style="font-weight: bold;">ไฟล์หลักฐานอื่นๆ (เช่น ใบเปลี่ยนชื่อ,วุฒิบัตร เป็นต้น) <font style="font-size: 14px; color:crimson;">*ใช้ไฟล์ .PDF เท่านั้น</font></label>
                <input type="file" class="form-control" id=" " aria-describedby="inputGroupFileAddon01">
            </div>
        </div>





        <button id="fileCheckButton" class="btn btn-success btn-circle btn-sm" style="display: none;">
            <i class="fas fa-check"></i>
        </button>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var fileInputs = document.querySelectorAll('input[type="file"]');

                fileInputs.forEach(function(input) {
                    input.addEventListener('change', function(event) {
                        var inputLabel = event.target.nextElementSibling;
                        var fileName = event.target.files[0].name;
                        inputLabel.innerText = fileName;
                    });
                });
            });
        </script>










        <div id="Portfolio_Show" hidden>
            <br><br>
            <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <h5><i class="fas fa-flag"></i> ส่วน Portfolio <font>(เฉพาะผู้ที่สมัครรอบ Portfolio เท่านั้น)</font>
                    </h5>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 mb-3 mb-sm-0">
                    <label style="font-weight: bold;">ไฟล์ Portfolio <font style="color:crimson;">(ขนาดต้องไม่เกิน 30MB และ ใช้ไฟล์ PDF เท่านั้น)</font> </label>
                    <input type="file" class="form-control" id="File_Portfolio" aria-describedby="inputGroupFileAddon01" disabled>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var typeApplicationSelect = document.getElementById('type_application');
                var portfolioShow = document.getElementById('Portfolio_Show');
                var filePortfolioInput = document.getElementById('File_Portfolio');

                typeApplicationSelect.addEventListener('change', function() {
                    // Check if the selected value is '1'
                    if (this.value === '1') {
                        // Display the portfolio section
                        portfolioShow.hidden = false;

                        // Enable the file input and set the max file size for PDFs
                        filePortfolioInput.disabled = false;
                        filePortfolioInput.addEventListener('change', function() {
                            var file = this.files[0];
                            if (file.type !== 'application/pdf') {
                                alert('Please upload a PDF file.');
                                this.value = ''; // reset the input
                            } else if (file.size > 30000000) { // 30 MB limit
                                alert('File size must not exceed 30 MB.');
                                this.value = ''; // reset the input
                            }
                        });
                    } else {
                        // Hide the portfolio section and disable the file input if not selected
                        portfolioShow.hidden = true;
                        filePortfolioInput.disabled = true;
                        filePortfolioInput.value = ''; // Clear the input
                    }
                });
            });
        </script>








        <br><br>
        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 9 รับทราบข่าวสารประชาสัมพันธ์การรับสมัครจากที่ไหน
                </h5>
            </div>
        </div>




        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="chk_N1" name=" ">
                <label class="custom-control-label" for="chk_N1">Facebook หรือ Website หรือ Line Open chat วิทยาลัยเซนต์หลุยส์</label>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="chk_N2" name=" ">
                <label class="custom-control-label" for="chk_N2">การบอกต่อจากครอบครัว / รุ่นพี่ / เพื่อน</label>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="chk_N3" name=" ">
                <label class="custom-control-label" for="chk_N3">อาจารย์แนะแนว</label>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="chk_N4" name=" ">
                <label class="custom-control-label" for="chk_N4">การเข้าไปประชาสัมพันธ์ในโรงเรียน</label>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="chk_N5" name=" ">
                <label class="custom-control-label" for="chk_N5"> กูเกิ้ล(www.google.com)โดยการสืบค้น</label>
            </div>
        </div>





        <br><br>
        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 10 ข้าพเจ้าขอให้คำรับรองว่า
                </h5>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <font>
                    ข้อความข้างต้นนี้เป็นจริงทุกประการและข้าพเจ้ามีคุณสมบัติทั่วไปครบถ้วนและตรงตามประกาศรับสมัครและไม่เคยมีความประพฤติเสียหาย ทั้งนี้ หากมีการตรวจสอบเอกสารหรือคุณวุฒิของข้าพเจ้าในภายหลังไม่ตรงตามประกาศรับสมัครให้ถือว่าข้าพเจ้าเป็นผู้ขาดคุณสมบัติในการสมัครสอบครั้งนี้ และข้าพเจ้าจะไม่ใช้สิทธิเรียกร้องใด ๆ ทั้งสิ้น <b>วิทยาลัยเซนต์หลุยส์ขอสงวนสิทธิ์ในการคืนค่าสมัครเรียนทุกประการ</b>
                </font>
            </div>
        </div>
        <div class="form-group text-center">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="chk_sub" name=" ">
                <label class="custom-control-label" for="chk_sub">
                    <font style="color:crimson;">*</font>ข้าพเจ้าขอรับรองว่าข้อความดังกล่าวเป็นความจริงทุกประการ
                </label>
            </div>
        </div>






        <br><br>
        <div class="card mb-4 py-3 border-bottom-primary form-group row form-group row">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <h5><i class="fas fa-flag"></i> ส่วนที่ 11 ส่งหลักฐานการชำระเงินค่าใบสมัคร
                </h5>
            </div>
        </div>


        <div class="form-group row text-center">
            <div class="col-sm-12 mb-3 mb-sm-0">
                <font>
                    แนบหลักฐานการชำระเงินค่าสมัคร 400 บาท ภายใน 3 วัน <b>“นับจากวันที่สมัครสมัครออนไลน์เสร็จสิ้น”</b>
                </font>
                <br>
                <font style="color:crimson;">
                    ถ้าไม่ได้แนบหลักฐานในการชำระเงินในเวลาที่กำหนดผู้สมัครต้องทำการกรอกใบสมัครใหม่
                </font>
            </div>
        </div>






        <br><br>


        <div class="text-center">
            <!-- Google recaptcha -->

            <!-- <div style="display: inline-block; text-align: right;">
                <div class="g-recaptcha" data-sitekey="6Lf4JuMqAAAAAJjFULQzsHhJdz871EcbnDLfwOyE" data-callback="enableSubmitButton"></div>
            </div> -->

        </div>


        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <button type="submit" class="btn btn-primary btn-user btn-block" id="send">Submit</button>
        <button type="button" class="btn btn-warning btn-user btn-block" id="prev-3">BACK</button>

        <script>
            function enableSubmitButton() {
                document.getElementById("send").disabled = false;
            }
        </script>
        <hr>

    </div>
</div>