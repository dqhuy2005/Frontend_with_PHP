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

            <div hidden>
                <label for="id" class="block text-sm font-medium text-gray-700">id</label>
                <input type="text" id="id" name="id"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter id">
            </div>


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

            <div class="flex flex-col space-y-2">
                <button type="button" onclick="createProduct()"
                    class="w-full bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Create
                </button>

                <button type="button" onclick="updateProduct()"
                    class="w-full bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Update
                </button>
            </div>
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
                                    <button onclick="editProduct(<?php echo $row['id']; ?>)"
                                        class="text-blue-500 hover:underline">Edit</button>
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
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $url = "http://localhost:8080/api/products/create";

    //     $data = [
    //         "name" => $_POST['name'] ?? "",
    //         "price" => $_POST['price'] ?? "",
    //         "category_id" => $_POST['category_id'] ?? "",
    //         "image_url" => $_POST['image_url'] ?? "",
    //     ];

    //     $options = [
    //         "http" => [
    //             "header"  => "Content-Type: application/json",
    //             "method"  => "POST",
    //             "content" => json_encode($data)
    //         ]
    //     ];

    //     $context = stream_context_create($options);
    //     $response = @file_get_contents($url, false, $context);

    //     if ($response === false) {
    //         echo "<p class='text-red-500'>Không thể kết nối đến API. Vui lòng thử lại sau.</p>";
    //     } else {
    //         $result = json_decode($response, true);
    //         echo "<p class='text-green-600 font-bold mb-4'>Dữ liệu đã được gửi thành công.</p>";
    //     }
    // }
    ?>
    <!-- End Create -->
</body>

<script>
    async function createProduct() {
        // Off id value
        document.getElementById("id").value = "";

        const name = document.getElementById("name").value;
        const price = document.getElementById("price").value;
        const category_id = document.getElementById("category_id").value;
        const image_url = document.getElementById("image_url").value;

        if (!name || !price || !category_id || !image_url) {
            alert("Vui lòng điền đầy đủ thông tin.");
            return;
        }

        const data = {
            name,
            price,
            category_id,
            image_url
        };

        await fetch("http://localhost:8080/api/products/create", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        }).then(response => {
            if (response.ok) {
                alert("Sản phẩm đã được tạo thành công.");
                window.location.reload();
            } else {
                alert("Có lỗi xảy ra khi tạo sản phẩm.");
            }
        }).catch(error => {
            console.error('Error:', error);
            alert("API tạo sản phẩm lỗi: " + error);
        });
    }

    // Start delete
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
            }).catch(error => {
                console.error('Error:', error);
                alert("Có lỗi xảy ra khi xóa sản phẩm.");
            });
        }
    }
    // End delete


    async function editProduct(id) {
        const data = await fetch("http://localhost:8080/api/products/" + id)
            .then(response => response.json())
            .catch(error => console.error('Error:', error));

        console.log(data);

        if (!data) {
            alert("Không thể lấy thông tin sản phẩm.");
            return;
        }

        const product = data[0];

        const {
            name,
            price,
            category_id,
            image_url
        } = product;

        document.getElementById("id").value = id;
        document.getElementById("name").value = name;
        document.getElementById("price").value = price;
        document.getElementById("category_id").value = category_id;
        document.getElementById("image_url").value = image_url;
    }

    async function updateProduct() {
        const id = document.getElementById("id").value;
        const name = document.getElementById("name").value;
        const price = document.getElementById("price").value;
        const category_id = document.getElementById("category_id").value;
        const image_url = document.getElementById("image_url").value;

        const data = {
            id,
            name,
            price,
            category_id,
            image_url
        };

        await fetch("http://localhost:8080/api/products/" + id, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        }).then(response => {
            if (response.ok) {
                alert("Sản phẩm đã được cập nhật thành công.");
                window.location.reload();
            } else {
                alert("Có lỗi xảy ra khi cập nhật sản phẩm.");
            }
        }).catch(error => {
            console.error('Error:', error);
            alert("Có lỗi xảy ra khi cập nhật sản phẩm.");
        });

    }
</script>

</html>