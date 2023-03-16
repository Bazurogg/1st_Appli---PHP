
<?php

// limiter l'accés à "traitement.php"
// Vérification de l'existence de la clé "submit" dans le tableau $_POST
// Correspondant à l'attribut "name" du bouton du formulaire
// La condition est alors vraie seulement si la requête POST transmet bien une clé "submit" au serveur

    session_start();

    if(isset($_POST['submit'])){

        // Vérification de l'intégrité des valeurs transmises dans le tableau $_POST en fonction de celles attendue réellement.

        // "filter_input()" fonction php effectue une validation ou nettoyage de chaque donnée transmise par le formulaire  via divers filtres


        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        // supprime une chaîne de caractères de toute présence de caractères spéciaux et de toute balise HTML (PAS D'INJECTION DE CODE HTML POSSIBLE)

        $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        // valide le prix uniquement si celui ci est un nombre à virgule
        // On ajoute le drapeau "FILTER_FLAG_..." pour autorisé les caractères "," ou "." pour la décimale

        $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);
        // Ne valide la quantité que si celle-ci est un nombre entier au moins égale à 1

        // En cas de succès la valeur assainie correspondant à la valeur traité est renvoyée.
        // "false" si le filtre échoue ou "null" si le champ sollicité par le nettoyage n'existe pas dans la requête POST
        // Pas de risque 
        
        if($name && $price && $qtt){

            $product = [
                "name" => $name,
                "price" => $price,
                "qtt" => $qtt,
                "total" => $price*$qtt
            ];

            $_SESSION['products'][] = $product; // on sollicite le tableau de session $_SESSION fourni par PHP

            // on indique la clé "products" de ce tableau. Si cette clé n'existais pas auparavant (ex: ajouts par l'utilisateur de son tout 1er produit) elle est créée au sein de $_SESSSION par PHP.

            // "[]" raccourci pour indiquer à cet emplacement que nous ajoutons une nouvelle entrée au futur tableau "products" associé  à cette clé.

            // $_SESSION["products"] doit être un tableau lui aussi afin d'y stocker de nouveaux produits.
        }


    }

    header("Location:index.php"); // Redirection vers le formulaire
    // Pas de else à la condition puisque nous souhaitons le retour aprés le traitement que le formulaire ai été soumis ou non.

    // Elle n'arrête pas l'exécution du script courant. Si d'autres traitements sont effectués à la suite de le fonction, ils seront exécutés.
     
    // "header()" doi être la dernière instruction du fichier ou appeler la fonction exit() ou die() tout de suite aprés. De même une fonction header() appelée sucessivement à une autre écrasera les entêtes de la première.




?>


superglobales :

session 

requete HTTP