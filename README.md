## Openclassrooms : Testez unitairement votre application

*Ce projet est un résumé des informations essentiels de  : https://openclassrooms.com/fr/courses/4087056-testez-unitairement-votre-application-php-symfony*

### Bundles
PHPUnit : ```composer require --dev phpunit/phpunit```

PHPUnit Bridge : ```composer require --dev symfony/phpunit-bridge```

### Executer les tests
##### Executer tout les tests : ```vendor/bin/phpunit```
Exemple :
```
PHPUnit 9.6.13 by Sebastian Bergmann and contributors.

Testing
.....                                                               5 / 5 (100%)

Time: 00:00.047, Memory: 8.00 MB

OK (5 tests, 5 assertions)
```
---
##### Tester une méthode spécifique avec ses @dataProvider : ```vendor/bin/phpunit --filter=testNomDeNotreMethode``` 
Exemple :
```
PHPUnit 9.6.13 by Sebastian Bergmann and contributors.

Testing
...                                                                 3 / 3 (100%)

Time: 00:00.046, Memory: 8.00 MB

OK (3 tests, 3 assertions)
```
---
##### Afficher le nom des méthodes et le résultat : ```vendor/bin/phpunit --testdox```
Exemple :
```
PHPUnit 9.6.13 by Sebastian Bergmann and contributors.

Testing
Product (App\Tests\Entity\Product)
 ✔ Compute TVA food product with data set 0
 ✔ Compute TVA food product with data set 1
 ✔ Compute TVA food product with data set 2
 ✔ Compute TVA other product
 ✔ Negative price compute TVA

Time: 00:00.049, Memory: 8.00 MB

OK (5 tests, 5 assertions)
```

### XDebug 
- ```php -i``` (copier coller le contenu sur xdebug.org/wizard)
- ajouter le ```php_xdebug.dll``` dans ```ext/"```
- ajouter le dans ```php.ini```

### Générer le rapport de taux de couverture de code 
- ```vendor/bin/phpunit --coverage-html public/test-coverage```
- ```ls -lah public/test-coverage``` (Lister le contenu du fichier /test-coverage)

### Les 3 types de doublures
1. **Mock** ```Un Mock est un faux objet qui imite un objet réel. Il est utilisé pour simuler le comportement d'une classe ou d'une interface. Vous pouvez contrôler son comportement et vérifier qu'il est utilisé comme prévu.```
    
    *Exemple:* ```Imaginons que vous ayez une classe EmailService qui envoie des e-mails. Pour tester une autre classe qui utilise EmailService sans envoyer de vrais e-mails, vous pouvez créer un Mock de EmailService.```
---
2. **Dummy** ```Un Dummy est un objet très simple qui est juste là pour être passé comme paramètre mais qui n'est pas réellement utilisé. Il n'a pas de comportement.```
    
    *Exemple:* ```Disons que vous avez une méthode qui nécessite un objet Logger en paramètre, mais vous ne vous en servez pas dans le cadre de votre test.```
---
3. **Stub** ```Un Stub est comme un Dummy, mais avec un comportement prévu. Vous pouvez définir des valeurs de retour pour certaines méthodes.```
    
    *Exemple:* ```Vous avez une classe Database et vous ne voulez pas faire de vraies requêtes dans vos tests. Vous pouvez créer un Stub de Database.```

### Le TDD (Test Driven Development)

On utilise des outils comme Travis CI pour notre cycle d'intégration continue : ```L'outil d'intégration continue permet de lancer l'ensemble des autres outils le plus rapidement possible, afin de valider un build avant d'entamer un déploiement ou une fusion de branche, par exemple.```

---
---
---

## Openclassrooms : Testez fonctionnellement votre application

*Ce projet est un résumé des informations essentiels de : https://openclassrooms.com/fr/courses/4087076-testez-fonctionnellement-votre-application-php-symfony*

### Bundles
1. DAMA Doctrine Test Bundle : ```composer require --dev dama/doctrine-test-bundle``` (Ce bundle nous permet de ne pas modifier réellement notre BDD)

2. Behat favorise la méthode BDD (Behaviour Development Driven), axée sur l'idée que la logique business est au centre de tous les choix de développement. La manière d'écrire les tests se veut la plus humaine possible, et toujours autour de scénarios de tests ;
3. Selenium permet d'automatiser et simuler de vrais navigateurs ;
4. PHPSpec facilite le TDD (Test Driven Development) en vous forçant à décrire le comportement de la classe que vous serez sur le point de développer.  