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

        <form method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter name">
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" id="price" name="price"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter price">
            </div>
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <input type="text" id="category_id" name="category_id"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter category">
            </div>
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="text" id="image_url" name="image_url"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter image URL">
            </div>
            <button type="submit" onclick="createProduct()"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Submit
            </button>
        </form>

        <?php
        // Lấy dữ liệu từ API
        $response = @file_get_contents('http://localhost:8080/api/products');
        if ($response === false) {
            echo "<p class='text-red-500'>Không thể lấy dữ liệu từ API. Vui lòng thử lại sau.</p>";
        } else {
            $data = json_decode($response, true);

            if (is_array($data)) {
                echo "<p class='text-green-600 font-bold mb-4'>Dữ liệu đã được lấy thành công.</p>";
        ?>
        <table class="table-auto border-collapse border border-gray-300 w-full text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Price</th>
                    <th class="border border-gray-300 px-4 py-2">Category</th>
                    <th class="border border-gray-300 px-4 py-2">Image</th>
                    <th class="border border-gray-300 px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row) { ?>
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-300 px-4 py-2"><?php echo $row['id']; ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo $row['name']; ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo $row['price']; ?></td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo $row['category_id']; ?>
                    </td>
                    <td class="border border-gray-300 px-4 py-2"><?php echo $row['image_url']; ?></td>
                    <td>
                        <a href="../views/Update.php?id=<?php echo $row['id']; ?>"
                            class="text-blue-500 hover:underline">Sửa</a>
                        <button onclick="deleteProduct(<?php echo $row['id']; ?>)"
                            class="text-red-500 hover:underline">Xóa</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
            } else {
                echo "<p class='text-red-500'>Dữ liệu trả về từ API không hợp lệ.</p>";
            }
        }
        ?>
    </div>


    <!-- Create -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $url = "http://localhost:8080/api/products/create";

        $data = [
            "name" => $_POST['name'] ?? "",
            "price" => $_POST['price'] ?? "",
            "category_id" => $_POST['category_id'] ?? "",
            "image_url" => $_POST['image_url'] ?? "",
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
            echo "<p class='text-red-500'>Không thể kết nối đến API. Vui lòng thử lại sau.</p>";
        } else {
            $result = json_decode($response, true);
            echo "<p class='text-green-600 font-bold mb-4'>Dữ liệu đã được gửi thành công.</p>";
        }
    }
    ?>
    <!-- End Create -->

</body>

<script>
async function deleteProduct(id) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
        window.location.href = "?id=" + id;

        await fetch("http://localhost:8080/api/products/" + id, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            }
        }).then(response => {
            if (response.ok) {
                alert("Sản phẩm đã được xóa thành công.");
                window.location.reload();
            } else {
                alert("Có lỗi xảy ra khi xóa sản phẩm.");
            }
        })
    }
}

async function createProduct() {
    setTimeout(() => {
        window.location.onload();
    }, 3000);
}
</script>

</html>