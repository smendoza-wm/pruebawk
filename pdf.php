<?php
    $nombrePDF = "mipdf.pdf";
    if(isset($_POST['head']) && isset( $_POST['div'])){
        if(!empty($_POST['head'] && !empty($_POST['div']))){

            $div = $_POST['div'];
            $head = $_POST['head'];
            $nomPag = "paginaTmp.html";
            
            $pathWK = "C:\Program Files\wkhtmltopdf\bin";
            $tamPagina = "Letter";
            $urlOrigen = "http://localhost/pruebawk/".$nomPag;
            $urlDestino = 'C:\\xampp3\\htdocs\\pruebawk\\';
            $nombrePDF = "mipdf.pdf";
            $delay = "4000";
            
            crearPaginaTmp($nomPag, $head, $div);
            crearPDF($pathWK, $tamPagina, $urlOrigen, $urlDestino, $nombrePDF, $delay);
        }
        else{
            //El head o el div de la pagina estan vacios
        }          
    }
    
    if(isset($_GET['descarga'])){
        $file = $nombrePDF;
        header("Content-disposition: attachment; filename=$file");
        header("Content-type: application/octet-stream");
        readfile($file);
    }
    
    function crearPaginaTmp($nomPag,$head, $div){
        $myfile = fopen($nomPag, "w") or die("Unable to open file!");
        $txt = "<html><head>";
        $txt .= $head."</head>";
        fwrite($myfile, $txt);
    
        $txt = "<body>";
        $txt .= $div;
        $txt .= "</body></html>";
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    
    function crearPDF($pathWK, $tamPagina, $urlOrigen, $urlDestino, $nombrePDF, $delay){
        chdir($pathWK); 
        $tamPagina = '--page-size '.$tamPagina;
        $cmd_delay = '--no-stop-slow-scripts --javascript-delay ';
        
        $comando = 'wkhtmltopdf '.$tamPagina.' ';
        if( $delay !='' ){
            $comando .= $cmd_delay .' '.$delay;
        }
        
        $comando .= ' '.$urlOrigen.' '.$urlDestino.$nombrePDF;
        echo $comando;
        shell_exec($comando);
    }