<?php include "header.php"; ?>
<?php include "barra.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Metas 2019 - 2029</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<br>

<div class="container">
    <h2>Metas 2019 - 2029</h2>
    <br>
    <div class="container-fluid">
        <br>
        <h3>Sticky Navbar</h3>
        <p>A sticky navigation bar stays fixed at the top of the page when you scroll past it.</p>
        <p>Scroll this page to see the effect. <strong>Note:</strong> sticky-top does not work in IE11 and earlier.</p>
    </div>
    <!-- Nav tabs -->
    <nav class="navbar navbar-expand-sm sticky-top">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home">Meta 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1">Meta 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">Meta 3</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-toggle="tab" href="#home">Meta 4</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1">Meta 5</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">Meta 6</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " data-toggle="tab" href="#home">Meta 7</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1">Meta 8</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">Meta 9</a>
        </li>

    </ul>
    </nav>

    <!-- Tab panes -->
    <div class="tab-content container-fluid">
        <div id="home" class="container tab-pane active"><br>
            <h3>HOME</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.</p>
            <p>grafico de estatus</p>
            <nav class="navbar navbar-expand-sm sticky-top">
                <ul class="nav nav-tabs" role="tablist2">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#hom">Objetivo 1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu1">Objetivo 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">Objetivo 3</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="menu1" class="container tab-pane fade"><br>
            <h3>Menu 1</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="menu2" class="container tab-pane fade"><br>
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam
                rem aperiam.</p>
        </div>
        <div id="hom" class="container tab-pane fade"><br>
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam
                rem aperiam.</p>
        </div>
    </div>
</div>

</body>
</html></html>