<?php include "header.php"; ?>

<body>
	
	<?php //include "menu/me_inicio.php"; ?>
	
	<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
		<h1>Ambiente teste / Importar Plano Municipal</h1>

	<?php 
	
	


// include the autoloader, so we can use PhpSpreadsheet
require_once(__DIR__ . '/vendor/autoload.php');

# Create a new Xls Reader
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();

// Tell the reader to only read the data. Ignore formatting etc.
$reader->setReadDataOnly(true);

// Read the spreadsheet file.
$spreadsheet = $reader->load(__DIR__ . '\uploads\poetas.xls');

$sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
$data = $sheet->toArray();

// output the data to the console, so you can see what there is.
echo "<pre>";
var_dump($data);
echo "</pre>";

?>

	</main>

	
	<?php 
	include "footer.php";
	?>