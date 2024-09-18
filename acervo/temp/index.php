<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>APP Oracle <> Tainacan - v0.1 - 2022</title>


        <!-- Última versão CSS compilada e minificada -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Tema opcional -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Última versão JavaScript compilada e minificada -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>

    <body>
    <?php

    switch($_GET['pag']){

    case "atualiza_casa":
        $api_response = wp_remote_post( 'https://WEBSITE/wp-json/wp/v2/posts', array(
            'headers' => array(
               'Authorization' => 'Basic ' . base64_encode( 'myapp:W4IG SwCs vhjT vwpC 2U4t znsi' )
           ),
           'body' => array(
                   'title'   => 'My test',
               'status'  => 'draft', // ok, we do not want to publish it immediately
               'content' => 'lalala',
               'categories' => 5, // category ID
               'tags' => '1,4,23' // string, comma separated
               'date' => '2015-05-05T10:00:00', // YYYY-MM-DDTHH:MM:SS
               'excerpt' => 'Read this awesome post',
               'password' => '12$45',
               'slug' => 'new-test-post' // part of the URL usually
               // more body params are here:
               // developer.wordpress.org/rest-api/reference/posts/#create-a-post
           )
       ) );
       
       $body = json_decode( $api_response['body'] );
       
       // you can always print_r to look what is inside
       // print_r( $body ); // or print_r( $api_response );
       
       if( wp_remote_retrieve_response_message( $api_response ) === 'Created' ) {
           echo 'The post ' . $body->title->rendered . ' has been created successfully';
       }

    break;

    case "atualiza_museu":
        
    break;
        


    default: // página inicial

    break;


    } // fim do switch pag





    ?>



    </body>
</html>