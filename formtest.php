<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wizard Form - 3 Steps</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">





                <div id="step-1">
                    <h3>Step 1: ข้อตกลงและเงื่อนไข</h3>
                    <p>โปรดยอมรับข้อตกลงก่อนดำเนินการต่อ</p>
                    <input type="checkbox" id="agree" onclick="toggleNextButton()"> <label for="agree">ฉันยอมรับข้อตกลง</label>
                    <br>
                    <button class="btn btn-primary mt-3" id="next-1" disabled onclick="nextStep(1)">ถัดไป</button>
                </div>
                






                <div id="step-2" class="hidden">
                    <h3>Step 2: ข้อมูลการศึกษา</h3>
                    <label>เลือกระดับการศึกษา:</label>
                    <select class="form-control">
                        <option>ม.6</option>
                        <option>ปวช.</option>
                        <option>กศน.</option>
                    </select>
                    <br>
                    <button class="btn btn-secondary" onclick="prevStep(2)">ย้อนกลับ</button>
                    <button class="btn btn-primary" onclick="nextStep(2)">ถัดไป</button>
                </div>
                

                
                <div id="step-3" class="hidden">
                    <h3>Step 3: ข้อมูลส่วนตัว</h3>
                    <label>ชื่อ:</label>
                    <input type="text" class="form-control" placeholder="ระบุชื่อของคุณ">
                    <br>
                    <button class="btn btn-secondary" onclick="prevStep(3)">ย้อนกลับ</button>
                    <button class="btn btn-success">ส่งข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function toggleNextButton() {
            document.getElementById('next-1').disabled = !document.getElementById('agree').checked;
        }

        function nextStep(step) {
            document.getElementById(`step-${step}`).classList.add('hidden');
            document.getElementById(`step-${step + 1}`).classList.remove('hidden');
        }
        
        function prevStep(step) {
            document.getElementById(`step-${step}`).classList.add('hidden');
            document.getElementById(`step-${step - 1}`).classList.remove('hidden');
        }
    </script>
</body>
</html>
