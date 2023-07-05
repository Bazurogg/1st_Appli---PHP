
<?php

// limiter l'accés à "traitement.php"
// Vérification de l'existence de la clé "submit" dans le tableau $_POST
// Correspondant à l'attribut "name" du bouton du formulaire
// La condition est alors vraie seulement si la requête POST transmet bien une clé "submit" au serveur

    session_start();

    if(isset($_GET['action'])){

        switch($_GET['action']){

            case "add":
                
                if(isset($_POST['submit'])){
                    
                    // Vérification de l'intégrité des valeurs transmises dans le tableau $_POST en fonction de celles attendue réellement.
            
                    // "filter_input()" fonction php qui effectue une validation ou nettoyage de chaque données transmises par le formulaire via divers filtres.
                    
                    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
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
                            "total" => $price*$qtt,
                        ];
            
                        $_SESSION['products'][] = $product; // on sollicite le tableau de session $_SESSION fourni par PHP
            
                        // on indique la clé "products" de ce tableau. Si cette clé n'existais pas auparavant (ex: ajouts par l'utilisateur de son tout 1er produit) elle est créée au sein de $_SESSION par PHP.
            
                        // "[]" raccourci pour indiquer à cet emplacement que nous ajoutons une nouvelle entrée au futur tableau "products" associé  à cette clé.
            
                        // $_SESSION["products"] doit être un tableau lui aussi afin d'y stocker de nouveaux produits.
            
                        $_SESSION['alert'] = "Bravo ! Vous avez bien ajouté un nouveau produit.";
            
                    }
                    
                    else $_SESSION['alert'] = "Erreur ! remplissez entièrement le formulaire.";
            
                }
                break;
               


            case "delete":

                if (isset($_SESSION['products'])){

                    unset($_SESSION['products']);

                    $_SESSION['alert'] = "Tous les articles ont été supprimés !.";
                
                }
                break;

            case "deleteItem":
                
                if (isset($_GET['id'] ) && (isset($_SESSION['products'][$_GET['id']]))){ // Vérification si "action est bien appelé vai l'url.

                    unset($_SESSION['products'][$_GET['id']]);
                    $_SESSION['products'] = array_values($_SESSION['products']);
                    
                    header("location:recap.php");
                    
                    $_SESSION['alert'] = "Le produit a été supprimé.";
                    
                    die(); //On stop l'exécution du script similaire à "exit()"

                }
                break;

            case "increaseItem":

                if (isset($_GET['id'] ) && (isset($_SESSION['products'][$_GET['id']]))){

                    $index = $_GET['id']; // Affectation de l'index la valeur "id" récupérer par la méthode $_GET.
                    
                    $_SESSION['products'][$index]['qtt']++;  // on incrémente la valeur de "qtt" de l'index correspondant.

                    $_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['price']*$_SESSION['products'][$index]['qtt'];
    
                    header("location:recap.php");

                    die();

                }
                break;
                
            case "decreaseItem":
                
                if (isset($_GET['id'] ) && (isset($_SESSION['products'][$_GET['id']]))){

                    $index = $_GET['id'];

                    if ($_SESSION['products'][$index]['qtt'] > 1){ // On veux que lorsque la quantité tombe à zéro on supprime le produit cible.

                        $_SESSION['products'][$index]['qtt']--; // On décrémente la "qtt" de l'index correspondant.

                        $_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['price']*$_SESSION['products'][$index]['qtt'];
        
                        header("location:recap.php");
    
                        die();

                    } else {

                        unset($_SESSION['products'][$index]);
                        
                        $_SESSION['alert'] = "Le produit a été supprimé.";
                        
                        header("location:recap.php");

                        die();
                    }
                    

                }
                break;


            case "":
                
                break;

        }            
                        
    }


    header("Location:index.php"); // Redirection vers le formulaire
    // Pas de else à la condition puisque nous souhaitons le retour aprés le traitement que le formulaire ai été soumis ou non.

    // Elle n'arrête pas l'exécution du script courant. Si d'autres traitements sont effectués à la suite de le fonction, ils seront exécutés.
     
    // "header()" doi être la dernière instruction du fichier ou appeler la fonction exit() ou die() tout de suite aprés. De même une fonction header() appelée sucessivement à une autre écrasera les entêtes de la première.




?>

<!--
     
superglobales : Des variables prédéfinies en PHP disponibles quelque soit le contexte (global ou local) du script. Il n'est pas nécessaire de faire "global $variable" avant d'y accéder dans les méthodes et fonctions. Variables natives à PHP.
    
session : 

Tableau associatif des valeurs stockées (données de session) transmises de page en page par le serveur et non par le client(Cela assure ainsi la sécurité et l'intégrité des données et leurs disponibilité.). Il faut au préalable activer les sessions en appelant la fonction : "session_start()".

Les données de session sont sauvegardées côté serveur. La session conserve ces informations pendant quelques minutes contrairement à une base de données ou un système de fichiers. Cette durée dépend de la configuration du serveur.

Les données individuelles de chaque utilisateurs sont stockées en utilisant un identifiant de session unique. Cet identifiant peut-être transmis soit en GET (PHPSESSID ajouté à la fin de l'URL), en POST ou en Cookie selon la configuration du serveur là aussi.

Ces identifiants sont envoyés vers le navigateur via des cookies de session et on récupère les données existantes de la session grâce à l'identifiant.

Une session peut contenir tout type de données :

_nombre
_chaînes de caractères
_tableau

Quelques cas d'utilisation :
_espaces membres et accés sécurisé avec authentification
_gestion de caddie sur site d'e-commerce
_formulaires éclatés sur plusieurs pages
_stockage d'info relatives à la navigation de l'utilisateur (thème, langue, etc.).



requête HTTP : via le protocole HTML qui contrôle la façon dont l'utilisateur formule ses demandes et la façon dont le serveur y répond. Ce protocole connaît différentes méthodes de requêtes :

_ GET : query string
_ POST
_ HEAD
_ OPTIONS
_ TRACE

-->