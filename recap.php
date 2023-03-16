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

    <title>Récapitulatif des produits</title>

</head>

<body>

<?php

    // Rajout d'une condition qui vérifie :
    // soit la clé "products" du tableau de session $_SESSION n'existe pas : "!isset()"
    // soit cette clé existe mais ne contient aucune donnée : empty()
    // Dans ces 2 cas nous afficherons à l'utilisateur un message le prévenant qu'aucun produit n'existe en session.

    if (!isset($_SESSION['products']) || empty($_SESSION['products'])){
        echo "<p>Aucun produit en session ...</p>";

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
     
            
        
        echo "<tr>",
                "<td colspan=4>Total général : </td>",
                "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</strong></td>",
            "</tr>",   
        "</tbody>",
        "</table>";
        
    }

?>

</body>
</html>