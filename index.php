<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Data Shield</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for additional styling -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            text-align: center;
        }

        .encryption-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px; /* Limit the maximum width of the container */
            margin: 0 auto; /* Center the container horizontally */
        }

        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12 encryption-container">
                <h1 class="text-center mb-4">Simple Data Shield Prototype</h1>
                <form method="post">
                    <div class="mb-3">
                        <label for="text" class="form-label">Data: </label>
                        <input type="text" class="form-control" name="text" id="text" required>
                    </div><br>
                    <div class="mb-3">
                        <label for="key" class="form-label">Salt: </label>
                        <input type="text" class="form-control" name="key" id="key" required>
                    </div><br>
                    <div class="mb-3">
                        <label for="encryptionMethod" class="form-label">Select Encryption Method:</label>
                        <select class="form-select" id="encryptionMethod" name="encryptionMethod">
                            <option value="md5">MD5</option>
                            <option value="sha">SHA</option>
                            <option value="blowfish">Blowfish</option>
                        </select>
                    </div><br>

                    <!-- JavaScript input box for Blowfish key -->
                    <div id="blowfishInput" style="display: none;">
                        <label for="blowfishKey" class="form-label">Enter Blowfish Key:</label>
                        <input type="text" class="form-control" name="blowfishKey" id="blowfishKey">
                    </div><br>

                    <button type="submit" class="btn btn-primary btn-block">Encrypt</button>
                </form><br>
                <div id="result" class="mt-4">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        $text = $_POST["text"];
                        $key = $_POST["key"];
                        $encryptionMethod = $_POST["encryptionMethod"];
                        $result = '';

                        if ($encryptionMethod === "md5") {
                            $result = md5($text . $key);
                        } elseif ($encryptionMethod === "sha") {
                            $result = sha1($text . $key);
                        } elseif ($encryptionMethod === "blowfish") {
                            if (isset($_POST["blowfishKey"])) {
                                $blowfishKey = $_POST["blowfishKey"];
                                $result = crypt($text, '$2a$07$' . $blowfishKey . '$');
                            } else {
                                $result = "Blowfish Key is required for Blowfish encryption.";
                            }
                        }

                        echo "<p>Encrypted Result:<b> $result</b></p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and Popper.js scripts (at the end of the body) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.6/dist/umd/popper.min.js"></script>

    <!-- JavaScript to handle the input box for Blowfish key -->
    <script>
        document.getElementById("encryptionMethod").addEventListener("change", function() {
            var selectedMethod = this.value;
            var blowfishInput = document.getElementById("blowfishInput");

            if (selectedMethod === "blowfish") {
                blowfishInput.style.display = "block";
            } else {
                blowfishInput.style.display = "none";
            }
        });
    </script>
</body>
</html>
