<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <a href="../views/Login.php" class="text-blue-500 hover:underline"> >Đăng nhập</a>

        <?php
        $response = file_get_contents('http://localhost:8080/api/accounts');
        $data = json_decode($response, true);

        if (is_array($data)) {
            echo "<p class='text-green-600 font-bold mb-4'>Dữ liệu đã được lấy thành công.</p>";
        ?>
            <table class="table-auto border-collapse border border-gray-300 w-full text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Username</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $row) {
                    ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['id']; ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['username']; ?>
                            </td>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $row['email']; ?></td>
                        </tr>
                    <?php

                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "<p class='text-red-600 font-bold'>Không thể lấy dữ liệu từ API.</p>";
        }
        ?>
    </div>
</body>

</html>