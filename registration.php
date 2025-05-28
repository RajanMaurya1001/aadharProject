<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f2f5;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            color: #1877f2;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #606770;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dddfe2;
            border-radius: 5px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #1877f2;
            box-shadow: 0 0 0 2px #e7f3ff;
        }

        .password-strength {
            font-size: 12px;
            color: #606770;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #1877f2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #166fe5;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #606770;
        }

        .login-link a {
            color: #1877f2;
            text-decoration: none;
        }

        .terms {
            font-size: 12px;
            color: #606770;
            text-align: center;
            margin: 15px 0;
        }

        .terms a {
            color: #1877f2;
            text-decoration: none;
        }

        .error-message {
            color: #ff0000;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Password visibility toggle */
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #606770;
        }
    </style>
</head>




<body>
    <div class="container">
        <h1>Register Hear</h1>

        <!-- <form id="registrationForm" method="post" action=""> -->
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Enter your full name" id="name" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter your email" id="email" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" name="phone" placeholder="Enter your phone number" id="phone" required>
        </div>

        <div class="form-group">
            <label>Enter State</label>
            <input type="text" name="state" placeholder="Enter your phone number" id="state" required>
        </div>

        <div class="form-group">
            <label>Enter District</label>
            <input type="text" name="district" placeholder="Enter your phone number" id="district" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="password-container">
                <input type="password" name="password" placeholder="Create password" id="password" required>
                <!-- <span class="toggle-password">👁️</span> -->
            </div>
        </div>

        <?php
        include('assets/config/config.php');
        $data = mysqli_query($conn, "SELECT * from services where service_name = 'membership_amount'");
        if (mysqli_num_rows($data) > 0) {
            $row = mysqli_fetch_assoc($data);
        }
        ?>
        <div class="form-group">
            <label>Memebership Amount</label>
            <input type="number" name="membership_amount" value="<?= $row['service_charge'] ?>" id="charge" readonly>
        </div>

        <button type="button" id="member_amount">Sign Up</button>
        
        <!-- </form> -->

        <div class="login-link">
            Already have an account? <a href="login.php">Log In</a>
        </div>

        <!-- patyment gateway included -->
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            document.querySelector("#member_amount").addEventListener("click", function() {
                // let mobile = '';
                // let amount = document.querySelector("#amount").value;
                let name = document.querySelector("#name").value;
                let email = document.querySelector("#email").value;
                let phone = document.querySelector("#phone").value;
                let state = document.querySelector("#state").value;
                let district = document.querySelector("#district").value;
                let password = document.querySelector("#password").value;
                let charge = document.querySelector("#charge").value;

                if (!name || !email || !phone || !state || !district || !password || !charge) {
                    alert("All field is required");
                    return;
                }

                // send the data in gateway
                let totalAmount = parseFloat(charge) * 100;

                let options = {
                    "key": "rzp_test_wOdC4AX16cJlLk", //your rozarpay key 
                    "amount": totalAmount,
                    "currency": "INR",
                    "name": "Instant-Online-Solution",
                    "description": "Payment for Membership balence",
                    "handler": function(response) {
                        alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);

                        // Redirect to process_payment.php with all required data
                        let wallet_data = new URLSearchParams({
                            transaction_id: response.razorpay_payment_id,
                            name: name,
                            email: email,
                            phone: phone,
                            state: state,
                            district: district,
                            password: password,
                            charge: charge,
                            payment_status: "Success"
                        }).toString();


                        window.location.href = `insert_register_data.php?${wallet_data}`;
                    },
                    "prefill": {
                        "name": name,
                        // "email": email,
                        "contact": phone
                    },
                    "theme": {
                        "color": "#3399cc"
                    }
                };

                let rzp1 = new Razorpay(options);
                rzp1.open();
            })
        </script>
    </div>
</body>

</html>