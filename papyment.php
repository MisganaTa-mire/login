<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Payment System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .payment-container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .pay-button {
            width: 100%;
            padding: 0.75rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .pay-button:hover {
            background: #0056b3;
        }

        .payment-method-fields {
            margin-top: 1rem;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 4px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 1rem;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 1rem;
        }

        .language-switcher {
            text-align: right;
            margin-bottom: 1rem;
        }

        .language-btn {
            background: none;
            border: 1px solid #007bff;
            color: #007bff;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .language-btn.active {
            background: #007bff;
            color: white;
        }

        .otp-container {
            display: none;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="language-switcher">
            <button class="language-btn active" data-lang="en">English</button>
            <button class="language-btn" data-lang="am">አማርኛ</button>
        </div>
        
        <h1 data-i18n="make_payment">Make a Payment</h1>
        
        <form id="paymentForm" method="POST">
            <!-- User & Property Details -->
            <div class="form-group">
                <label for="property_id" data-i18n="property_id">Property ID</label>
                <input type="text" id="property_id" name="property_id" required>
            </div>

            <div class="form-group">
                <label for="amount" data-i18n="amount">Amount (birr)</label>
                <input type="number" id="amount" name="amount" min="1" required>
            </div>

            <!-- Payment Method Selection -->
            <div class="form-group">
                <label data-i18n="payment_method">Payment Method</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="" data-i18n="select">Select_method</option>
                    <option value="credit_card" data-i18n="credit_card">Credit Card</option>
                    <option value="bank_transfer" data-i18n="bank_transfer">Bank Transfer</option>
                    <option value="mobile_payment" data-i18n="mobile_payment">Mobile Payment</option>
                </select>
            </div>

            <!-- Credit Card Fields -->
            <div id="creditCardFields" class="payment-method-fields" style="display:none;">
                <div class="form-group">
                    <label for="card_number" data-i18n="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                </div>
                <div class="form-group">
                    <label for="expiry_date" data-i18n="expiry_date">Expiry Date</label>
                    <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label for="cvv" data-i18n="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123">
                </div>
            </div>

            <!-- Bank Transfer Fields -->
            <div id="bankTransferFields" class="payment-method-fields" style="display:none;">
                <div class="form-group">
                    <label for="account_number" data-i18n="account_number">Account Number</label>
                    <input type="text" id="account_number" name="account_number">
                </div>
                <div class="form-group">
                    <label for="routing_number" data-i18n="routing_number">Routing Number</label>
                    <input type="text" id="routing_number" name="routing_number">
                </div>
            </div>

            <!-- Mobile Payment Fields -->
            <div id="mobilePaymentFields" class="payment-method-fields" style="display:none;">
                <div class="form-group">
                    <label for="mobile_provider" data-i18n="mobile_provider">Mobile Provider</label>
                    <select id="mobile_provider" name="mobile_provider" required>
                        <option value="" data-i18n="select_provider">-- Select Provider --</option>
                        <option value="telebirr" data-i18n="telebirr">Telebirr</option>
                        <option value="m_pesa" data-i18n="m_pesa">M-Pesa</option>
                        <option value="cbebirr" data-i18n="cbebirr">CBE Birr</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mobile_number" data-i18n="mobile_number">Mobile Number</label>
                    <input type="tel" id="mobile_number" name="mobile_number" placeholder="9XXXXXXXX" required>
                </div>
                <div class="form-group">
                    <label for="mobile_pin" data-i18n="mobile_pin">PIN</label>
                    <input type="password" id="mobile_pin" name="mobile_pin" placeholder="****" required>
                </div>
                <div id="otpContainer" class="otp-container">
                    <div class="form-group">
                        <label for="otp_code" data-i18n="otp_code">OTP Code</label>
                        <input type="text" id="otp_code" name="otp_code" placeholder="Enter 6-digit code">
                    </div>
                    <button type="button" id="verifyOtpBtn" class="pay-button" data-i18n="verify_otp">Verify OTP</button>
                </div>
            </div>

            <button type="submit" class="pay-button" data-i18n="submit_payment">Submit Payment</button>
            
            <div id="message"></div>
        </form>
    </div>

    <script>
        // Language translations
        const translations = {
            en: {
                make_payment: "Make a Payment",
                property_id: "Property ID",
                amount: "Amount ($)",
                payment_method: "Payment Method",
                select: "-- Select --",
                credit_card: "Credit Card",
                bank_transfer: "Bank Transfer",
                mobile_payment: "Mobile Payment",
                card_number: "Card Number",
                expiry_date: "Expiry Date",
                cvv: "CVV",
                account_number: "Account Number",
                routing_number: "Routing Number",
                submit_payment: "Submit Payment",
                payment_success: "Payment processed successfully!",
                payment_error: "Error processing payment",
                mobile_provider: "Mobile Provider",
                select_provider: "Select Provider",
                telebirr: "Telebirr",
                m_pesa: "M-Pesa",
                cbebirr: "CBE Birr",
                mobile_number: "Mobile Number",
                mobile_pin: "PIN",
                otp_code: "OTP Code",
                verify_otp: "Verify OTP",
                otp_sent: "OTP sent to your mobile number",
                otp_verified: "OTP verified successfully",
                otp_error: "Invalid OTP code"
            },
            am: {
                make_payment: "ክፍያ ያድርጉ",
                property_id: "ንብረት መለያ",
                amount: "መጠን (ብር)",
                payment_method: "የክፍያ ዘዴ",
                select: "ይምረጡ",
                credit_card: "ክሬዲት ካርድ",
                bank_transfer: "ባንክ ልውውጥ",
                mobile_payment: "ሞባይል ክፍያ",
                card_number: "ካርድ ቁጥር",
                expiry_date: "የሚያልቅበት ቀን",
                cvv: "CVV",
                account_number: "መለያ ቁጥር",
                routing_number: "ሩቲንግ ቁጥር",
                submit_payment: "ክፍያ አስገባ",
                payment_success: "ክፍያ በተሳካ ሁኔታ ተከናውኗል!",
                payment_error: "በክፍያ ሂደት ላይ ስህተት ተፈጥሯል",
                mobile_provider: "ሞባይል አገልጋይ",
                select_provider: "አገልጋይ ይምረጡ",
                telebirr: "ተሌብር",
                m_pesa: "ኤም-ፔሳ",
                cbebirr: "ሲቢኢ ብር",
                mobile_number: "ሞባይል ቁጥር",
                mobile_pin: "ፒን",
                otp_code: "OTP ኮድ",
                verify_otp: "OTP ያረጋግጡ",
                otp_sent: "OTP ወደ ሞባይል ቁጥርዎ ተልኳል",
                otp_verified: "OTP በተሳካ ሁኔታ ተረጋግጧል",
                otp_error: "የተሳሳተ OTP ኮድ"
            }
        };

        // Language switcher
        document.querySelectorAll('.language-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.language-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const lang = this.dataset.lang;
                changeLanguage(lang);
            });
        });

        // Change language function
        function changeLanguage(lang) {
            document.querySelectorAll('[data-i18n]').forEach(element => {
                const key = element.getAttribute('data-i18n');
                if (translations[lang][key]) {
                    element.textContent = translations[lang][key];
                }
                
                // For select options
                if (element.tagName === 'OPTION') {
                    element.textContent = translations[lang][key];
                }
            });
        }

        // Show/hide payment method fields
        document.getElementById('payment_method').addEventListener('change', function() {
            const method = this.value;
            
            document.getElementById('creditCardFields').style.display = 'none';
            document.getElementById('bankTransferFields').style.display = 'none';
            document.getElementById('mobilePaymentFields').style.display = 'none';
            document.getElementById('otpContainer').style.display = 'none';
            
            if (method === 'credit_card') {
                document.getElementById('creditCardFields').style.display = 'block';
            } else if (method === 'bank_transfer') {
                document.getElementById('bankTransferFields').style.display = 'block';
            } else if (method === 'mobile_payment') {
                document.getElementById('mobilePaymentFields').style.display = 'block';
            }
        });

        // Form submission with AJAX
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const paymentMethod = document.getElementById('payment_method').value;
            const messageDiv = document.getElementById('message');
            const lang = document.querySelector('.language-btn.active').dataset.lang;
            
            if (paymentMethod === 'mobile_payment') {
                // For mobile payment, first verify details before sending OTP
                const mobileNumber = document.getElementById('mobile_number').value;
                const mobilePin = document.getElementById('mobile_pin').value;
                
                if (!mobileNumber || !mobilePin) {
                    messageDiv.innerHTML = `<p class="error-message">${translations[lang]['payment_error']}</p>`;
                    return;
                }
                
                // Simulate sending OTP (in real app, this would call your backend)
                document.getElementById('otpContainer').style.display = 'block';
                messageDiv.innerHTML = `<p class="success-message">${translations[lang]['otp_sent']}</p>`;
                
                // Hide the submit button for mobile payment until OTP is verified
                document.querySelector('.pay-button[type="submit"]').style.display = 'none';
                
                return;
            }
            
            // For other payment methods, proceed with normal submission
            processPayment();
        });

        // OTP Verification
        document.getElementById('verifyOtpBtn').addEventListener('click', function() {
            const otpCode = document.getElementById('otp_code').value;
            const messageDiv = document.getElementById('message');
            const lang = document.querySelector('.language-btn.active').dataset.lang;
            
            // Simulate OTP verification (in real app, this would call your backend)
            if (otpCode && otpCode.length === 6) {
                messageDiv.innerHTML = `<p class="success-message">${translations[lang]['otp_verified']}</p>`;
                document.querySelector('.pay-button[type="submit"]').style.display = 'block';
                processPayment();
            } else {
                messageDiv.innerHTML = `<p class="error-message">${translations[lang]['otp_error']}</p>`;
            }
        });

        // Process payment function
        function processPayment() {
            const formData = new FormData(document.getElementById('paymentForm'));
            const messageDiv = document.getElementById('message');
            const lang = document.querySelector('.language-btn.active').dataset.lang;
            
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes("successfully")) {
                    messageDiv.innerHTML = `<p class="success-message">${translations[lang]['payment_success']}</p>`;
                    document.getElementById('paymentForm').reset();
                    document.getElementById('creditCardFields').style.display = 'none';
                    document.getElementById('bankTransferFields').style.display = 'none';
                    document.getElementById('mobilePaymentFields').style.display = 'none';
                    document.getElementById('otpContainer').style.display = 'none';
                    document.querySelector('.pay-button[type="submit"]').style.display = 'block';
                } else {
                    messageDiv.innerHTML = `<p class="error-message">${data || translations[lang]['payment_error']}</p>`;
                }
            })
            .catch(error => {
                messageDiv.innerHTML = `<p class="error-message">${translations[lang]['payment_error']}</p>`;
            });
        }

        // Input validation for card number
        document.getElementById('card_number')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1 ');
        });

        // Input validation for expiry date
        document.getElementById('expiry_date')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').replace(/(\d{2})(?=\d)/g, '$1/');
        });

        // Input validation for CVV
        document.getElementById('cvv')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });

        // Input validation for mobile number
        document.getElementById('mobile_number')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Database configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "house_payments";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create payments table if it doesn't exist
        $createTableSQL = "CREATE TABLE IF NOT EXISTS payments (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            property_id VARCHAR(30) NOT NULL,
            amount DECIMAL(10, 2) NOT NULL,
            payment_method VARCHAR(20) NOT NULL,
            card_number VARCHAR(20),
            expiry_date VARCHAR(10),
            cvv VARCHAR(4),
            account_number VARCHAR(20),
            routing_number VARCHAR(20),
            mobile_provider VARCHAR(20),
            mobile_number VARCHAR(20),
            payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        if (!$conn->query($createTableSQL)) {
            die("Error creating table: " . $conn->error);
        }

        // Get form data
        $property_id = $_POST['property_id'] ?? '';
        $amount = $_POST['amount'] ?? 0;
        $payment_method = $_POST['payment_method'] ?? '';
        $card_number = $_POST['card_number'] ?? '';
        $expiry_date = $_POST['expiry_date'] ?? '';
        $cvv = $_POST['cvv'] ?? '';
        $account_number = $_POST['account_number'] ?? '';
        $routing_number = $_POST['routing_number'] ?? '';
        $mobile_provider = $_POST['mobile_provider'] ?? '';
        $mobile_number = $_POST['mobile_number'] ?? '';
        $otp_code = $_POST['otp_code'] ?? '';

        // Basic validation
        if (empty($property_id) || $amount <= 0 || empty($payment_method)) {
            die("Invalid payment details. Please fill all required fields.");
        }

        // Additional validation based on payment method
        if ($payment_method === 'credit_card' && (empty($card_number) || empty($expiry_date) || empty($cvv))) {
            die("Please provide all credit card details.");
        }

        if ($payment_method === 'bank_transfer' && (empty($account_number) || empty($routing_number))) {
            die("Please provide all bank transfer details.");
        }

        if ($payment_method === 'mobile_payment') {
            if (empty($mobile_provider) || empty($mobile_number)) {
                die("Please provide all mobile payment details.");
            }
            if (!preg_match('/^9\d{8}$/', $mobile_number)) {
                die("Invalid Ethiopian mobile number format. Must be 9 digits starting with 9.");
            }
            // In a real application, you would verify the OTP here
            if (empty($otp_code)) {
                die("Please verify your OTP code.");
            }
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO payments (
            property_id, 
            amount, 
            payment_method, 
            card_number, 
            expiry_date, 
            cvv, 
            account_number, 
            routing_number,
            mobile_provider,
            mobile_number
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param(
            "sdssssssss", 
            $property_id, 
            $amount, 
            $payment_method, 
            $card_number, 
            $expiry_date, 
            $cvv, 
            $account_number, 
            $routing_number,
            $mobile_provider,
            $mobile_number
        );

        if ($stmt->execute()) {
            echo "Payment processed successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>