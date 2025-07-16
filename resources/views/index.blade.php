<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light p-5">

<div class="container">
    <h2 class="mb-4">Product Entry Form</h2>

    <form id="productForm" class="row g-3">
        <div class="col-md-4">
            <input type="text" class="form-control" name="product_name" placeholder="Product Name" required>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control" name="quantity" placeholder="Quantity in Stock" required>
        </div>
        <div class="col-md-3">
            <input type="number" step="0.01" class="form-control" name="price" placeholder="Price per Item" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>

    <hr class="my-4">

    <h4>Submitted Products</h4>
    <table class="table table-bordered table-striped" id="productsTable">
        <thead class="table-dark">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Submitted At</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr class="table-secondary">
                <td colspan="4" class="text-end fw-bold">Total Sum</td>
                <td id="totalSum" class="fw-bold">$0.00</td>
            </tr>
        </tfoot>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadProducts() {
        $.get('/products', function (res) {
            console.log(res);
            let rows = '';
            let totalSum = 0;

            res.data.sort((a, b) => new Date(b.datetime) - new Date(a.datetime));

            res.data.forEach(item => {
                rows += `<tr>
                    <td>${item.product_name}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>${item.datetime}</td>
                    <td>$${item.total.toFixed(2)}</td>
                </tr>`;
                totalSum += item.total;
            });

            $('#productsTable tbody').html(rows);
            $('#totalSum').text(`$${totalSum.toFixed(2)}`);
        });
    }

    $('#productForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post({
            url: '/products',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $('#productForm')[0].reset();
                loadProducts();
            }
        });
    });
    loadProducts();
</script>

</body>
</html>
