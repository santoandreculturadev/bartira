<?php include "header.php"; ?>

<body>

  <?php include "menu/me_inicio.php"; ?>
  
  <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
    <h1>Ambiente teste Mapas</h1>
    <?php 
//Carrega MapasSDK
    require "MapasSDK/vendor/autoload.php";

    $url_mapas = $GLOBALS['url_mapas'];
    $chave01 = $GLOBALS['chave01'];
    $chave02 = $GLOBALS['chave02'];
    $chave03 = $GLOBALS['chave03'];

    $mapas = new MapasSDK\MapasSDK(
      $url_mapas,
      $chave01,
      $chave02,
      $chave03
    );

    $evento = evento($_GET['id']);

    $new_event = $mapas->createEntity('event', [

      'name' => $evento['titulo'],
      'shortDescription' => substr($evento['sinopse'], 0, 400),
      'longDescription' => $evento['release'],
      'terms' => [
        'linguagem' => ['Música Popular']

      ],
      'classificacaoEtaria' => '18 anos'
    ]);

    $new_event = converterObjParaArray($new_event);

    echo $new_event['id'];

// acontecendo uma única vez no dia 28 de Setembro de 2017 às 12:00 com duração de 120min e preço Gratuíto
    $oc = $evento['mapas']['ocorrencia'];

    echo "<pre>";
    var_dump($oc);
    echo "</pre>";

    for($i = 0; $i < count($oc); $i++){
      $occurrence = $mapas->apiPost('eventOccurrence/create',[
        'eventId' => $new_event['id'],
        'spaceId' => $oc[$i]['spaceId'],
        'startsAt' => $oc[$i]['startsAt'],
        'duration' => $oc[$i]['duration'],
    // 'endsAt' => '14:00',
        'frequency' => $oc[$i]['frequency'],
        'startsOn' => $oc[$i]['startsOn'],
        'until' => '',
        'description' => $oc[$i]['description'],
        'price' => $oc[$i]['price']
      ]);


    }
    echo "<pre>";
    var_dump($occurrence);
    echo "</pre>";
    ?>
  </main>
</div>
</div>

<?php 
include "footer.php";
?>