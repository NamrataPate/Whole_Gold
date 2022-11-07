<?php
include('conn.php');
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="database/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-json/2.6.0/jquery.json.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://kit.fontawesome.com/280cb748a7.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-json/2.6.0/jquery.json.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/b-2.2.3/b-html5-2.2.3/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/b-2.2.3/b-html5-2.2.3/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
    <title>wholeGold</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" style="border: 1px solid white;" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="height:20px;">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Master
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?party_panel" target="_blank">Party panel</a></li>
                            <li><a class="dropdown-item" href="index.php?product_panel" target="_blank">Product panel</a></li>
                            <li><a class="dropdown-item" href="index.php?user_panel" target="_blank">User panel</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Transaction
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?purchase_panel" target="_blank">Purchase</a></li>
                            <li><a class="dropdown-item" href="index.php?sale_panel" target="_blank">Sale</a></li>
                            <li><a class="dropdown-item" href="index.php?cashtransaction" target="_blank">Ca/Jo/Bh.Entry</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Report
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?sale_report" target="_blank">Sale Report</a></li>
                            <li><a class="dropdown-item" href="index.php?purchase_report" target="_blank">Purchase Report</a></li>
                            <li><a class="dropdown-item" href="index.php?stock_report" target="_blank">Stock Position</a></li>
                            <li><a class="dropdown-item" href="index.php?day_book" target="_blank">Day book</a></li>
                            <li><a class="dropdown-item" href="index.php?cash_book" target="_blank">Cash book</a></li>
                            <li><a class="dropdown-item" href="index.php?codewise_stock" target="_blank">Code wise stock</a></li>
                            <li><a class="dropdown-item" href="index.php?party_balance" target="_blank">Party balance report</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Query
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?party_tranctaion" target="_blank">Party Transaction</a></li>
                            <li><a class="dropdown-item" href="index.php?expenses_transaction" target="_blank">Expenses Transaction</a></li>
                            <li><a class="dropdown-item" href="index.php?cashlist" target="_blank">Cash Transaction</a></li>
                            <li><a class="dropdown-item" href="index.php?journallist" target="_blank">Journal Transaction</a></li>
                            <li><a class="dropdown-item" href="index.php?bhaawlist" target="_blank">Bhaaw Transaction</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            System
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex">
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#">Date: <?php echo date("d-m-Y"); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="#" id="time"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

    <script></script>
</body>
<?php
if (isset($_GET['party_panel'])) {
    include 'party_panel.php';
}

if (isset($_GET['product_panel'])) {
    include 'product_panel.php';
}

if (isset($_GET['user_panel'])) {
    include 'user_panel.php';
}
if (isset($_GET['purchase_panel'])) {
    include 'purchase_panel.php';
}

if (isset($_GET['sale_panel'])) {
    include 'sale_panel.php';
}

if (isset($_GET['cashtransaction'])) {
    include 'cashtransaction.php';
}

if (isset($_GET['journaltransaction'])) {
    include 'journaltransaction.php';
}

if (isset($_GET['bhaawtransaction'])) {
    include 'bhaawtransaction.php';
}
if (isset($_GET['sale_report'])) {
    include 'sale_report.php';
}
if (isset($_GET['edit_sale'])) {
    include 'edit_sale.php';
}
if (isset($_GET['purchase_report'])) {
    include 'purchase_report.php';
}
if (isset($_GET['edit_purchase'])) {
    include 'edit_purchase.php';
}
if (isset($_GET['stock_report'])) {
    include 'stock_report.php';
}
if (isset($_GET['codewise_detail'])) {
    include 'codewise_detail.php';
}
if (isset($_GET['day_book'])) {
    include 'day_book.php';
}
if (isset($_GET['transaction_filter'])) {
    include 'transaction_filter.php';
}
if (isset($_GET['cash_book'])) {
    include 'cash_book.php';
}
if (isset($_GET['codewise_stock'])) {
    include 'codewise_stock.php';
}
if (isset($_GET['party_balance'])){
    include 'party_balance.php';
}
if(isset($_GET['party_tranctaion'])){
    include 'party_tranctaion.php';
}
if(isset($_GET['expenses_transaction'])){
    include 'expenses_transaction.php';
}
if(isset($_GET['cashlist'])){
    include 'cashlist.php';
}
if (isset($_GET['edit_cashtransaction'])){
    include 'edit_cashtransaction.php';
}
if (isset($_GET['journallist'])){
    include 'journallist.php';
}
if (isset($_GET['bhaawlist'])){
    include 'bhaawlist.php';
}
if(isset($_GET['edit_bhaawtransaction'])){
    include 'edit_bhaawtransaction.php';
}
?>

<script>
    const element = document.getElementById("time");
    setInterval(function() {
        var d = new Date();
        element.innerHTML = 'Time: ' + d.toLocaleTimeString();
    }, 1000);
</script>

</html>