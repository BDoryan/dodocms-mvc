# Documentation de DodoCMS

## Introduction

## Models

## Blocs

### Créer un nouveau bloc

#### Créer un bloc qui peut être éditée

Lorsque vous allez tapper les balises de votre bloc, vous devez ajouter l'attribut `editable={variable}` à votre balise.

```html
<div class="container">
    <h1 editable="title">Mon super titre éditable</h1>
</div>
```

#### Afficher du contenu de la base de donnée

Vous avez la possibilité d'afficher du contenu de la base de donnée dans votre bloc. Pour cela, vous allez devoir définir différents attributs à vos balises.

Exemple de code :
```php
<div class="container">
    <div class="row" model-name="{nom_de_la_table_de_votre_modele}">
        <div class="col-4" entity-id="{id_de_votre_entite}">
            <h1 model-editable="title"><?= $model->getTitle() ?></h1>
        </div>
    </div>
</div>
```

### Modifier le contenu d'un bloc d'une page

### Retirer un bloc d'une page