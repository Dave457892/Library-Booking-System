<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Front Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <main>
        <section class="hero">
            <h2>Welcome to Library Booking!</h2>
            <p>We are excited to have you here. Explore our website to learn more about what we offer.</p>
            <a href="login.php" class="cta-button">Login</a>
        </section>

    </main>

    <footer>
        <p>&copy; 2025 Library. All rights reserved.</p>
    </footer>

    <style>

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-image: url('arar.gif');
    background-size: cover;
    background-position: center center;
    background-attachment: fixed;
}

.hero {
    background-color: rgba(128, 128, 128, 0.7);
    color: white;
    text-align: center;
    padding: 50px 0;
    margin-top: 100px;
    border-radius: 25%;
}

.hero h2 {
    font-size: 2.5em;
}

.hero p {
    font-size: 1.2em;
    margin-top: 10px;
}

.cta-button {
    background-color: blue;
    padding: 10px 20px;
    color: white;
    text-decoration: none;
    font-weight: bold;
    margin-top: 20px;
    display: inline-block;
    border-radius: 10px;
}

.cta-button:hover {
    background-color: #87CEEB;
}

footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
}


</style>

</body>
</html>
