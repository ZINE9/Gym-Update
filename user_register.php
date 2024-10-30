<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Registration Form</title>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #ececec, #ffffff);
    margin: 0;
    padding-top: 100px; 
    color: #333;
}


main {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.form-container {
    background: #ffffff;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    max-width: 800px;
    width: 90%;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.form-column {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-left: 20px;
    margin-right: 20px;
}

form label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #444;
}

form input[type="text"],
form input[type="number"],
form input[type="date"],
form select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 15px;
    width: 80%;
}

form input[type="radio"] {
    margin-right: 5px;
}

.radio-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-item-full {
    grid-column: 1 / -1;
    margin-top: 15px;
}

form button {
    background-color: #007BFF;
    color: #ffffff;
    padding: 12px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%;
}

form button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Register Here</h2>
        <form id="registerForm">
        <div class="form-column">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div>
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div>
                    <label for="weight">Weight:</label>
                    <input type="number" id="weight" name="weight" required>
                    <select id="weight_unit" name="weight_unit">
                        <option value="lb">lb</option>
                        <option value="kg">kg</option>
                    </select>
                </div>
                
                <div class="form-item-full">
                    <label>Have surgery in the last six months?</label>
                    <div class="radio-group">
                        <input type="radio" id="yes" name="yes_no_option" value="yes" required>
                        <label for="yes">Yes</label>
                        <input type="radio" id="no" name="yes_no_option" value="no">
                        <label for="no">No</label>
                    </div>
                </div>

                <div class="form-item-full">
                    <label>Gender:</label>
                    <div class="radio-group">
                        <input type="radio" id="male" name="gender" value="male" required>
                        <label for="yes">Male</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="no">Female</label>
                    </div>
                </div>
            </div>

            <div class="form-column">
                <div>
                    <label for="command">User disease:</label><br>
                    <textarea name="command" placeholder="Enter your disease" rows="4" required></textarea>
                </div>
                <div>
                    <label for="select_option1">Which part is hurt?:</label>
                    <select id="select_option1" name="select_option1" required>
                        <option value="Knee">Knee</option>
                        <option value="Back">Back</option>
                        <option value="Arm">Arm</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="select_option2">Played before?</label>
                    <select id="select_option2" name="select_option2" required>
                        <option value="Under 3 Months">Under 3 Months</option>
                        <option value="Between 3 and 6 Months">Between 3 and 6 Months</option>
                        <option value="Above 6 Months">Above 6 Months</option>
                    </select>
                </div>
                <div>
                    <label for="select_option3">How much months does user play?</label>
                    <select id="select_option3" name="select_option3" required>
                        <option value="1">1 Month</option>
                        <option value="2">2 Months</option>
                        <option value="3">3 Months</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="date">Start Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
            </div>
            <button type="button" onclick="exportData()">Export Data</button>
        </form>
    </div>

    <script>
       function exportData() {
            const name = document.getElementById('name').value;
            const age = document.getElementById('age').value;
            const address = document.getElementById('address').value;
            const phone = document.getElementById('phone').value;
            const weight = document.getElementById('weight').value;
            const weightUnit = document.getElementById('weight_unit').value;
            const hasSurgery = document.querySelector('input[name="yes_no_option"]:checked')?.value;
            const gender = document.querySelector('input[name="gender"]:checked')?.value;
            const disease = document.querySelector('textarea[name="command"]').value;
            const hurtPart = document.getElementById('select_option1').value;
            const playedBefore = document.getElementById('select_option2').value;
            const playDuration = document.getElementById('select_option3').value;
            const startDate = document.getElementById('date').value;

            const data = `Name: ${name}\nAge: ${age}\nAddress: ${address}\nPhone: ${phone}\nWeight: ${weight} ${weightUnit}\nSurgery in Last 6 Months: ${hasSurgery}\nGender: ${gender}\nDisease: ${disease}\nHurt Part: ${hurtPart}\nPlayed Before: ${playedBefore}\nPlay Duration: ${playDuration}\nStart Date: ${startDate}`;

            const blob = new Blob([data], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);

            const link = document.createElement('a');
            link.href = url;
            link.download = 'registration.txt';
            document.body.appendChild(link); 
            link.click();
            document.body.removeChild(link); 

            URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>
