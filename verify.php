<?php
session_start();
include 'connect.php';

$message = '';
$email = $_SESSION['pending_email'] ?? '';
$displayCode = $_SESSION['verification_code'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $code = trim($_POST['code']);

    if (empty($email) || empty($code)) {
        $message = 'Please enter both email and verification code.';
    } else {
        $stmt = $conn->prepare('SELECT is_verified, verification_code FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $message = 'No account found for that email.';
        } else {
            $row = $result->fetch_assoc();
            if ($row['is_verified']) {
                $_SESSION['email'] = $email;
                unset($_SESSION['pending_email'], $_SESSION['verification_code']);
                header('Location: homepage.php');
                exit();
            }

            if ($row['verification_code'] === $code) {
                $update = $conn->prepare('UPDATE users SET is_verified = 1, verification_code = NULL WHERE email = ?');
                $update->bind_param('s', $email);
                $update->execute();

                $_SESSION['email'] = $email;
                unset($_SESSION['pending_email'], $_SESSION['verification_code']);
                header('Location: homepage.php');
                exit();
            }

            $message = 'Invalid verification code. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="verification-container">
        <h1>Account Verification</h1>
        <p>Enter the verification code for your Fuelpump account.</p>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if (!empty($displayCode)): ?>
            <p class="social-note">For this demo, your verification code is <strong><?php echo htmlspecialchars($displayCode); ?></strong>.</p>
        <?php endif; ?>
        <form method="post" action="verify.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Email" required value="<?php echo htmlspecialchars($email); ?>">
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <i class="fas fa-key"></i>
                <input type="text" name="code" id="code" placeholder="Verification Code" required>
                <label for="code">Verification Code</label>
            </div>
            <input type="submit" class="btn" value="Verify Account">
        </form>
        <div class="links">
            <p>Already verified?</p>
            <button onclick="window.location.href='index.php'">Back to Login</button>
        </div>
    </div>
</body>
</html>
