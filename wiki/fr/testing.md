# Tests & couverture

La bibliothèque est livrée avec une suite PHPUnit complète tournant en **mode
strict** et couvrant **100 % des lignes**.

## Lancer la suite

```bash
composer test
```

Lancer un seul cas de test :

```bash
./vendor/bin/phpunit --filter CompositeLoggerTest
```

## Mesurer la couverture

La couverture nécessite **Xdebug** ou **PCOV**.

```bash
composer coverage        # texte + Clover + HTML sous build/coverage/
composer coverage:md     # résumé Markdown lisible (build/coverage/COVERAGE.md)
```

`build/` est **gitignoré** : la couverture est un instantané qui devient obsolète
au commit suivant ; elle est donc régénérée à la demande plutôt que commitée.
`composer coverage:md` tient aussi un petit journal de tendance local
(`build/coverage/history.json`) afin que chaque exécution montre l'écart depuis
la précédente.

## Mode strict

`phpunit.xml` active `failOnRisky`, `failOnWarning`, `failOnSkipped`,
`failOnIncomplete` et `failOnEmptyTestSuite`. Autrement dit : avertissements,
tests risqués (sans assertion) et tests ignorés font **échouer** l'exécution. Un
test qui ne vérifie rien ne protège rien.

## Philosophie de test

- La couverture mesure quelles lignes ont **été exécutées**, pas quels
  comportements sont **vérifiés** — 100 % de couverture ne signifie pas zéro bug.
- Lorsque vous découvrez un comportement surprenant, **figez-le dans un test**
  avant de changer quoi que ce soit : d'autres bibliothèques peuvent en dépendre.
- Testez tout ce qui est atteignable ; n'annotez une ligne `@codeCoverageIgnore`
  que lorsqu'elle est réellement impossible à atteindre (p. ex. une garde
  défensive que la surface publique ne peut déclencher).

## Intégration continue

Chaque push et pull request lance la suite sur PHP 8.4 via GitHub Actions
(`.github/workflows/ci.yml`) ; la documentation API est construite et déployée
sur GitHub Pages par `.github/workflows/docs.yml`.
