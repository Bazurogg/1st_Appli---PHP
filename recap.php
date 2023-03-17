<?php
// recap.php permet d'afficher de manière organisée et exhaustive la liste des produits présents en session et présente le total de l'ensemble de ceux-ci
    session_start(); // A la différence d'index.php il sera nécessaire de parcourir le tableau de session d'où l'appel de la session_start() au début de fichier pour récupérer la session correspondante à l'utilisateur.
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel=stylesheet href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">    <title>Récapitulatif des produits</title>

</head>

<body>
<div class="maincontent">

    <nav>
        <ul style="list-style: none;">
            <li><a href="./index.php">Ajouter Produit</a></li>
            <li><a class="active" href="./recap.php">Recap</a></li>
        </ul>
    </nav>

</div>

<div class="tableprod">
    
<?php

    // Rajout d'une condition qui vérifie :
    // soit la clé "products" du tableau de session $_SESSION n'existe pas : "!isset()"
    // soit cette clé existe mais ne contient aucune donnée : empty()
    // Dans ces 2 cas nous afficherons à l'utilisateur un message le prévenant qu'aucun produit n'existe en session.

    if (!isset($_SESSION['products']) || empty($_SESSION['products'])){
        echo "<strong><p>Aucun produit en session ...</p></strong>";

    } else {

        

        echo "<table>",
                "<thead>",
                    "<tr>",
                        "<th>#</th>",
                        "<th>Nom</th>",
                        "<th>Prix</th>",
                        "<th>Quantité</th>",
                        "<th>Total</th>",
                    "</tr>",
                "</thead>",
                "<tbody>";      
                
        $totalGeneral = 0;

        foreach($_SESSION['products'] as $index => $product){
        

            // $index valeur de l'index du tableau $_SESSION['products'] chaque produit sera numéroter par cette valeur dans le tableau HTML

            // $products variable qui contient le produit sous forme de tableau tel que l'a créé et stocké en session "traitement.php"
            
            echo "<tr>",                        
                    "<td>".$index."</td>",
                    "<td>".$product['name']."</td>",
                    "<td>".number_format($product['price'], 2,",", "&nbsp;")."&nbsp;€</td>",
                    "<td>".$product['qtt']."</td>",
                    "<td>".number_format($product['total'], 2,",", "&nbsp;")."&nbsp;€</td>",
                "</tr>";    
                        
                        
                        
            
            $totalGeneral += $product['total'];

        
            
            
        }
        
        echo "<p>".$product['qtt']." <-- ça c'est la quantité du dernier produits donc si c'est là ..."."</p>";
        
        echo "<tr>",
                "<td colspan=4>Total général : </td>",
                "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</strong></td>",
            "</tr>",
        "</tbody>",
        "</table>";

        
        
    }


?>
</div>

</body>
</html>