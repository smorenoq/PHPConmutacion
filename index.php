<?php session_start(); ?>
<!DOCTYPE html>

<html>
  <head>
      <!-- Título -->
      <h1>Control de Intersección de Semáforo</h1>
      <!-- CSS -->
      <style>
      h1 /*Para los h1*/
      {
        font:  bold Times; /*Negrilla, letra Times*/
      }
      button /*Para los botones*/
      {
        font: bold 16px Arial; /*Negrilla, tamaño 16, letra Arial*/
        background-color: rgb(0,70,124); /*Color de fondo*/
        color: rgb(255,255,255); /*Color del texto*/
        padding: 6px 18px 6px 18px; /*Margen entre el texto del botón y sus bordes*/
        margin-top: 6px; /*Margen superior por fuera de los bordes*/
        margin-right: 3px; /*Margen a la derecha por fuera de los bordes*/
        border-top: 1px solid #000; /*Color negro para el borde superior*/
        border-right: 1px solid #000; /*Color negro para el borde derecho*/
        border-bottom: 1px solid #000; /*Color negro para el borde inferior*/
        border-left: 1px solid #000; /*Color negro para el borde izquierdo*/
      }
      </style>
  </head>

  <img src = "semaforo.gif" align = "right" width = "400" height = "500">

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   Ingresar Duración Semáforo 1: <input type="text" name="dur1"><br><br>
    <input type="submit" Value = "Ingresar">
  </form>

  <br>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
   Ingresar Duración Semáforo 2: <input type="text" name="dur2"><br><br>
    <input type="submit" Value = "Ingresar">
   </form>

   <br>

  <?php
    $dur1 = 10;
    $dur2 = 10;
     
    if (isset($_POST["dur1"])) $_SESSION["dur1"] = $_POST["dur1"];
     
    echo "Duración actual Semáforo 1: " . $_SESSION["dur1"];

    if (isset($_POST["dur2"])) $_SESSION["dur2"] = $_POST["dur2"];

    echo nl2br("\n\nDuración actual Semáforo 2: " . $_SESSION["dur2"]);


    if ($_SESSION["dur1"] != $dur1 || $_SESSION["dur2"] != $dur2)
    {
        cambiarDuraciones($dur1, $dur2);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['empezar']))
    {
        funcionamiento($dur1, $dur2);
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cambiar']))
    {
       cambiarSemaforo();
    }

    shell_exec("node apagar");

    //Variables Globales
    $verde1prendido = True;
    $verde2prendido = False;
    $interrumpir = False;
    
    if (isset($_SESSION["dur1"]))
    {
        $dur1 = $_SESSION["dur1"];
    }

    if (isset($_SESSION["dur2"]))
    {
        $dur2 = $_SESSION["dur2"];
    }
 

    //Funciones


    function prenderVerde1()
    {
      shell_exec("node prenderVerde1");
    }

    function prenderAmarillo1()
    {
      shell_exec("node prenderAmarillo1");
    }

    function prenderRojo1()
    {
      shell_exec("node prenderRojo1");
    }

    function apagarVerde1()
    {
      shell_exec("node apagarVerde1");
    }

    function apagarAmarillo1()
    {
      shell_exec("node apagarAmarillo1");
    }

    function apagarRojo1()
    {
      shell_exec("node apagarRojo1");
    }

    function prenderVerde2()
    {
      shell_exec("node prenderVerde2");
    }

    function prenderAmarillo2()
    {
      shell_exec("node prenderAmarillo2");
    }

    function prenderRojo2()
    {
      shell_exec("node prenderRojo2");
    }

    function apagarVerde2()
    {
      shell_exec("node apagarVerde2");
    }

    function apagarAmarillo2()
    {
      shell_exec("node apagarAmarillo2");
    }

    function apagarRojo2()
    {
      shell_exec("node apagarRojo2");
    }

    function titilarVerde1($t = 0.85)
    {
        for ($i = 1; $i <= 5; $i++)
        {
	    apagarVerde1();
	    sleep($t);
	    prenderVerde1();
	    sleep($t);
            apagarVerde1();
       }
			
    }

    function titilarVerde2($t = 0.85)
    {
        for ($i = 1; $i <= 5; $i++)
        {
	    apagarVerde2();
	    sleep($t);
	    prenderVerde2();
	    sleep($t);
            apagarVerde1();
	}
			
    }

    function cambiarSemaforo()
    {
        global $verde1prendido;
        global $verde2prendido;
	global $interrumpir;

        $interrumpir = True;
			  
        if ($verde1prendido)
        {
			  
            //Proceso de poner en rojo el Semáforo 1
            titilarVerde1();
            prenderAmarillo1();
            sleep(2);
            apagarAmarillo1();
            prenderRojo1();
            sleep(1);

            //Proceso de poner en verde el Semáforo 2
            apagarRojo2();
            prenderVerde2();
			  
        }
        else
        {
			  
            //Proceso de poner en rojo el Semáforo 1
	    titilarVerde2();
            prenderAmarillo2();
            sleep(2);
            apagarAmarillo2();
            prenderRojo2();
            sleep(1);

            //Proceso de poner en verde el Semáforo 2
            apagarRojo1();
            prenderVerde1();

        }

        $interrumpir = False;
        //funcionamiento($d1, $d2);
    }

    function cambiarDuraciones($d1, $d2)
    {
        global $interrumpir;
        
        $interrumpir = True;
        $interrumpir = False;
        //funcionamiento($d1, $d2);
    }
		  
    function funcionamiento($d1, $d2)
    {
        global $verde1prendido;
        global $verde2prendido;

        if (!$interrumpir)
	{
            if ($verde1prendido)
	    {
	        prenderVerde1();
		apagarAmarillo1();
		apagarRojo1();

		prenderRojo2();
		apagarAmarillo2();
		apagarVerde2();
		sleep($dur1);
		cambiarSemaforo();

		$verde1prendido = False;
		$verde2prendido = True;
		
	    }
	    else
	    {
	        prenderVerde2();
		apagarAmarillo2();
		apagarRojo2();

		prenderRojo1();
		apagarAmarillo1();
		apagarVerde1();
		sleep($dur2);
		cambiarSemaforo();

		$verde2prendido = False;
		$verde1prendido = True;
            }
        }
    }
			     


   ?>
    <br><br>

    <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="submit" value = "Empezar" name = "empezar">
    </form>

    <br><br>
			       

    <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="submit" value = "Cambiar Semáforo" name = "cambiar">
    </form>
   
  
  <body>

      <p id="dur_sem1"></p>
      <p id="dur_sem2"></p>

      <p></p>

      <!-- Botón de cambiar semáforo-->
     <!-- <button type="button" onclick="cambiarSemaforo()">Cambiar Semaforo</button> -->

      <!-- Javascript -->
      <script>
	//Función para cambiar el semáforo
	function cambiarSemaforo()
	{
	  
	}
	

      </script>
  </body>
</html>
