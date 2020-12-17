<?php
  if(isset($_POST['idp'])){
    try{
      $bdd=new PDO('mysql:host=localhost;dbname=sonatrach','root','');
    }
    catch(Exception $e){
      die('Erreur : '.$e->getMessage());
    }
    $req=$bdd->prepare('DELETE FROM projet WHERE idp =:idp');
    $req->execute(array('idp'=>$_POST['idp'])) or die(print_r($bdd->errorInfo()));
?>
<script> location.replace("ListeProjet.php"); </script>
<?php
  }
  else{
    echo '<br/> Informations didn\'t get received correctly from ListeProjet.php';
  }
?>
