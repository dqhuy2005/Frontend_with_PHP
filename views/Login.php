    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đăng nhập</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Đăng nhập</h1>
            <form method="POST" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Đăng nhập
                </button>
            </form>
            <p class="mt-4 text-sm text-center text-gray-600">
                Chưa có tài khoản? <a href="/views/Register.php" class="text-blue-500 hover:underline">Đăng ký</a>
            </p>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url = "http://localhost:8080/api/auth/login";

            $data = [
                "username" => $_POST['username'] ?? "",
                "password" => $_POST['password'] ?? "",
            ];

            $options = [
                "http" => [
                    "header"  => "Content-Type: application/json",
                    "method"  => "POST",
                    "content" => json_encode($data)
                ]
            ];

            $context = stream_context_create($options);
            $response = @file_get_contents($url, false, $context);

            if ($response === false) {
                echo "<pre>";
                echo $response;
                echo "</pre>";
                echo "<p class='text-red-500'>Không thể kết nối đến API.</p>";
            } else {
                $data = json_decode($response, true);
                echo "<pre>";
                print_r($data);
                echo "</pre>";
                header("Location: /public/index.php");
            }
        }
        ?>
    </body>

    </html>