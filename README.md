Delivery Date v1.0
==================
author: Thelia <info@thelia.net>

Summary
-------

fr_FR:
1.  Installation
2.  Utilisation
3.  Boucle
4.  Intégration

en_US:
1.  Install notes
2.  How to use
3.  Loop
4.  Integration

fr_FR
-----

### Installation
Pour installer le mode Date de livraison, téléchargez l'archive et décompressez la dans <dossier de Thelia>/local/modules

### Utilisation
Tout d'abord, activez le module en allant dans le back office, onglet Modules, puis cliquez sur Configurer sur la ligne du module.
Rentrez vos temps de livraison et de réapprovisionnement par défault et cliquez sur Enregistrer.

Vous pouvez aussi préciser des valeurs spécifiques pour chaque déclinaison de produit.
Pour cela allez sur la page d'édition du produit, onglet Modules.

### Boucle

1.  delivery.date
    - Arguments:
        1. productid | obligatoire | id de de la déclinaison de produit désirée (product_sale_element)
    - Sorties:
        1. \$DATE_MIN: date minimale formatée où le produit peut être reçu
        2. \$DATE_MAX: date maximale formatée où le produit peut être reçu
        3. \$QUANTITY: Quantité en stock du produit
    - Utilisation:
        ```{loop type="delivery.date" name="yourloopname" productid=\$ID}
            <!-- your template -->
        {/loop}```

### Intégration
Vous pouvez afficher les dates de livraison sur les pages de produit. Un exemple d'intégration est proposé pour le thème par default de Thelia,
pour l'installer, copiez les fichiers <dossier du module>/templates/frontOffice/default/product.html et
<dossier du module>/templates/frontOffice/default/assets/js/script.js respectivement dans le dossier templates/frontOffice/default et
templates/frontOffice/default/assets/js/ de Thelia.

Les modifications des fichiers sont sont entourées par des commentaires, vous avez juste à chercher: Product delivery date
Dans product.html, une balise <div> est ajoutée avec deux attributs:
    - id: identifiant unique utilisé pour accéder à la balise en javascript
    - data-href: contient l'url de la route qui génère la date de livraison de la déclinaison de produit.
Elle est placée le carde du prix du produit.
Dans script.js, un appel ajax est fait sur l'adresse contenu dans l'attribut data-href de la balise <div> précédement ajoutée
quand une déclinaison de produit est selectionnée.
La réponse est placée dans cette même balise.

De plus, vous pouvez ajouter ces valeurs dans vos mails en utilisant la boucle delivery.date qui fourni trois valeurs:
{\$QUANTITY}, {\$DATE_MIN} et {\$DATE_MAX}.
Un exemple d'utilisation de cette boucle est présent dans <dossier du module>/templates/frontOffice/default/delivery-date.html

en_US
-----

### Install notes
To install this module, download the archive and uncompress it the directory <path to Thelia>/local/modules

### How to use
First, activate the module in your Back-Office, tab Modulesn then click on Configure on the line of the module.
Enter your default delivery and restock time and click the Save button.

You can also specify other values for each product, by going to your product's page in the back-office, tab Modules.

### Loop

1.  delivery.date
    - Arguments:
        1. productid | mandatory | id of the product sale element
    - Output:
        1. \$DATE_MIN: formated minimal date where the product may be received by the customer
        2. \$DATE_MAX: formated maximal date where the product may be received by the customer
        3. \$QUANTITY: stock quantity of the product
    - Usage:
        ```{loop type="delivery.date" name="yourloopname" productid=\$ID}
            <!-- your template -->
        {/loop}```

### Integration
You can show the delivery dates on the page of the product in your front Office. An integration example is available in this module.
You only have to copy the files <path to the module>/templates/frontOffice/default/product.html and <path to the module>/templates/frontOffice/default/assets/js/script.js
respectively in Thelia's directory templates/frontOffice/default and templates/frontOffice/default/assets/js/

The modifications in the files are surrounded by comments, you only have to search: Product delivery date
In product.html, a <div> tag is added with two attributes:
    - id: unique ID to access the tag in javascript
    - data-href: contains the address of the route that generates to delivery dates.
The tag is placed in the product's price frame.
In script.js, an ajax call is done on the address of the attribute data-href of the <div> tag previously added when a new product attribute is selected.
The response is placed in the tag.

Moreover, you can add those values in your mails, using delivery.date loop that give three values:
{\$QUANTITY}, {\$DATE_MIN} et {\$DATE_MAX}.
A usage example of the loop is available in <path to the module>/templates/frontOffice/default/delivery-date.html