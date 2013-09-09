<video autoplay id="tVideo"></video>
 
<script>
    function getMedia () {
        // Obtenemos el getUserMedia segun el navegador
        navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
        // Solicitamos acceso
        navigator.getUserMedia ( {
            video: true, 
            audio: true
        }, function( oMedia ) {
            // Conectamos la webcam con el <video>
            var video = document.getElementById('tVideo');
            video.src = window.URL.createObjectURL( oMedia );
        }, getMedia );
    }
    getMedia ();
</script>
<!--  Botón Grabar / Parar -->
<input type="button" id="boton" value="Grabar" onclick="GrabarOParar ()" />
<script>
 function GrabarOParar ( ) {
   // Si está grabando
   if ( grabando ) {
        // Parar de gravar y enviar por AJaX
        EnviarPorAjax ( grabando.stop () );
     // Marcar grabar a 0
        grabando = 0;
     // Volver a poner "Grabar" en el botón
     document.getElementById ('boton') . value = 'Grabar';
   } else {
      device = document.getElementsByTagName('device')[0];
      // Empezamos a grabar
      grabando = device.data.record ();
       // Ponemos "Parar" en el botón
      document.getElementById ('boton') . value = 'Parar';
   }
 }
 function EnviarPorAjax ( archivo ) {
  // Leemos el archivo
  var reader = new FileReader();
  // Creamos conexión ajax 
  reader.onload = function( binaryVideo ) { 
    // Creamos el objeto AJAX
     ajax = new XMLHttpRequest ();
    // Indicamos el scripot de upload del servidor
     ajax.open("post", "/videoupload.php", true);
     ajax.setRequestHeader("Content-Type", "multipart/form-data");
    // Enviamos el contenido del archivo de vídeo
     ajax.send( binaryVideo.target.result )
  }  
  reader.readAsBinaryString(f); 
 }
 grabando = 0;
</script>

<!--  Botón Grabar / Parar -->
<input type="button" id="boton" value="Conectar" onclick="ConectarPeer ()" />
<!--  Vídeo de un usuario remoto -->
<video id="suVideo" autoplay></video>
<script>
function ConectarPeer () {
  // Conectar a una IP
  var conexion = new ConnectionPeer(  '80.23....');
  conexion.onconnect = function (event) {
    // Enviar tu stream al otro
    conexion.addStream( document.getElementsByTagName('device')[0].data );
    // Recibir stream del otro
    conexion.onstream = function (event) {
       document.getElementById ('suVideo').src = conexion.remoteStreams[0].URL;
    }
  }
  // Conducimos el error
  conexion.onerror = function ( event ) {
    alert ( 'Imposible conectar con el usuario' );
  }
}
</script>