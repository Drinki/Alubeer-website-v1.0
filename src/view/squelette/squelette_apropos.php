<div class="container">
  <div class="collection">
    <hr class="hr_small">
    <h1>A propos</h1>
    <hr class="hr_small">
  </div>

  <h2>Auteur : 21706521</h2>
  <p>Bienvenue sur Alubeer, le site de présentation des bières en canette. Sur cette page je vais vous présenter mon site et expliquer son développement. Ceci va se diviser en trois partie, la modélisation du site, le code et le choix du design.</p>

  <h3>La modélisation : </h3>
  <p>Le site est structuré sur la base du modèle MVCR, j’ai donc trois répertoires pour les classes de modèles, de vues et de contrôles, ainsi qu’une classe Router.php. </p>

  <ol>
    <li>
      Dans le modèle, je vais gérer la création des comptes utilisateurs et des fichiers personnelles des bières ainsi que leur stockage et leur management. Pour le management des comptes cela va gérer la connexion, l’inscription et la déconnexion, pour le management des bières, on va gérer l’ajout, l’édition et la suppression de celle-ci.
    </li>
    <li>
      Dans le contrôleur, je vais avoir une simple classe de contrôle qui va afficher les différentes pages en fonction de si l’on est connecté ou non, ou si la bière sélectionne a été ajouté par nous.
    </li>
    <li>
      Dans la vue, je vais avoir deux classes, une pour la vue en mode non-connecté et une pour la vue en mode connecté. Ces classes permettent la création du HTML et l’implémentation des squelettes (qui contiennent du HTML aussi) pour certaines pages.
    </li>
    <li>
      Le router est la classe qui va gérer la création des différentes instances (instance de la base de données, du contrôleur et de la vue) ainsi que l’affiche des page en fonction de L’URL.
    </li>
  </ol>

  <h3>Le code : </h3>
  <h4> - Les comptes utilisateurs</h4>
  <p>Pour la création d’un compte on a la méthode « register » dans la classe « AuthentificationManager.php » qui est une suite de conditions à respecté (comme pour l’ajout d’une bière). Les données sont ajoutées à la base de donnée en n'oubliant pas d’encoder le mot de passe choisie. On peut ensuite se connecter grâce à la méthode « login », qui va vérifier s’il a une correspondance entre les informations renseigné dans le formulaire et une des lignes de la base de données. Si c’est le cas, on démarre une session. Pour la déconnexion dans la méthode « logout » on détruit la session et on vide le tableau de session « $_SESSION ».
  </p>

  <h4> - Les pages individuelles de bières</h4>
  <p>Pour l’ajout de bière sur le site on a une méthode « add » dans la classe « BeerManager.php ». Cette méthode est une suite de conditions pour vérifier le bon remplissage du formulaire (tout les champs remplis, nombre de caractères pas trop élevé, etc …) . Une fois les conditions respectées, la bière est ajouté à la base de données avec une préparation des données suivit de leur exécution (pour éviter les fuites durant l’injection). Dans la classe « BeerManager.php » on a aussi la méthode « edit » qui à la différence de « add », va actualiser les données remplis dans le formulaire, mais on est pas obligé de respecter les même condition que pour l’ajout (par exemple on est pas obligé de remplir tout les champs si l’on veut modifier qu’une information).
  Pour la gestion des droits d’accès aux bières en fonction de l’utilisateur, on a une méthode « getAccessBeerUser » dans le router qui renvoie un tableau de toutes les bières que l’utilisateur à ajouter et donc peut modifier ou supprimer.</p>

  <h3>Le design : </h3>
  <p>Pour le design on a quelque chose de sobre mais fonctionnel. Toutes les pages sont accessibles facilement pour que la navigation se fasse de façon fluide. Les bières sont présentées par ranger de trois pour pas que la page soit surchargé. Quand l’on passe la souris sur une des bières, l’encadré change de couleur en fonction de la couleur de la bière (blonde, brune, ambrée, etc…) et une partie des infos s’affiche (le nom, la couleur et prix de la bière). Le logo du site est quelque chose de simple, mais on peut retrouver toutes les couleurs des bières dedans.</p>

</div>
