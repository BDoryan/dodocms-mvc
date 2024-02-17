<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/othneildrew/Best-README-Template">
    <img src="https://i.ibb.co/tzw8HHt/Microsoft-Fluentui-Emoji-3d-Dodo-3d-1024-2.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center"><strong>DodoCMS</strong></h3>

  <p align="center">
    Le système de gestion de contenu simplifié créé spécifiquement pour mes clients.
    <br />
    <a href="https://github.com/othneildrew/Best-README-Template">Voir la démonstration</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">J'ai un problème</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Propositions</a>
  </p>
</div>
<br>

# Bienvenue !
Bienvenue dans la présentation de mon Content Management System (CMS) spécialement développé pour faciliter la création de sites internet et accélérer le processus de conception. Ce CMS a été conçu dans le but de répondre à mes propres besoins en tant que développeur, mais également pour offrir une solution efficace et flexible à mes futurs clients.

## Technologies utilisées :

Lors de la réflexion de ce projet, je me suis demandé quelles technologies utiliser pour sa conception. Après un petit temps de réflexion, j'ai donc choisi des technologies modern comme ancienne.

<ol>
    <li>HTML & CSS : Ces langages sont incontournables lorsqu'il s'agit de concevoir des sites internet.</li>
    <li>PHP (7.4 >= 8.4) : J'ai décidé d'utiliser ce langage pour le back-end, car il demeure aujourd'hui le plus largement utilisé.</li>
    <li>Vue.js : Fort de mon expérience avec des technologies telles que React.js et Next.js, j'ai jugé essentiel de faciliter l'intégration des éléments dynamiques en JavaScript, d'où mon choix de Vue.js.</li>
    <li>TailwindCSS : Mon objectif était de retrouver la rapidité de développement d'un framework graphique pour créer rapidement une interface visuelle, même si ce n'est pas la priorité actuelle.</li>
    <li>FontAwesome : Réaliser un visuel un minimum agréable (à mes yeux) j'ai voulu mettre en place des icons pour que cela parle plus à l'utilisateur.</li>
</ol>

### Utilisation de TailwindCSS dans le CMS

L'intégration de ce framework au sein du CMS n'est pas indispensable. J'ai expressément évité de l'imposer pour ne pas perturber les développeurs. Pour cette raison, j'ai instauré un préfixe spécifique au CMS (`tw-`) permettant une utilisation exclusive de TailwindCSS dans mon contexte d'utilisation.

### Utilisation du framework Vue.js

La mise en place de composant Vue.js est assez particulière, car j'ai dû l'adapter pour le bon fonctionnement du CMS. En effet, pour permettre de réaliser des composants à partir de `template` et pour permettre d'organiser simplement ça j'ai mis en place un classe `VueComponent` qui doit faire référence à un fichier `template` et un autre ficher JavaScript.  

#### VueComponent

```php
$this->addVueComponent(
    new VueComponent(
        $this->toRoot('/core/views/admin/vue/resource-viewer.php'),
        $this->toURL('/core/assets/js/vue/ResourceViewer.js')
    )
);
```

#### Fichier template
```html
<script type="text/x-template" id="resource-viewer-template">
    <div class="dodocms-relative dodocms-group dodocms-w-full dodocms-bg-gray-600 dodocms-rounded-lg dodocms-border-[1px] dodocms-border-gray-500 dodocms-shadow-lg dodocms-text-white dodocms-outline-none focus:dodocms-border-gray-400 dodocms-mb-1 dodocms-min-h-[400px] dodocms-flex dodocms-flex-col dodocms-overflow-hidden">
        <div class="dodocms-px-4 dodocms-py-2 dodocms-bg-gray-700 dodocms-border-b-[1px] dodocms-border-gray-500 dodocms-text-lg">
            {{ getTitle() }}
        </div>
        <div v-if="localItems.length > 0" class="dodocms-p-4 dodocms-h-full dodocms-w-full dodocms-grid dodocms-grid-cols-4 dodocms-gap-4">
            <resource-item
                    v-for="item in localItems"

                    :key="item.id"
                    :id="item.id"
                    :selectable="selectable"
                    :editable="editable"
                    :deletable="deletable"
                    :src="item.src"
                    :href="item.src"
                    :alternativeText="item.alternativeText"

                    @toggle="toggleItem($event)"
                    @edit="editItem($event)"
                    @delete="deleteItem($event)"
            >
            </resource-item>
        </div>
        <span v-if="localItems.length === 0"
          class="dodocms-text-gray-300 dodocms-mx-auto dodocms-m-auto dodocms-text-xl">
            <?= __('admin.panel.resources.empty') ?>
        </span>
</script>
```

#### JavaScript
```javascript
Vue.component('resource-viewer', {
    props: ['items', 'selectable', 'editable', 'deletable'],
    template: '#resource-viewer-template',
    data() {
        return {
            localItems: this.items ? [...this.items] : [],
            localSelectable: this.selectable ?? false
        };
    },
    methods: {
        toggleItem(item, toggled) {
            console.log('toggleItem', item, toggled)
        },
        editItem(item) {
            console.log('edit', item)
        },
        getStatus() {
            return "Aucun status défini";
        },
        getTitle() {
            return translate('admin.panel.resources.count', {'count': this.localItems.length});
        },
        deleteItem(id) {
            const index = this.localItems.findIndex((el) => el.id === id);
            if (index > -1) {
                this.$delete(this.localItems, index);
                this.localItems = [...this.localItems];
            }
        }
    }
});
```

## Fonctionnalités clés de mon CMS :
<ol>
    <li>
    <strong>Gestion des pages :</strong> Mon CMS permet de créer et gérer facilement les différentes pages du site internet. Vous pouvez créer de nouvelles pages, les organiser dans une structure hiérarchique, et les modifier en utilisant un éditeur de texte simple.
    </li>
    <li>
    <strong>Gestion des articles de blog :</strong> Avec mon CMS, vous pouvez créer et publier des articles de blog de manière facile et rapide. Vous pouvez les organiser par catégories, ajouter des images, gérer les commentaires, et même programmer leur publication à une date ultérieure.
    </li>
    <li>
    <strong>Personnalisation du design :</strong> Mon CMS offre des options de personnalisation flexibles pour adapter le design du site internet à vos besoins. Vous pouvez choisir parmi des modèles prédéfinis, personnaliser les couleurs, les polices et les styles, et même intégrer votre propre code CSS si nécessaire.
    </li>
    <li>
    <strong>Gestion des utilisateurs :</strong> Vous pouvez créer et gérer des comptes d'utilisateurs avec différentes permissions d'accès. Cela vous permet de collaborer avec d'autres contributeurs et de déléguer certaines tâches de gestion du contenu.
    </li>
    <li>
    <strong>Gestionnaire de modules :</strong> Mon CMS offre la possibilité d'ajouter des fonctionnalités supplémentaires grâce à un gestionnaire de modules. Vous pouvez facilement installer, activer et configurer des modules pour étendre les fonctionnalités de base du CMS.
    </li>
    <li>
    <strong>Optimisation pour les moteurs de recherche (SEO) :</strong> Mon CMS intègre des fonctionnalités d'optimisation pour les moteurs de recherche, telles que la possibilité de définir des balises de titre, des méta-descriptions et des URL conviviales. Cela vous aide à améliorer la visibilité de votre site internet dans les résultats de recherche.
    </li>
    <li>
    <strong>Sécurité et sauvegarde :</strong> J'ai mis en place des mesures de sécurité pour protéger votre site internet et vos données. De plus, des fonctionnalités de sauvegarde automatique sont intégrées pour éviter toute perte de données.
    </li>
</ol>